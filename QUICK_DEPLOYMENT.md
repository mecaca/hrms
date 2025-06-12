# 🚀 HRMS Quick Deployment Guide for Multiple Organizations

This guide will help you quickly deploy and configure the HRMS system for different organizations in just **15 minutes per organization**.

## 📋 What You Get

✅ **Single-Organization HRMS** - Perfect for individual companies  
✅ **Complete HR Management** - Employee lifecycle, payroll, attendance, performance  
✅ **Multi-Branch Support** - Handle multiple locations within same organization  
✅ **Automated Setup** - One-command organization configuration  
✅ **Clean Template** - Easy to replicate for new organizations  

## 🎯 Quick Setup (3 Steps)

### Option 1: Automated Setup (Recommended)

**Windows:**
```cmd
setup.bat
```

**Linux/Mac:**
```bash
chmod +x setup.sh
./setup.sh
```

### Option 2: Manual Setup

```bash
# 1. Copy environment and install dependencies
cp .env.example .env
composer install --no-dev --optimize-autoloader

# 2. Generate app key and run migrations
php artisan key:generate
php artisan migrate --force

# 3. Interactive organization setup
php artisan organization:setup

# 4. Start the server
php artisan serve
```

## 📊 Organization Setup Process

When you run `php artisan organization:setup`, you'll be prompted for:

### 🏢 Company Information
- **Company Name**: Full organization name
- **Company Code**: Short identifier (e.g., "ACME", "TECH")
- **Admin Email**: Primary administrator email
- **Admin Password**: Secure password (min 8 characters)
- **Phone**: Company contact number
- **Address**: Full business address
- **Website**: Company website (optional)

### 🏗️ Organizational Structure
The system will automatically create:
- **5 Default Departments**: Admin, HR, IT, Finance, Operations
- **5 Job Families**: Executive, Management, Professional, Technical, Administrative
- **Basic Location**: Head Office
- **Employment Types**: Full-time, Part-time, Contract, etc.
- **Leave Types**: Annual, Sick, Maternity, etc.

## 🔧 Post-Setup Configuration

### 1. Access Admin Dashboard
```
URL: http://localhost:8000/admin/login
Email: [Your admin email]
Password: [Your password]
```

### 2. Upload Company Logo
- Go to: **Admin > Company Settings**
- Upload logo (200x200px PNG recommended)

### 3. Customize Organization Structure
- **Departments**: Admin > Organization > Departments
- **Job Families**: Admin > Organization > Job Families  
- **Locations**: Admin > Organization > Locations
- **Job Titles**: Admin > Organization > Job Titles

### 4. Configure Payroll Settings
- **Pay Periods**: Admin > Payroll > Settings
- **Tax Rates**: Configure based on location
- **Benefits**: Set up company benefits

## 🔄 Deploying for Multiple Organizations

### Method 1: Fresh Installation Per Organization
```bash
# For each new organization:
git clone [your-hrms-repo] company-name-hrms
cd company-name-hrms
./setup.sh
# Follow interactive prompts
```

### Method 2: Database Per Organization (Same Codebase)
```bash
# Create separate databases
mysql -u root -p -e "CREATE DATABASE company1_hrms;"
mysql -u root -p -e "CREATE DATABASE company2_hrms;"

# Copy and modify .env for each organization
cp .env company1.env
cp .env company2.env

# Edit database names in each .env file
# DB_DATABASE=company1_hrms
# DB_DATABASE=company2_hrms

# Setup each organization
php artisan migrate --env=company1
php artisan organization:setup --env=company1

php artisan migrate --env=company2  
php artisan organization:setup --env=company2
```

### Method 3: Subdomain Setup
```bash
# For subdomain deployment (org1.yourhrms.com, org2.yourhrms.com)
# Each subdomain points to separate installation
# Complete data isolation between organizations
```

## 🛠️ Quick Commands Reference

```bash
# Clear demo data (optional)
php artisan db:seed --class=ClearDemoDataSeeder

# Setup organization interactively
php artisan organization:setup

# Clear demo data during setup
php artisan organization:setup --clear-demo

# Automated setup with parameters
php artisan organization:setup \
  --company-name="Your Company" \
  --company-code="YOURCO" \
  --admin-email="admin@yourcompany.com" \
  --admin-password="SecurePass123!" \
  --phone="+1234567890" \
  --address="123 Business St"

# System maintenance
php artisan optimize:clear  # Clear all caches
php artisan migrate:fresh --seed  # Reset database (WARNING: Deletes all data)
```

## 🔐 Default System Features

### Employee Portal (`/employee/login`)
- Personal dashboard
- Time and attendance
- Leave requests
- Pay slips access
- Performance reviews
- Document management

### Admin Portal (`/admin/login`)
- Complete HR management
- Employee management
- Payroll processing
- Recruitment
- Performance management
- Reports and analytics

### Public Features (`/careers`)
- Job postings
- Online applications
- Company information

## ⚡ Quick Customization

### 1. Company Branding
- Logo: Admin > Company Settings
- Colors: Modify CSS themes
- Name: Automatically updated from setup

### 2. Add Departments
```php
// Via Admin panel or programmatically:
Department::create([
    'name' => 'Marketing',
    'description' => 'Marketing and communications'
]);
```

### 3. Add Locations
```php
SpecificArea::create([
    'name' => 'Regional Office - North',
    'description' => 'Northern regional office'
]);
```

## 🔍 Troubleshooting

### Common Issues:
1. **Database Connection**: Check `.env` database settings
2. **Permissions**: Ensure `storage/` and `bootstrap/cache/` are writable
3. **Missing Key**: Run `php artisan key:generate`
4. **Migration Errors**: Check database exists and credentials are correct

### Reset Commands:
```bash
# Clear all caches
php artisan optimize:clear

# Reset database (WARNING: Deletes all data)
php artisan migrate:fresh

# Check system status
php artisan inspire  # Verify Laravel is working
```

## 📞 Support

### Log Files
Check `storage/logs/laravel.log` for error details

### Database Issues
```bash
# Check database connection
php artisan tinker
DB::connection()->getPdo();
```

### Environment Issues
```bash
# Verify configuration
php artisan config:show
php artisan env:show
```

---

## 🎉 You're Ready!

Each organization gets:
- ✅ **Complete HR System** - All modules ready to use
- ✅ **Clean Setup** - No demo data interference  
- ✅ **Custom Branding** - Company-specific configuration
- ✅ **Scalable Structure** - Grow as organization grows
- ✅ **Professional Interface** - Modern, intuitive design

**Time per organization**: ~15 minutes  
**Effort**: Minimal - mostly automated  
**Result**: Production-ready HRMS system

**Start your first organization setup now:**
```bash
php artisan organization:setup
```
