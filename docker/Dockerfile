FROM php:7.4-apache

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

COPY php.ini /usr/local/etc/php/php.ini 

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
   && chmod +x /usr/local/bin/composer \
    && apt-get update && \ 
        apt-get install \
        libzip-dev \
        wget \
        git \
        unzip \
    -y --no-install-recommends

RUN docker-php-ext-install zip pdo_mysql \
     && pecl install xdebug \
     && docker-php-ext-enable xdebug


WORKDIR /var/mvc-0.2
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/mvc-0.2

CMD ["apache2-foreground"]