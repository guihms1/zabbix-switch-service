FROM php:8.0.5-apache

# 1. development packages
RUN apt-get update
RUN apt-get install -y \
	wget \
	libpng-dev \
	nginx \
	supervisor \
	nano \
	libxml2-dev \
	git \
	zip \
	autoconf \
	g++ \
	libzip-dev \
	unixodbc \
	unixodbc-dev \
	freetds-dev freetds-bin tdsodbc \
	gnupg gnupg1 gnupg2

# 2. apache configs + document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# 4. start with base php config, then add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pdo_mysql \
        gd \
        soap \
        xml \
        posix \
        tokenizer \
        ctype \
        pcntl \
        opcache \
        bcmath \
        zip \
        gd

COPY .docker/php/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

#install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . /var/www/html

RUN chmod +x .docker/php/setup.sh && .docker/php/setup.sh

RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 777 storage
