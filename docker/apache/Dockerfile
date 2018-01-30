FROM ubuntu:12.04

# Environment vars
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data
ENV APACHE_PID_FILE=/var/run/apache2.pid
ENV APACHE_RUN_DIR=/var/run/apache2
ENV APACHE_LOCK_DIR=/var/lock/apache2
ENV APACHE_LOG_DIR=/var/log/apache2

# APT packages
RUN apt-get update && apt-get install -y \
    apache2 \
    libapache2-mod-php5 \
    libicu-dev \
    php5-gd \
    php5-intl \
    php5-mcrypt \
    php5-mysql \
    php5-sqlite \
    && rm -rf /var/lib/apt/lists/*

# Apache Configuration
COPY vhost.conf /etc/apache2/sites-available/default

# Run Apache
RUN a2ensite default

# Ports
EXPOSE 80

# Entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
