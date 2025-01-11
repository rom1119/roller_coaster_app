# Basisimage
FROM php:8.2-fpm-alpine

RUN apk update 
RUN apk add --update \
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

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis.so

WORKDIR /app

COPY ./php /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
EXPOSE 9000
COPY ["docker-entrypoint.sh", "/usr/local/bin/docker-entrypoint"]
RUN chmod +x /usr/local/bin/docker-entrypoint
ENTRYPOINT [ "/usr/local/bin/docker-entrypoint" ]

CMD [ "php", "-S", "0.0.0.0:9000", "-t", "public" ]

