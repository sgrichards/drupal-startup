FROM drush/drush:8-alpine as drush
FROM composer:1 as composer

FROM php:7.1-apache

# We copy the drush binary from the previous image so we don't have to install Drush manually.
COPY --from=drush /usr/local/bin/drush /usr/local/bin/drush

# Same for Composer.
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Configure system dependencies
RUN apt-get update -y -qq \
 && curl -sL https://deb.nodesource.com/setup_8.x | bash \
 && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    mysql-client \
    libjpeg62-turbo-dev \
    libpng12-dev \
    libpq-dev \
    libpng-dev \
    unzip \
    git \
    imagemagick \
    vim \
    nodejs \
 && apt-get clean autoclean && apt-get autoremove -y \
 && rm -rf /var/lib/apt/lists/*

ARG XDEBUG_CONF_PATH=/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Configure PHP.
RUN docker-php-ext-configure gd --with-jpeg-dir=/usr --with-png-dir=/usr \
 && docker-php-ext-install \
    gd \
    mbstring \
    opcache \
    pdo \
    pdo_mysql \
    mysqli \
    zip \
 && pecl install apcu xdebug redis \
 && docker-php-ext-enable apcu xdebug redis \
 && echo "xdebug.remote_enable=1" >> ${XDEBUG_CONF_PATH} \
 && echo "xdebug.remote_host=docker.for.mac.localhost" >> ${XDEBUG_CONF_PATH}

COPY php.ini /usr/local/etc/php/

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN composer global require hirak/prestissimo --no-interaction

# Configure Apache.

ENV APACHE_DOCUMENT_ROOT /app/docroot
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
 && a2enmod \
    expires \
    rewrite \
    headers

WORKDIR /app
