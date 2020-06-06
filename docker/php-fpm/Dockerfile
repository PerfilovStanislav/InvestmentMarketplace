FROM php:7.4.5-fpm-alpine3.11

RUN apk update && apk add --no-cache \
    oniguruma-dev \
    postgresql-dev \
    jpeg-dev libwebp-dev libpng-dev \
    freetype libpng libjpeg-turbo freetype-dev libjpeg-turbo-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install -j$(nproc) gd \
        bcmath \
        mbstring \
        pdo \
        pdo_pgsql
