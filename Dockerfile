FROM php:7.4.29

RUN docker-php-ext-install pdo pdo_mysql
