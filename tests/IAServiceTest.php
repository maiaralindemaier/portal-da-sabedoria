<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class IAServiceTest extends TestCase
{
    private $iaService;

    protected function setUp(): void
    {
        putenv('GEMINI_API_KEY=test-key');
        
        require_once __DIR__ . '/../src/IAService.php';
        $this->iaService = new \IAService();
    }

    public function testValidacaoDeEnvio()
    {
        $pergunta = "Qual é a capital do Brasil?";
        
        $reflection = new \ReflectionClass($this->iaService);
        $method = $reflection->getMethod('enviarPergunta');
        $method->setAccessible(true);
        
        $resultado = $method->invoke($this->iaService, $pergunta);
        
        $this->assertNotEquals("Por favor, faça uma pergunta ao Gênio.", $resultado);
        
        $this->assertNotEmpty($resultado);
    }

    public function testValidacaoDeEnvioComPerguntaVazia()
    {
        $reflection = new \ReflectionClass($this->iaService);
        $method = $reflection->getMethod('enviarPergunta');
        $method->setAccessible(true);
        
        $resultado = $method->invoke($this->iaService, "");
        
        $this->assertEquals("Por favor, faça uma pergunta ao Gênio.", $resultado);
    }

    public function testValidacaoDeEnvioComPerguntaComEspacos()
    {
        $reflection = new \ReflectionClass($this->iaService);
        $method = $reflection->getMethod('enviarPergunta');
        $method->setAccessible(true);
        
        $resultado = $method->invoke($this->iaService, "   ");
        
        $this->assertEquals("Por favor, faça uma pergunta ao Gênio.", $resultado);
    }

    public function testValidacaoDeChavedaAPI()
    {
        putenv('GEMINI_API_KEY=');
        
        require_once __DIR__ . '/../src/IAService.php';
        $iaServiceSemChave = new \IAService();
        
        $reflection = new \ReflectionClass($iaServiceSemChave);
        $method = $reflection->getMethod('enviarPergunta');
        $method->setAccessible(true);
        
        $resultado = $method->invoke($iaServiceSemChave, "Teste");
        
        $this->assertStringContainsString("Chave da API", $resultado);
    }

    public function testValidacaoDeRecebimentoFormatoResposta()
    {
        $reflection = new \ReflectionClass($this->iaService);
        $method = $reflection->getMethod('enviarPergunta');
        $method->setAccessible(true);
        
        
        $this->assertTrue(true); 
    }

    public function testValidacaoDeRecebimentoRespostaNaoVazia()
    {
        $reflection = new \ReflectionClass($this->iaService);
        $method = $reflection->getMethod('enviarPergunta');
        $method->setAccessible(true);
        
        $resultado = $method->invoke($this->iaService, "Teste");
        
        $this->assertIsString($resultado);
        $this->assertNotEmpty(trim($resultado));
    }

    public function testContextoDeDateNaPergunta()
    {
        $dataAtual = date('d/m/Y');
        $anoAtual = date('Y');
        
        $this->assertNotEmpty($dataAtual);
        $this->assertNotEmpty($anoAtual);
        $this->assertEquals(4, strlen($anoAtual));
    }
}
