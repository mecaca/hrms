#!/usr/bin/env bash
# HRMS Forge Deployment Automation Script
# This script helps automate HRMS deployment on Laravel Forge + Linode

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

echo ""
echo "=============================================="
echo "   HRMS Forge + Linode Deployment Script"
echo "=============================================="
echo ""

# Check if running on Forge server
if [ ! -d "/home/forge" ]; then
    print_error "This script should be run on a Laravel Forge server"
    exit 1
fi

# Get deployment parameters
read -p "Organization Name: " ORG_NAME
read -p "Organization Code (e.g., ACME): " ORG_CODE
read -p "Admin Email: " ADMIN_EMAIL
read -s -p "Admin Password: " ADMIN_PASSWORD
echo ""
read -p "Company Phone: " COMPANY_PHONE
read -p "Company Address: " COMPANY_ADDRESS
read -p "Company Website: " COMPANY_WEBSITE
read -p "Domain Name (e.g., client.hrms.com): " DOMAIN_NAME

print_status "Starting deployment for $ORG_NAME..."

# Navigate to site directory
SITE_DIR="/home/forge/$DOMAIN_NAME"
if [ ! -d "$SITE_DIR" ]; then
    print_error "Site directory $SITE_DIR not found. Please create the site in Forge first."
    exit 1
fi

cd "$SITE_DIR"

print_status "Running composer install..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

print_status "Setting up environment..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    print_status "Environment file created"
fi

print_status "Generating application key..."
php artisan key:generate --force

print_status "Running database migrations..."
php artisan migrate --force

print_status "Setting up organization..."
php artisan organization:setup \
    --company-name="$ORG_NAME" \
    --company-code="$ORG_CODE" \
    --admin-email="$ADMIN_EMAIL" \
    --admin-password="$ADMIN_PASSWORD" \
    --phone="$COMPANY_PHONE" \
    --address="$COMPANY_ADDRESS" \
    --website="$COMPANY_WEBSITE" \
    --clear-demo \
    --no-interaction

print_status "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize

print_status "Setting permissions..."
chown -R forge:www-data storage
chown -R forge:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

print_status "Building frontend assets..."
if [ -f "package.json" ]; then
    npm install --production
    npm run build
    print_success "Frontend assets built"
else
    print_warning "No package.json found, skipping frontend build"
fi

print_status "Clearing caches..."
php artisan optimize:clear
php artisan queue:restart

print_success "Deployment completed successfully!"
echo ""
echo "=============================================="
echo "   Deployment Summary"
echo "=============================================="
echo "Organization: $ORG_NAME"
echo "Domain: https://$DOMAIN_NAME"
echo "Admin URL: https://$DOMAIN_NAME/admin/login"
echo "Admin Email: $ADMIN_EMAIL"
echo "Employee URL: https://$DOMAIN_NAME/employee/login"
echo "Careers URL: https://$DOMAIN_NAME/careers"
echo ""
echo "Next Steps:"
echo "1. Verify SSL certificate is active"
echo "2. Test admin login"
echo "3. Configure email settings if needed"
echo "4. Set up monitoring and backups"
echo "=============================================="
