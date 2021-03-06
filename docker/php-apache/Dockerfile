FROM php:7.2-apache

# Environment vars
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data
ENV APACHE_PID_FILE=/var/run/apache2.pid
ENV APACHE_RUN_DIR=/var/run/apache2
ENV APACHE_LOCK_DIR=/var/lock/apache2
ENV APACHE_LOG_DIR=/var/log/apache2

WORKDIR /var/www/html/WebProject

# APT packages
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libicu-dev \
    libbz2-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libxml2-dev \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql

# PHP Coniguration
COPY config/php.ini /usr/local/etc/php/php.ini
COPY config/apcu.ini config/xdebug.ini /usr/local/etc/php/conf.d/
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Apache
RUN a2enmod rewrite
RUN a2ensite 000-default.conf

# Bash
#RUN chsh -s /bin/bash www-data

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

# Ports
EXPOSE 80

# Entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
