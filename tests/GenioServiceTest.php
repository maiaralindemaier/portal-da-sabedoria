<?php

// Testes básicos da classe GenioService
class GenioServiceTest
{
    public function testFormatarResposta()
    {
        require_once __DIR__ . '/../src/GenioService.php';
        $genioService = new GenioService();
        
        $resposta = "Teste de resposta";
        $resultado = $genioService->formatarResposta($resposta);
        
        assert(strpos($resultado, "🧞 O Gênio revela:") !== false, "Resposta deveria conter o prefixo do Gênio");
        assert(strpos($resultado, $resposta) !== false, "Resposta deveria conter o texto original");
    }
}

// Executar testes
$teste = new GenioServiceTest();
$teste->testFormatarResposta();
echo "✓ Todos os testes de GenioService passaram!\n";
