# ✅ HRMS Organization Deployment Checklist

## Pre-Deployment Requirements

### System Requirements
- [ ] PHP 8.1+ installed with required extensions
- [ ] Composer installed
- [ ] MySQL/MariaDB database server
- [ ] Web server (Apache/Nginx) or use `php artisan serve`

### Database Setup
- [ ] Create new database for organization
- [ ] Configure database user with proper permissions
- [ ] Test database connection

## Deployment Steps

### Step 1: Code Setup
- [ ] Clone/copy HRMS codebase to deployment location
- [ ] Install dependencies: `composer install --no-dev --optimize-autoloader`
- [ ] Copy `.env.example` to `.env`
- [ ] Configure database settings in `.env`

### Step 2: Organization Setup
**Choose ONE option:**

#### Option A: PowerShell Script (Recommended)
- [ ] Run: `.\quick-setup.ps1`
- [ ] Follow interactive prompts

#### Option B: Command Prompt Script
- [ ] Run: `quick-setup.bat`
- [ ] Follow prompts

#### Option C: Manual Laravel Command
- [ ] Run: `php artisan key:generate`
- [ ] Run: `php artisan migrate --force`
- [ ] Run: `php artisan organization:setup`

### Step 3: Verification
- [ ] Start server: `php artisan serve`
- [ ] Visit: `http://localhost:8000/admin/login`
- [ ] Test admin login with configured credentials
- [ ] Verify organization name appears in system

## Post-Deployment Configuration

### Essential Setup
- [ ] Configure email settings in `.env`
- [ ] Set up file permissions (if on Linux/Mac)
- [ ] Configure backup procedures
- [ ] Set up SSL certificate (for production)

### Optional Customization
- [ ] Upload organization logo
- [ ] Customize system colors/theme
- [ ] Configure additional departments
- [ ] Set up employee import templates
- [ ] Configure payroll settings

### Security
- [ ] Change default admin password
- [ ] Review user permissions
- [ ] Configure session timeouts
- [ ] Set up two-factor authentication
- [ ] Review security logs

## Go-Live Checklist

### Final Steps
- [ ] Backup clean database state
- [ ] Test all major functions:
  - [ ] Employee management
  - [ ] Attendance tracking
  - [ ] Leave management
  - [ ] Payroll processing
  - [ ] Reports generation
- [ ] Train admin users
- [ ] Document organization-specific procedures

### Support Setup
- [ ] Document admin credentials (securely)
- [ ] Create user guides for organization
- [ ] Set up support contact information
- [ ] Schedule follow-up training sessions

## Troubleshooting

### Common Issues
- **Database errors**: Check connection settings and permissions
- **Permission errors**: Run `chmod -R 755 storage bootstrap/cache` (Linux/Mac)
- **Key errors**: Run `php artisan key:generate`
- **Cache issues**: Run `php artisan optimize:clear`

### Validation
- [ ] Run validation script: `.\validate-deployment.ps1`
- [ ] Check Laravel logs: `storage/logs/laravel.log`
- [ ] Verify database tables created correctly

---

## 📋 Organization Information Template

**Fill this out before starting deployment:**

- **Organization Name**: ________________________________
- **Organization Code**: ________________________________
- **Admin Email**: ______________________________________
- **Admin Password**: ___________________________________
- **Phone Number**: ____________________________________
- **Address**: _________________________________________
- **Website**: _________________________________________
- **Database Name**: ___________________________________
- **Deployment URL**: __________________________________

---

**✅ Deployment Complete!**

**Next Steps:**
1. Train users on the system
2. Begin adding employees and data
3. Configure advanced features as needed
4. Set up regular backups
5. Schedule system maintenance

**Support:** Refer to DEPLOYMENT_README.md for detailed instructions and troubleshooting.
