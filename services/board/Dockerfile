FROM php:8.1-fpm-alpine

WORKDIR /var/www

RUN curl -sSLf -o /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pcov && \
    curl -sS https://getcomposer.org/installer | php -- \
        --version=2.3.5 \
        --install-dir=/usr/local/bin \
        --filename=composer && \
    rm -rf ./* && \
    chown -R www-data:www-data ./

USER www-data

COPY --chown=www-data ./composer* ./
RUN composer install

COPY --chown=www-data ./ ./
RUN composer dump-autoload
