FROM shinsenter/php:8.5-frankenphp

ENV APP_USER="app"
ENV APP_GROUP="app"
ENV APP_UID="1000"
ENV APP_GID="1000"
ENV APP_PATH="/app"
ENV ENABLE_SSHD=0
ENV DISABLE_AUTORUN_COMPOSER_INSTALL=1
ENV COMPOSER_OPTIMIZE_AUTOLOADER=0
ENV TERM=xterm-256color
ENV COLORTERM=truecolor

RUN rm /etc/hooks/bootstrap/10-create-project && \
    rm /etc/hooks/bootstrap/20-create-index && \
    rm /etc/hooks/bootstrap/30-other-fixes

RUN apt update -q
RUN apt install -qqy --no-install-recommends --fix-missing \
    # install base packages
    nano

COPY --chown=$APP_UID:$APP_GID . /app
COPY ./Caddyfile /etc/caddy/Caddyfile
COPY --chmod=+x ./etc/startup/00-startup /startup/

WORKDIR /app
