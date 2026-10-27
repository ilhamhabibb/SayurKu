FROM php:8.2-apache

RUN apt-get upodate && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install \
    intl \
    mbstring \
    mysqli \
    pdo_mysql \
    zip \
    gd

RUN a2enmode rewrite

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/site-available/000-default.conf
RUN sed -i 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/writable /var/www/html/public

EXPOSE 80