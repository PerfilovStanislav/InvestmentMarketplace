FROM php:7.4.5-fpm-alpine3.11

RUN echo 'http://dl-cdn.alpinelinux.org/alpine/v3.11/community' >> /etc/apk/repositories
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
    pdo_pgsql
