#!/bin/bash

cd /work/site

php artisan optimize --force
php artisan config:cache