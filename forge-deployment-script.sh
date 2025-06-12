# Laravel Forge Deployment Script for HRMS
# Copy this script to your Forge site's deployment script section

cd $FORGE_SITE_PATH

# Pull latest changes
git pull origin $FORGE_SITE_BRANCH

# Install/update composer dependencies
$FORGE_COMPOSER install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Check if we need to run migrations
if [ -f artisan ]; then
    # Run database migrations
    $FORGE_PHP artisan migrate --force

    # Cache configuration for better performance
    $FORGE_PHP artisan config:cache
    $FORGE_PHP artisan route:cache
    $FORGE_PHP artisan view:cache
    $FORGE_PHP artisan event:cache

    # Restart queue workers
    $FORGE_PHP artisan queue:restart

    # Clear and regenerate optimized class loader
    $FORGE_PHP artisan optimize

    # Clear old cached views and config if needed
    $FORGE_PHP artisan optimize:clear
fi

# Install/update Node.js dependencies and build assets
if [ -f package.json ]; then
    npm ci --only=production
    npm run build
fi

# Set proper permissions for Laravel
sudo chown -R forge:www-data storage
sudo chown -R forge:www-data bootstrap/cache
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

# Optional: Clear OPcache if available
if command -v php-fpm &> /dev/null; then
    sudo systemctl reload php8.2-fpm || sudo systemctl reload php8.1-fpm || true
fi

echo "Deployment completed successfully!"

# Optional: Send deployment notification (uncomment and configure as needed)
# curl -X POST -H 'Content-type: application/json' \
#     --data '{"text":"HRMS deployed successfully to '$FORGE_SITE_BRANCH'"}' \
#     YOUR_SLACK_WEBHOOK_URL
