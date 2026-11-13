#!/bin/bash
set -e
echo "🚀 Deploying..."
(php artisan down) || true
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
php artisan view:cache
npm install && npm run build
php artisan up
echo "✅ Done!"