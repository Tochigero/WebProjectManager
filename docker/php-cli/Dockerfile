FROM php:7.2-cli

# APT packages
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libicu-dev \
    libbz2-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install bz2 gd intl mcrypt pdo_mysql zip soap
