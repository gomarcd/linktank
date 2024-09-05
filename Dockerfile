FROM node:22.7.0-bullseye@sha256:85d8c25be9ef5e3262fc6907b4ca3b1a40ad925b02e3b8965a15ea0068ea8574 AS node
RUN npm install -g npm@10.8.3
FROM php:8.3.10-fpm-bullseye@sha256:857b7cdf42fc4e5b313548e6f6260fce0534439e30915824a5ac3efe9a121dff AS php
ENV NPM_CONFIG_CACHE=/tmp/.npm
COPY --from=node /usr/local/bin/ /usr/local/bin/
COPY --from=node /usr/local/lib/ /usr/local/lib/

RUN apt-get update && apt-get install -y git curl zip unzip \
    && docker-php-ext-install pdo_mysql

ENV COMPOSER_HOME=/tmp/composer
ENV XDG_CONFIG_HOME=/tmp/.config
COPY --from=composer:2.7.8@sha256:79322ffd9050491d453fc403a17d23cfb898c353e06a88c9115d6f3b4239453d /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

EXPOSE 9000
