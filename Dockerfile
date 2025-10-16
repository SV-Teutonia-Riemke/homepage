FROM shinsenter/php:8.4-frankenphp

ENV APP_USER="app"
ENV APP_GROUP="app"
ENV APP_UID="1000"
ENV APP_GID="1000"

COPY --chown=$APP_USER:$APP_GROUP . /var/www/html/
COPY ./Caddyfile /etc/caddy/Caddyfile
COPY ./etc/startup/00-startup /startup/00-startup

RUN chmod +x /startup/00-startup
