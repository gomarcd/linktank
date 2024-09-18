FROM dunglas/frankenphp
RUN apt-get update && apt-get install -y git curl zip unzip

COPY --from=node /usr/local/bin/ /usr/local/bin/
COPY --from=node /usr/local/lib/ /usr/local/lib/
COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV NPM_CONFIG_CACHE=/tmp/.npm
ENV COMPOSER_HOME=/tmp/composer
ENV XDG_CONFIG_HOME=/tmp/.config

COPY ./ /app