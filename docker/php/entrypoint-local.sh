#!/bin/bash
echo "!!!!!!!!!!!!!!!!!!!!!!!!!! start entrypoint-local.sh !!!!!!!!!!!!!!!!!!!!!!!!!!!!"

composer install --prefer-dist --ignore-platform-reqs
#chown -R www-data:www-data /app

php-fpm -R

echo "!!!!!!!!!!!!!!!!!!!!!!!!!! end entrypoint-local.sh !!!!!!!!!!!!!!!!!!!!!!!!!!!!"

