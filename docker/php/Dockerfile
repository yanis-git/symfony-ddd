FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    ca-certificates \
    curl \
    librabbitmq-dev \
    libzip-dev \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxml2-dev \
    libbz2-dev \
    autoconf \
    g++ \
    make \
    wget \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install -o -f redis amqp xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis amqp xdebug

RUN docker-php-ext-install \
    bcmath \
    bz2 \
    calendar \
    exif \
    iconv \
    intl \
    opcache \
    pcntl \
    pdo_mysql \
    zip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    	&& docker-php-ext-install -j$(nproc) gd

RUN wget https://getcomposer.org/composer-stable.phar -O /usr/local/bin/composer && chmod +x /usr/local/bin/composer

# Copy the php config file
COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-custom.ini
COPY docker/php/fpm.conf /usr/local/etc/php-fpm.d/zz-custom.conf

# Copy the application code
COPY . /var/www/html

VOLUME ["/var/www/html"]