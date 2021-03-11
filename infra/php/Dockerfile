FROM php:7.4-fpm-buster
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

# set envs
ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  apt-get -y install git unzip libzip-dev libicu-dev libonig-dev && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath

# install Node.js and yarn.
RUN apt-get update && apt-get install -y curl apt-transport-https wget
# RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
#     echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
#     apt-get update && apt-get install -y yarn
RUN curl -sL https://deb.nodesource.com/setup_current.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g

COPY ./infra/php/php.ini /usr/local/etc/php/php.ini

WORKDIR /work

ADD ./backend/composer.json /work/composer.json
ADD ./backend/composer.lock /work/composer.lock
RUN composer global require "laravel/installer"
RUN COMPOSER_MEMORY_LIMIT=-1 composer global require "laravel/jetstream"
RUN pwd
RUN artisan jetstream:install livewire
RUN npm install
RUN npm dev