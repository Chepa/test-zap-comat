#!/usr/bin/env bash
set -e
echo "entrypoint loaded ..."
# Если в /var/www/html/vendor нет папок (т.е. Composer не установлен)
if [ ! -d /var/www/html/vendor ]; then
	echo "adding access to storage for php server ..."
	chown -R www-data:www-data /var/www/html/storage/
	
    echo "Installing composer ..."
    composer install

    echo "Generating app key..."
    php artisan key:generate

	echo "migrating database ..."
	php artisan migrate
	
	echo "seeding database ..."
	php artisan db:seed
else
    echo "vendor directory found. Skipping initial setup."
fi

exec "$@"