#!/bin/sh
set -e

chown -R www-data:www-data /var/www/storage/

php-fpm
#php /var/www/core/artisan queue:work

