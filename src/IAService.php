    <?php

    class IAService
    {
        private string $apiKey;
        private string $apiUrl ="https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent";

        public function __construct()
        {
            $this->carregarEnv();
            $this->apiKey = getenv('GEMINI_API_KEY') ?: ($_ENV['GEMINI_API_KEY'] ?? '');
        }

        private function carregarEnv(): void
        {
            $envFile = __DIR__ . '/../.env';
            if (!file_exists($envFile)) {
                return;
            }

            $linhas = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($linhas as $linha) {
                $linha = trim($linha);
                if ($linha === '' || str_starts_with($linha, '#')) {
                    continue;
                }

                if (strpos($linha, '=') === false) {
                    continue;
                }

                [$chave, $valor] = explode('=', $linha, 2);
                $chave = trim($chave);
                $valor = trim($valor);

                // Não sobrescreve variáveis de ambiente já definidas
                if (getenv($chave) !== false || array_key_exists($chave, $_ENV) || array_key_exists($chave, $_SERVER)) {
                    continue;
                }

                $_ENV[$chave] = $valor;
                putenv("$chave=$valor");
                $_SERVER[$chave] = $valor;
            }
        }

        public function enviarPergunta(string $pergunta): string
        {
            if (empty(trim($pergunta))) {
                return "Por favor, faça uma pergunta ao Gênio.";
            }

            if (empty($this->apiKey)) {
                // Ler novamente da variável de ambiente para garantir consistência
                $this->apiKey = getenv('GEMINI_API_KEY') ?: ($_ENV['GEMINI_API_KEY'] ?? '');
            }

            if (empty($this->apiKey)) {
                return "Erro: Chave da API Gemini não configurada.";
            }

            return $this->chamarGemini($pergunta);
        }

        private function chamarGemini(string $pergunta): string
        {
            $dataAtual = date('d/m/Y');
            $anoAtual = date('Y');
            
            $contexto = "Data atual: $dataAtual (Ano: $anoAtual)\n" .
                        "Por favor, fornça informações atualizadas considerando a data atual acima. " .
                        "Use dados e eventos recentes até $dataAtual.\n\n";
            
            $perguntaComContexto = $contexto . $pergunta;

            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $perguntaComContexto]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95
                ]
            ];

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $this->apiUrl . "?key=" . $this->apiKey,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_TIMEOUT => 30
            ]);

            $resposta = curl_exec($ch);
            $erro = curl_error($ch);
            curl_close($ch);

            if ($erro) {
                return "Erro ao conectar com a API: " . $erro;
            }

            $dados = json_decode($resposta, true);
            if (isset($dados['candidates'][0]['content']['parts'][0]['text'])) {
                return "🧞 O Gênio revela:\n\n" . $dados['candidates'][0]['content']['parts'][0]['text'];
            }

            return "O Gênio não conseguiu formular uma resposta no momento.";
        }
    }
