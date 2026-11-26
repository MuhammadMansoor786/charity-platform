FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo_mysql

ENV PORT=80

WORKDIR /var/www/html
COPY *.php ./

CMD ["sh", "-c", "port=${PORT:-80}; sed -i \"s/Listen 80/Listen ${port}/\" /etc/apache2/ports.conf; sed -i \"s|<VirtualHost \\\\*:80>|<VirtualHost *:${port}>|\" /etc/apache2/sites-available/000-default.conf; exec apache2-foreground"]
