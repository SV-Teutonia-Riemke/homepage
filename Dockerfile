ARG PHP_EXTENSIONS="pdo_mysql imagick gd intl bcmath"

FROM thecodingmachine/php:8.3-v4-apache-node20 as builder

COPY --chown=docker:docker . /var/www/html/

RUN sudo npm install -g pnpm
RUN composer install --no-dev --no-interaction --no-scripts --no-progress --classmap-authoritative --ignore-platform-reqs
RUN pnpm install
RUN pnpm build
RUN sudo rm -rf \
    .git \
    .github \
    .pnpm-store \
    assets \
    docker \
    docs \
    node_modules \
    tests \
    .env.test \
    .env.local.dist \
    .editorconfig \
    .gitignore \
    composer-require-checker.json \
    composer-unused.php \
    docker-compose.yml \
    package.json \
    phpcs.xml \
    phpstan.neon \
    phpstan-baseline.neon \
    phpunit.xml.dist \
    phpunit.xml \
    pnpm-lock.yaml \
    symfony.lock \
    tsconfig.ts \
    webpack.config.js \
    rector.php

RUN sudo mkdir -p \
    /var/www/html/public/media \
    /var/www/html/var/cache \
    /var/www/html/var/flysystem \
    /var/www/html/var/log

FROM thecodingmachine/php:8.3-v4-apache

ENV TEMPLATE_PHP_INI="production"
ENV PHP_EXTENSIONS="pdo_mysql imagick gd intl bcmath"
ENV APACHE_DOCUMENT_ROOT="public/"
#ENV APACHE_RUN_USER=www-data
#ENV APACHE_RUN_GROUP=www-data

#ENV STARTUP_COMMAND_1="bin/console cache:clear"
ENV STARTUP_COMMAND_1="bin/console cache:warmup"
ENV STARTUP_COMMAND_2="bin/console cache:pool:clear --all"
ENV STARTUP_COMMAND_3="bin/console doctrine:migrations:migrate --no-interaction"
ENV STARTUP_COMMAND_4="bin/console assets:install public"

COPY --from=builder --chown=docker:docker /var/www/html /var/www/html

WORKDIR /var/www/html
EXPOSE 80
