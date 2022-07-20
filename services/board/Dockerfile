FROM php:8.1-fpm-alpine

ARG BASE_DIR=/var/www
ENV CACHE_DIR=$BASE_DIR/cache
ENV CACHE_TEST_DIR=$CACHE_DIR/tests
ENV CODE_DIR=$BASE_DIR/code
ENV REPORTS_DIR=$BASE_DIR/reports

ENV COMPOSER_VENDOR_DIR=$BASE_DIR/vendor
ENV COMPOSER_CACHE_DIR=$CACHE_DIR/composer
ARG COMPOSER_INSTALL_OPTIONS='--no-interaction --no-scripts --dev'
ARG COMPOSER_DUMP_AUTOLOAD_OPTIONS='--no-scripts --dev'

ARG DIRS="$CACHE_TEST_DIR $CODE_DIR $REPORTS_DIR $COMPOSER_VENDOR_DIR $COMPOSER_CACHE_DIR"
ARG PHP_EXTS='pcov '
ARG APK_PACKS="$PHPIZE_DEPS git vim"

RUN apk add --no-cache \
        $APK_PACKS && \
    curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions \
        $PHP_EXTS && \
    curl -sS https://getcomposer.org/installer | php -- \
        --version=2.3.10 \
        --install-dir=/usr/local/bin \
        --filename=composer && \
    rm -rf $BASE_DIR/* && \
    mkdir -p $DIRS && \
    chown -R www-data:www-data $BASE_DIR

WORKDIR $CODE_DIR
USER www-data

COPY --chown=www-data ./composer* ./
RUN composer install $COMPOSER_INSTALL_OPTIONS

COPY --chown=www-data ./ ./
RUN composer dump-autoload $COMPOSER_DUMP_AUTOLOAD_OPTIONS
