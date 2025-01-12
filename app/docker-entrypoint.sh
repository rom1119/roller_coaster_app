#!/bin/sh

composer install && composer dump-autoload --optimize 
mkdir -p tools/php-cs-fixer
composer require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer
php bin/console app:init-roller-coasters --no-interaction

exec "$@"