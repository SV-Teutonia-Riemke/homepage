FROM shinsenter/php:8.4-frankenphp

ENV APP_USER="app"
ENV APP_GROUP="app"
ENV APP_UID="1000"
ENV APP_GID="1000"
ENV APP_PATH="/app"
ENV ENABLE_SSHD=0
ENV DEBUG=1
ENV COMPOSER_HOME="/home/app/.composer"
ENV DISABLE_AUTORUN_COMPOSER_INSTALL=1
ENV COMPOSER_OPTIMIZE_AUTOLOADER=0
ENV TERM=xterm-256color
ENV COLORTERM=truecolor
ENV PNPM_HOME=/home/app/.pnpm-store

RUN rm /etc/hooks/bootstrap/10-create-project && \
    rm /etc/hooks/bootstrap/20-create-index && \
    rm /etc/hooks/bootstrap/30-other-fixes

# add trusted keys
ADD docker/trusted/ /etc/apt/keyrings/
RUN chmod 644 /etc/apt/keyrings/*

# install repositories
ADD docker/sources/ /etc/apt/sources.list.d/
RUN apt update -q

RUN apt install -qqy --no-install-recommends --fix-missing \
    # install base packages
    nano \
    git \
    # mariadb
    mariadb-client \
    # for zsh
    eza \
    zsh \
    zoxide \
    # install nodejs
    nodejs

# install pnpm
RUN npm install -g pnpm

# zsh
ADD --chown=${APP_UID}:${APP_GID} zsh/ /home/app/
ADD zsh/ /root

WORKDIR /app
