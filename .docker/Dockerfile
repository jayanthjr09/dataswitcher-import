FROM php:8.0-cli
WORKDIR /var/task

RUN apt-get update
RUN apt-get -y install git

RUN apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

RUN pecl channel-update pecl.php.net
RUN pecl install mongodb && docker-php-ext-enable mongodb

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer