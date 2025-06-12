#!/bin/bash

echo ""
echo "===================================="
echo "   HRMS Organization Setup Script"
echo "===================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if PHP is available
if ! command -v php &> /dev/null; then
    echo -e "${RED}ERROR: PHP is not installed or not in PATH${NC}"
    echo "Please install PHP and try again"
    exit 1
fi

# Check if Composer is available
if ! command -v composer &> /dev/null; then
    echo -e "${RED}ERROR: Composer is not installed or not in PATH${NC}"
    echo "Please install Composer and try again"
    exit 1
fi

echo -e "${YELLOW}[1/6]${NC} Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo ""
echo -e "${YELLOW}[2/6]${NC} Setting up environment..."
if [ ! -f ".env" ]; then
    cp ".env.example" ".env"
    echo "Environment file created"
else
    echo "Environment file already exists"
fi

echo ""
echo -e "${YELLOW}[3/6]${NC} Generating application key..."
php artisan key:generate

echo ""
echo -e "${YELLOW}[4/6]${NC} Running database migrations..."
php artisan migrate --force

echo ""
echo -e "${YELLOW}[5/6]${NC} Setting up organization..."
php artisan organization:setup

echo ""
echo -e "${YELLOW}[6/6]${NC} Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo -e "${GREEN}====================================${NC}"
echo -e "${GREEN}    Setup Complete!${NC}"
echo -e "${GREEN}====================================${NC}"
echo ""
echo "Your HRMS system is ready to use!"
echo ""
echo "Admin Login: http://localhost:8000/admin/login"
echo "Employee Login: http://localhost:8000/employee/login"
echo ""
echo "To start the development server:"
echo "php artisan serve"
echo ""
