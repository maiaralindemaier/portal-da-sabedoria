FROM php:8.3-apache

# Ativa mod_rewrite (importante para projetos futuros)
RUN a2enmod rewrite

# Instala extensões básicas (banco de dados, etc.)
RUN docker-php-ext-install pdo pdo_mysql

# Instala curl e outras ferramentas necessárias
RUN apt-get update && apt-get install -y curl zip unzip git && rm -rf /var/lib/apt/lists/*

# Instala Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Ajusta permissões do Apache para apontar para o diretório public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copia arquivo .env (se existir)
COPY .env* /var/www/html/

WORKDIR /var/www/html