# Use a imagem base do PHP com Apache
FROM php:8.1-apache

# Instalar a extensão PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copiar arquivos da aplicação
COPY src/ /var/www/html/

# Configurar permissões e outros ajustes necessários
RUN chown -R www-data:www-data /var/www/html

# Ativar mod_rewrite se necessário
RUN a2enmod rewrite

# Adicionar configuração do Apache para permitir .htaccess
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf
