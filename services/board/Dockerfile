FROM php:8.1-fpm-alpine

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- \
        --version=2.3.5 \
        --install-dir=/usr/local/bin \
        --filename=composer && \
    rm -rf ./* && \
    chown -R www-data:www-data ./

USER www-data

#COPY --chown=www-data ./composer* ./symfony.lock ./
#RUN composer install $COMPOSER_INSTALL_OPTIONS
#
#COPY --chown=www-data ./ ./
#RUN composer dump-autoload && \
#    ENV_NAME=build NODE_NAME=localhost console cache:warmup
