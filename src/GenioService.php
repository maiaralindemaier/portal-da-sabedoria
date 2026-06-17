<?php

class GenioService
{
    public function formatarResposta(string $resposta): string
    {
        return "🧞 O Gênio revela:\n\n" . $resposta;
    }
}