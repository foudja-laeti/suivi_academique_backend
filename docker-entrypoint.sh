#!/bin/sh
php artisan config:clear
php artisan migrate --force
exec /init
