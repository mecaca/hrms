@echo off
:: HRMS Quick Setup for New Organization
:: This script automates the entire setup process

echo.
echo ========================================
echo   HRMS Quick Organization Setup
echo ========================================
echo.

:: Get organization details
echo Please provide your organization details:
echo.

set /p COMPANY_NAME="Company Name: "
set /p COMPANY_CODE="Company Code (e.g., ACME): "
set /p ADMIN_EMAIL="Admin Email: "
set /p ADMIN_PASSWORD="Admin Password: "
set /p COMPANY_PHONE="Phone Number: "
set /p COMPANY_ADDRESS="Company Address: "
set /p COMPANY_WEBSITE="Website (optional): "

echo.
echo ========================================
echo   Setting up %COMPANY_NAME%
echo ========================================
echo.

:: Check if .env exists, if not copy from example
if not exist ".env" (
    echo [1/6] Creating environment file...
    copy ".env.example" ".env"
) else (
    echo [1/6] Environment file already exists
)

:: Generate app key if needed
echo [2/6] Generating application key...
php artisan key:generate --force

:: Run migrations
echo [3/6] Setting up database...
php artisan migrate --force

:: Clear demo data and setup organization
echo [4/6] Setting up organization...
php artisan organization:setup --company-name="%COMPANY_NAME%" --company-code="%COMPANY_CODE%" --admin-email="%ADMIN_EMAIL%" --admin-password="%ADMIN_PASSWORD%" --phone="%COMPANY_PHONE%" --address="%COMPANY_ADDRESS%" --website="%COMPANY_WEBSITE%" --clear-demo --no-interaction

:: Optimize application
echo [5/6] Optimizing application...
php artisan optimize

:: Final success message
echo [6/6] Setup complete!
echo.
echo ========================================
echo   %COMPANY_NAME% HRMS Ready!
echo ========================================
echo.
echo Your HRMS system is now configured and ready to use!
echo.
echo Admin Login URL: http://localhost:8000/admin/login
echo Email: %ADMIN_EMAIL%
echo Password: [Your configured password]
echo.
echo Employee Portal: http://localhost:8000/employee/login
echo Public Careers Page: http://localhost:8000/careers
echo.
echo To start the development server:
echo php artisan serve
echo.
echo Next Steps:
echo 1. Upload your company logo via Admin Dashboard
echo 2. Customize departments and job families
echo 3. Configure payroll settings
echo 4. Start adding employees!
echo.
pause
