<?php
// Bootstrap file for PHPUnit tests
// Carrega as variáveis de ambiente para testes

if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            [$key, $value] = explode('=', $line, 2);
            putenv(trim($key) . '=' . trim($value));
        }
    }
}

// Se não encontrou .env, usa valores padrão para testes
if (!getenv('GEMINI_API_KEY')) {
    putenv('GEMINI_API_KEY=test-key-for-ci-cd');
}
