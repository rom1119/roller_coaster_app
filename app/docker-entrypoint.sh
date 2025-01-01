#!/bin/sh

composer install && composer dump-autoload --optimize 
php bin/console app:init-roller-coasters --no-interaction

exec "$@"