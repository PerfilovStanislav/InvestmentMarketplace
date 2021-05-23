FROM php:8.0.5-fpm-alpine3.13

ARG COMPOSER_VERSION="2.0.13"
ARG COMPOSER_SUM="116fdf07cc926af646635a6abc92d88aff7b02a5dc36538f81c50a7d27366dbf"

RUN rm -rf /var/cache/apk/* && \
    rm -rf /tmp/*

RUN apk update

# Install dependencies
RUN set -eux \
    && apk add --no-cache \
        ca-certificates \
        freetds \
        freetype \
        gettext \
        gmp \
        icu-libs \
        imagemagick \
        libffi \
        libgmpxx \
        libintl \
        libjpeg-turbo \
        libmcrypt \
        libpng \
        libpq \
        libssh2 \
        libstdc++ \
        libtool \
        libxpm \
        libxslt \
        libzip \
        make \
        rabbitmq-c \
        tidyhtml \
        tzdata \
        vips \
        yaml

# Development dependencies
RUN set -eux \
    && apk add --no-cache --virtual .build-deps \
        autoconf \
        cmake \
        curl-dev \
        freetds-dev \
        freetype-dev \
        gcc \
        gettext-dev \
        git \
        gmp-dev \
        icu-dev \
        imagemagick-dev \
        libc-dev \
        libjpeg-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libressl-dev \
        libssh2-dev \
        libwebp-dev \
        libxml2-dev \
        libxpm-dev \
        libxslt-dev \
        libzip-dev \
        openssl-dev \
        pcre-dev \
        pkgconf \
        postgresql-dev \
        rabbitmq-c-dev \
        tidyhtml-dev \
        vips-dev \
        yaml-dev \
        zlib-dev \
        oniguruma-dev

#RUN echo 'http://dl-cdn.alpinelinux.org/alpine/v3.13/community' >> /etc/apk/repositories
#RUN echo 'https://dl-cdn.alpinelinux.org/alpine/edge/main/' >> /etc/apk/repositories
#RUN echo 'https://dl-cdn.alpinelinux.org/alpine/edge/community/' >> /etc/apk/repositories
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype
#apk update && apk add --no-cache 'tidyhtml-dev==5.6.0-r0' \
#    oniguruma-dev \
#    postgresql-dev \
#    jpeg-dev libwebp-dev libpng-dev \
#    freetype libpng libjpeg-turbo freetype-dev libjpeg-turbo-dev \
#    vips php8-pecl-vips \
#    &&


RUN docker-php-ext-install -j$(nproc) gd \
    tidy \
    bcmath \
    mbstring \
    pdo \
    pdo_pgsql \
    pgsql





# Install imagick
# Note: Build from source until the pecl release is ready for PHP 8
RUN git clone --depth=1 https://github.com/Imagick/imagick \
    && cd imagick \
    && phpize && ./configure \
    && make -j$(nproc) \
    && make install \
    && cd ../ \
    && rm -rf imagick \
    && docker-php-ext-enable imagick \
    && true \
\
# Install vips
    && pecl install vips \
    && docker-php-ext-enable vips \
    && true \
\
# Install zip
    && docker-php-ext-configure zip --with-zip \
    && docker-php-ext-install -j$(nproc) zip \
    && true \
\
# Clean up build packages
    && docker-php-source delete \
    && apk del .build-deps \
    && true

# Install Composer
RUN set -eux \
    && curl -LO "https://getcomposer.org/download/${COMPOSER_VERSION}/composer.phar" \
    && echo "${COMPOSER_SUM}  composer.phar" | sha256sum -c - \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer \
    && composer --version \
    && true

RUN set -eux \
# Fix php.ini settings for enabled extensions
    && chmod +x "$(php -r 'echo ini_get("extension_dir");')"/* \
# Shrink binaries
    && (find /usr/local/bin -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
    && (find /usr/local/lib -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
    && (find /usr/local/sbin -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
    && true
#
## Copy PHP-FPM configuration files
#COPY 8.0-fpm/php-fpm.tmpl.conf /var/data/php-fpm/php-fpm.tmpl.conf
#COPY 8.0-fpm/www.tmpl.conf /var/data/php-fpm/www.tmpl.conf
#COPY 8.0-fpm/php.tmpl.ini /var/data/php-fpm/default-php.tmpl.ini

#RUN apk add --no-cache $PHPIZE_DEPS \vips
#    \
#    && docker-php-ext-enable vips

#RUN echo "xdebug.mode=debug"                >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.client_port=9003"       >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.client_host=172.17.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.remote_handler=dbgp"    >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.discover_client_host=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.idekey=PHPSTORM"        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
