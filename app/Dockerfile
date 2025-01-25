# Basisimage
FROM php:8.2-fpm-alpine

ARG COMPOSER_VERSION=2.0.7
# RUN apk update 
RUN set -ex \
    && apk add --update \
    curl \
    git \
    unzip \
    libzip-dev \
    icu-dev \ 
    redis

RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    zip 

RUN set -ex \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install redis && docker-php-ext-enable redis \
    && apk del --purge .phpize-deps \
    && rm -rf /tmp/* /var/tmp/*

WORKDIR /app

COPY ./php /app

RUN curl https://getcomposer.org/download/$COMPOSER_VERSION/composer.phar --output composer.phar \
    && mv composer.phar /usr/local/bin/composer \
    && chmod 775 /usr/local/bin/composer

EXPOSE 9000

COPY ["docker-entrypoint.sh", "/usr/local/bin/docker-entrypoint"]
RUN chmod +x /usr/local/bin/docker-entrypoint
ENTRYPOINT [ "/usr/local/bin/docker-entrypoint" ]

CMD [ "php", "-S", "0.0.0.0:9000", "-t", "public" ]

