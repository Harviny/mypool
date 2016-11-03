#!/bin/bash

set -ex

cd "$(dirname "$0")"

if [[ -z "$ENV" ]]; then
    ENV=dev
fi

cp -f php-"$ENV".ini /etc/php/7.0/cli/php.ini
cp -f php-"$ENV".ini /etc/php/7.0/fpm/php.ini
cp -f phpfpm-"$ENV".conf /etc/php/7.0/fpm/pool.d/www.conf

( cd /work/site && \
    mkdir -p storage/app && \
    mkdir -p storage/framework/{cache,sessions,views} && \
    mkdir -p storage/logs && \
    chown -R www-data:www-data storage && \
    rm -rf bootstrap/cache/* && \
    chown -R www-data:www-data bootstrap/cache )

if [[ "$ENV" == "production" ]]; then
    /bin/bash ./optimize.sh
fi

mkdir -p /var/run/php
php-fpm7.0 -F
