FROM thecodingmachine/php:8.4-v4-apache

COPY --chown=docker:docker . /var/www/html/

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

WORKDIR /var/www/html
EXPOSE 80
