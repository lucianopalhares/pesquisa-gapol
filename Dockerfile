# Use a imagem oficial do PHP 8.1 com Apache
FROM php:8.1-apache

# Instale extensões e dependências necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Instale o Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Habilite o mod_rewrite do Apache
RUN a2enmod rewrite

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos da aplicação para o contêiner
COPY . .

# Instale as dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Configure permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponha a porta padrão do Apache
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
