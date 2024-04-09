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
    assets \
    docker \
    docs \
    node_modules \
    tests \
    .env.test .env.local.dist .gitignore composer-require-checker.json docker-compose.yml Makefile package.json phpunit.xml.dist pnpm-lock.yaml tsconfig.ts \
    phpcs.xml phpstan.neon phpstan-baseline.neon phpunit.xml webpack.config.js .editorconfig README.md composer-unused.php rector.php

RUN sudo mkdir -p \
    /var/www/html/var/cache \
    /var/www/html/var/flysystem \
    /var/www/html/var/log

FROM thecodingmachine/php:8.3-v4-apache

ENV TEMPLATE_PHP_INI="production"
ENV PHP_EXTENSIONS="pdo_mysql imagick gd intl bcmath"
ENV APACHE_DOCUMENT_ROOT="public/"
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data

ENV STARTUP_COMMAND_1="bin/console cache:clear"
ENV STARTUP_COMMAND_2="bin/console cache:warmup"
ENV STARTUP_COMMAND_3="bin/console doctrine:migrations:migrate --no-interaction"
ENV STARTUP_COMMAND_4="bin/console ckeditor:install --clear=drop --tag=4.22.1"
ENV STARTUP_COMMAND_5="bin/console assets:install public"

COPY --from=builder --chown=docker:docker /var/www/html /var/www/html

WORKDIR /var/www/html
EXPOSE 80
