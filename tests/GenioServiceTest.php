<?php

use PHPUnit\Framework\TestCase;

final class GenioServiceTest extends TestCase
{
    protected function setUp(): void
    {
        require_once __DIR__ . '/../src/GenioService.php';
    }

    public function testFormatarResposta(): void
    {
        $genioService = new GenioService();

        $resposta = "Teste de resposta";
        $resultado = $genioService->formatarResposta($resposta);

        $this->assertStringContainsString("🧞 O Gênio revela:", $resultado);
        $this->assertStringContainsString($resposta, $resultado);
    }
}
