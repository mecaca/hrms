@echo off
echo.
echo ====================================
echo    HRMS Organization Setup Script
echo ====================================
echo.

REM Check if PHP is available
php --version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: PHP is not installed or not in PATH
    echo Please install PHP and try again
    pause
    exit /b 1
)

REM Check if Composer is available
composer --version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Composer is not installed or not in PATH
    echo Please install Composer and try again
    pause
    exit /b 1
)

echo [1/6] Installing dependencies...
call composer install --no-dev --optimize-autoloader

echo.
echo [2/6] Setting up environment...
if not exist ".env" (
    copy ".env.example" ".env"
    echo Environment file created
) else (
    echo Environment file already exists
)

echo.
echo [3/6] Generating application key...
php artisan key:generate

echo.
echo [4/6] Running database migrations...
php artisan migrate --force

echo.
echo [5/6] Setting up organization...
php artisan organization:setup

echo.
echo [6/6] Optimizing application...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo.
echo ====================================
echo    Setup Complete!
echo ====================================
echo.
echo Your HRMS system is ready to use!
echo.
echo Admin Login: http://localhost:8000/admin/login
echo Employee Login: http://localhost:8000/employee/login
echo.
echo To start the development server:
echo php artisan serve
echo.
pause
