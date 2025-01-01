# Basisimage
FROM php:8.2-fpm-alpine

RUN apk update 
RUN apk add --update \
    curl \
    git \
    unzip \
    libzip-dev \
    icu-dev

RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    zip 

WORKDIR /app

COPY ./ /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
EXPOSE 9000
COPY ["docker-entrypoint.sh", "/usr/local/bin/docker-entrypoint"]
RUN chmod +x /usr/local/bin/docker-entrypoint
ENTRYPOINT [ "/usr/local/bin/docker-entrypoint" ]

CMD [ "php", "-S", "0.0.0.0:9000", "-t", "public" ]

