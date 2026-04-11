FROM ubuntu:22.04
LABEL maintainer="Dan Pupius <dan@pupi.us>"
ENV DEBIAN_FRONTEND=noninteractive

# Install dependencies + PHP + Apache in one layer
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        software-properties-common \
        curl \
        git \
        nano \
        mysql-client && \
    add-apt-repository ppa:ondrej/php -y && \
    apt-get update && \
    apt-get install -y --no-install-recommends \
        apache2 \
        php7.4 \
        php7.4-common \
        php7.4-mysql \
        php7.4-xml \
        php7.4-xmlrpc \
        php7.4-curl \
        php7.4-gd \
        php7.4-imagick \
        php7.4-cli \
        php7.4-dev \
        php7.4-imap \
        php7.4-mbstring \
        php7.4-opcache \
        php7.4-soap \
        php7.4-zip \
        php7.4-intl && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod php7.4 rewrite

# Configure PHP
RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.4/apache2/php.ini && \
    sed -i "s/error_reporting = .*/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.4/apache2/php.ini

# Apache environment variables
ENV APACHE_RUN_USER=www-data \
    APACHE_RUN_GROUP=www-data \
    APACHE_LOG_DIR=/var/log/apache2 \
    APACHE_LOCK_DIR=/var/lock/apache2 \
    APACHE_PID_FILE=/var/run/apache2.pid

# Create app directory
RUN mkdir -p /var/www/crypterio

# Set working directory
WORKDIR /var/www/crypterio

# Copy application files into crypterio
COPY ./www/ . 

# Copy Apache configs
COPY apache-config.conf /etc/apache2/sites-enabled/000-default.conf
COPY apache2.conf /etc/apache2/apache2.conf

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2ctl", "-D", "FOREGROUND"]
