FROM php:7.1-fpm
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
