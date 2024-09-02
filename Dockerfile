FROM php:8.3.10-fpm-bullseye@sha256:857b7cdf42fc4e5b313548e6f6260fce0534439e30915824a5ac3efe9a121dff
RUN apt-get update && apt-get install -y git curl zip unzip \
    && docker-php-ext-install pdo_mysql

ENV COMPOSER_HOME=~/tmp/composer
COPY --from=composer:2.7.8@sha256:79322ffd9050491d453fc403a17d23cfb898c353e06a88c9115d6f3b4239453d /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

EXPOSE 9000