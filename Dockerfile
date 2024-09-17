FROM dunglas/frankenphp:php8.3.10@sha256:f0fb772c69ee4a53aff74731e3142a9c9bb6ca6492c5b41f159553755055cc28 AS php
RUN apt-get update && apt-get install -y git curl zip unzip \
    && docker-php-ext-install pdo_mysql

# Development
FROM php AS dev
COPY --from=node:22.7.0-bullseye@sha256:85d8c25be9ef5e3262fc6907b4ca3b1a40ad925b02e3b8965a15ea0068ea8574 /usr/local/bin/ /usr/local/bin/
COPY --from=node:22.7.0-bullseye@sha256:85d8c25be9ef5e3262fc6907b4ca3b1a40ad925b02e3b8965a15ea0068ea8574 /usr/local/lib/ /usr/local/lib/
RUN npm install -g npm@10.8.3
ENV NPM_CONFIG_CACHE=/tmp/.npm
ENV COMPOSER_HOME=/tmp/composer
ENV XDG_CONFIG_HOME=/tmp/.config

COPY --from=composer:2.7.8@sha256:79322ffd9050491d453fc403a17d23cfb898c353e06a88c9115d6f3b4239453d /usr/bin/composer /usr/bin/composer

# Staging
FROM php AS staging
COPY ./app /app

# Production
FROM php AS production
COPY ./app /app