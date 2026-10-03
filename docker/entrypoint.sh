#!/bin/sh
set -eu

: "${PORT:=10000}"
export PORT

envsubst '${PORT}' < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf
php artisan storage:link --force
php artisan config:cache

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
