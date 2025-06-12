# HRMS Organization Setup Guide

This guide will help you quickly set up the HRMS system for a new organization.

## Quick Setup Process (15 minutes)

### Step 1: Environment Setup
1. Copy `.env.example` to `.env`
2. Run the setup command: `php artisan organization:setup`
3. Follow the interactive prompts

### Step 2: Organization Information
You'll be prompted to enter:
- **Company Name**: Your organization's full name
- **Company Code**: Short code (e.g., "ACME", "TECH")
- **Email Domain**: Your company email domain
- **Admin Email**: Primary admin email address
- **Admin Password**: Secure password for admin account
- **Company Address**: Full address
- **Phone Number**: Contact number
- **Website**: Company website (optional)

### Step 3: Organizational Structure
Configure your:
- **Departments**: Main business units
- **Job Families**: Categories of roles
- **Locations/Branches**: Multiple office locations
- **Employment Types**: Full-time, Part-time, Contract, etc.

### Step 4: System Configuration
- Upload company logo
- Set timezone
- Configure payroll settings
- Set up leave policies

## Manual Setup Alternative

If you prefer manual setup, follow these steps:

### 1. Database Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Clear existing demo data (optional)
php artisan db:seed --class=ClearDemoDataSeeder

# Seed with basic system data
php artisan db:seed --class=BasicSystemSeeder
```

### 2. Create Admin User
```bash
php artisan make:admin-user
```

### 3. Configure Company Settings
```bash
php artisan tinker
```

Then run:
```php
// Update company information
$company = App\Models\Company::first();
$company->update([
    'name' => 'Your Company Name',
    'code' => 'YOURCODE',
    'email' => 'admin@yourcompany.com',
    'phone' => '+1234567890',
    'address' => 'Your Company Address',
    'website' => 'https://yourcompany.com'
]);
```

## Post-Setup Tasks

### 1. Upload Company Logo
- Go to Admin Dashboard > Company Settings
- Upload your company logo (recommended: 200x200px PNG)

### 2. Configure Departments
- Admin Dashboard > Organization > Departments
- Add your company's departments

### 3. Set Up Job Families
- Admin Dashboard > Organization > Job Families
- Define role categories

### 4. Add Locations/Branches
- Admin Dashboard > Organization > Locations
- Add office locations

### 5. Configure Payroll Settings
- Admin Dashboard > Payroll > Settings
- Set pay periods, tax rates, benefits

## Default Login Information

After setup, use these credentials:

**Admin Login**: `/admin/login`
- Email: [Your configured admin email]
- Password: [Your configured password]

**Employee Login**: `/employee/login`
- Employees will be created with temporary passwords

## System URLs

- **Admin Dashboard**: `http://localhost:8000/admin`
- **Employee Portal**: `http://localhost:8000/employee`
- **Public Job Board**: `http://localhost:8000/careers`

## Backup and Migration

### Creating a Clean Template
After initial setup, create a backup:
```bash
# Export clean database structure
php artisan backup:database --clean

# Create deployment package
php artisan package:create
```

### Deploying to New Environment
```bash
# Import database structure
php artisan backup:restore

# Run organization setup
php artisan organization:setup
```

## Troubleshooting

### Common Issues:
1. **Database Connection**: Check your `.env` file database settings
2. **Permissions**: Ensure `storage/` and `bootstrap/cache/` are writable
3. **Key Generation**: Run `php artisan key:generate` if app key is missing

### Support Commands:
```bash
# Clear all caches
php artisan optimize:clear

# Reset database (WARNING: Deletes all data)
php artisan migrate:fresh --seed

# Check system status
php artisan system:check
```

## Security Notes

1. **Change Default Passwords**: Always change default passwords
2. **Environment File**: Never commit `.env` file to version control
3. **Database Backup**: Regular backups recommended
4. **SSL Certificate**: Use HTTPS in production
5. **Access Control**: Configure proper user permissions

## Multi-Organization Deployment

For managing multiple organizations:

1. **Separate Databases**: Each organization should have its own database
2. **Environment Variables**: Use different `.env` files
3. **Subdomain Setup**: Consider `org1.hrms.com`, `org2.hrms.com`
4. **Data Isolation**: Ensure complete data separation between organizations

---

**Need Help?** 
- Check the logs in `storage/logs/`
- Run `php artisan system:check` for diagnostics
- Contact support with your organization setup requirements
