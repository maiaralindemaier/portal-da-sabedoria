<?php

require_once __DIR__ . '/../src/IAService.php';

$resposta = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pergunta = $_POST["pergunta"] ?? "";

    if (!empty(trim($pergunta))) {
        $iaService = new IAService();
        $resposta = $iaService->enviarPergunta($pergunta);
    } else {
        $resposta = "Por favor, faça uma pergunta ao Gênio.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pergunte ao Gênio</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="container">

        <h1>🧞 Pergunte ao Gênio</h1>

        <p>
            Faça sua pergunta e receba a orientação do Gênio do Conhecimento.
        </p>

        <form method="POST">

            <textarea
                name="pergunta"
                placeholder="Digite sua pergunta..."
                rows="5"
                cols="50"></textarea>

            <br><br>

            <button type="submit">
                Invocar Gênio
            </button>

        </form>

        <div class="resposta">
            <?= $resposta ?: "A resposta do Gênio aparecerá aqui..." ?>
        </div>

    </div>

</body>
</html>