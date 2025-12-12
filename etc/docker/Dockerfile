FROM shinsenter/php:8.5-frankenphp

ENV APP_USER="app"
ENV APP_GROUP="app"
ENV APP_UID="1000"
ENV APP_GID="1000"
ENV APP_PATH="/app"
ENV ENABLE_SSHD=0
ENV DEBUG=1
ENV COMPOSER_HOME="/home/app/.composer"
ENV DISABLE_AUTORUN_COMPOSER_INSTALL=1
ENV COMPOSER_OPTIMIZE_AUTOLOADER=1
ENV COMPOSER_MINIMAL_CHANGES=0
ENV COMPOSER_WITH_ALL_DEPENDENCIES=1
ENV TERM=xterm-256color
ENV COLORTERM=truecolor
ENV PNPM_HOME=/home/app/.pnpm-store

RUN rm /etc/hooks/bootstrap/10-create-project && \
    rm /etc/hooks/bootstrap/20-create-index && \
    rm /etc/hooks/bootstrap/30-other-fixes

# install repositories
ADD docker/trusted/ /etc/apt/keyrings/
ADD docker/sources/ /etc/apt/sources.list.d/
RUN chmod 644 /etc/apt/keyrings/*
RUN apt update -q

RUN apt install -qqy --no-install-recommends --fix-missing \
    # install base packages
    nano \
    git \
    eza \
    # mariadb
    mariadb-client \
    # install nodejs
    nodejs

# install pnpm
RUN npm install -g pnpm

# zsh
ADD --chown=${APP_UID}:${APP_GID} bash/ /home/app/

WORKDIR /app
