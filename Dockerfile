FROM php:5.5.38-fpm-alpine
RUN docker-php-ext-install pdo pdo_mysql mysqli