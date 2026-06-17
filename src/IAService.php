<?php

class IAService
{
    public function enviarPergunta(string $pergunta): string
    {
        if (empty(trim($pergunta))) {
            return "Por favor, faça uma pergunta ao Gênio.";
        }

        return "O conhecimento está sendo consultado...";
    }
}