#!/bin/sh
set -e

echo " Deploying Application... "

# Enter Maintenance Mode
echo "docker-compose exec app php artisan down"
docker-compose exec --tty app php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.' || true
# update Codebase
git fetch origin production

echo "docker-compose up -d --build"
docker-compose up -d --build

# Install dependencies based on composer.lock file
echo "docker-compose exec app composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs"
docker-compose exec --tty app composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs --no-dev

# Clear Cache
echo "docker-compose exec app php artisan config:clear"
docker-compose exec --tty app php artisan config:clear
docker-compose exec --tty app php artisan cache:clear

# Exit Maintenance Mode
echo "docker-compose exec app php artisan up"
docker-compose exec --tty app php artisan up

echo " Application Deployed ! "
