# Portal da Sabedoria

Aplicação PHP simples que integra com a API Gemini para fornecer respostas estilo "Gênio". Este README descreve as tecnologias usadas, como configurar, executar em Docker e rodar os testes.

**Status:** funcional em container Docker (acessar em `http://localhost:8080`).

---

**Tecnologias**
- PHP 8.3
- Apache (imagem oficial `php:8.3-apache`)
- Docker + Docker Compose
- Composer (gerenciador de dependências PHP)
- PHPUnit (teste unitário)

---

**Requisitos locais**
- Docker e Docker Compose instalados na máquina.
- (Opcional) Composer se preferir rodar localmente fora do container.

---

**Instalação e execução (modo recomendado: Docker)**

1. Clone o repositório:

```bash
git clone <URL-DO-REPOSITORIO> portal-da-sabedoria
cd portal-da-sabedoria
```

2. (Opcional) Edite o arquivo `.env.example` e copie para `.env` ou crie `.env` com sua chave:

```text
GEMINI_API_KEY=seu_token_aqui
```

3. Recrie a imagem Docker (necessário quando o `Dockerfile` mudou):

```bash
docker-compose build --no-cache php
```

4. Suba os serviços em segundo plano:

```bash
docker-compose up -d
```

5. Abra no navegador:

```
http://localhost:8080
```

---

**Composer e testes via Docker**

Como o projeto já instala o Composer no container, rode comandos Composer através do serviço `php`:

Instalar dependências:

```bash
docker-compose run --rm php composer install
```

Executar testes PHPUnit:

```bash
docker-compose run --rm php composer test
```

Se o container já estiver rodando, prefira `exec`:

```bash
docker-compose exec php composer test
```

---

**Configuração do GitHub Actions (CI)**

O repositório já inclui um workflow básico em `.github/workflows/tests.yml` que:
- instala as dependências via Composer;
- executa `composer test` em `php 8.3`;
- usa a secret `GEMINI_API_KEY` (adicione no repo Settings → Secrets)

Para habilitar o CI, faça push para o repositório remoto. Certifique-se de configurar a secret `GEMINI_API_KEY` no repositório no GitHub.

---

**Boas práticas e observações**
- Nunca versionar o arquivo `.env` com chaves sensíveis (o `.gitignore` já inclui `.env`).
- Nos testes, a chamada real à API deve ser substituída por mocks para evitar dependências externas e taxas. Há testes básicos no diretório `tests/` — considere aplicar mocks ao `IAService` antes de testar integração.
- Se seu ambiente local não tiver `composer`, use sempre o Composer dentro do container (conforme instruções acima).

---

**Contribuindo**
- Abra uma issue para descrever a melhoria ou um bug.
- Para mudanças pequenas: crie uma branch, faça commits claros e abra um pull request.

---

