FROM php:8.2-apache

COPY . /var/www/html/

RUN mv /var/www/html/roblox.php /var/www/html/index.php || true

EXPOSE 80
