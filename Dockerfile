FROM php:8.3-apache

# Ativa mod_rewrite (importante para projetos futuros)
RUN a2enmod rewrite

# Instala extensões básicas (banco de dados, etc.)
RUN docker-php-ext-install pdo pdo_mysql

# Instala curl (necessário para chamadas de API)
RUN apt-get update && apt-get install -y curl && rm -rf /var/lib/apt/lists/*

# Ajusta permissões do Apache para apontar para o diretório public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copia arquivo .env (se existir)
COPY .env* /var/www/html/

WORKDIR /var/www/html