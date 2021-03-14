FROM php:8.0.1-fpm-alpine3.13

RUN echo 'http://dl-cdn.alpinelinux.org/alpine/v3.13/community' >> /etc/apk/repositories
RUN apk update && apk add --no-cache 'tidyhtml-dev==5.6.0-r0' \
    oniguruma-dev \
    postgresql-dev \
    jpeg-dev libwebp-dev libpng-dev \
    freetype libpng libjpeg-turbo freetype-dev libjpeg-turbo-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype

RUN docker-php-ext-install -j$(nproc) gd \
    tidy \
    bcmath \
    mbstring \
    pdo \
    pdo_pgsql \
    pgsql

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN echo "xdebug.mode=debug"                >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003"       >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=172.17.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_handler=dbgp"    >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM"        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
