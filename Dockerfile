# Use a imagem base do PHP com Apache
FROM php:8.1-apache

# Instalar extensões e ferramentas necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql

# Ativar mod_rewrite para Apache
RUN a2enmod rewrite

# Copiar arquivos da aplicação para o diretório padrão do Apache
COPY ./public /var/www/html

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configurar o Apache para usar o novo DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Expor a porta padrão do Apache
EXPOSE 80

# Comando para iniciar o Apache no modo foreground
CMD ["apache2-foreground"]
