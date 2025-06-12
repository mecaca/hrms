# 🚀 HRMS Multi-Organization Deployment Kit

> **Perfect for deploying to separate organizations quickly and easily**

## ⚡ Deployment Options

### 🌟 Production Deployment (Laravel Forge + Linode + Cloudflare)
**Recommended for client deployments - Professional, scalable, secure**
```bash
# Complete production setup in ~60 minutes
# See FORGE_LINODE_DEPLOYMENT.md for full guide
```
- ✅ **Automated deployments** with Laravel Forge
- ✅ **Reliable hosting** on Linode cloud servers  
- ✅ **Global CDN & security** with Cloudflare
- ✅ **SSL certificates** automatically managed
- ✅ **Professional deployment** process
- 💰 **Cost**: ~$17-32/month per organization

### ⚡ Local Development Setup
**For testing and development**

#### Option 1: PowerShell (Windows - Recommended)
```powershell
# Run this in PowerShell as Administrator
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
./quick-setup.ps1
```

#### Option 2: Command Prompt (Windows)
```cmd
quick-setup.bat
```

#### Option 3: Manual Setup
```bash
# Basic setup
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
php artisan migrate --force

# Interactive organization setup
php artisan organization:setup

# Start server
php artisan serve
```

## 📚 Deployment Guides

| Deployment Type | Guide | Best For | Time | Cost |
|---|---|---|---|---|
| **Production** | `FORGE_LINODE_DEPLOYMENT.md` | Client deployments | 60-90 min | $17-32/month |
| **Quick Local** | `QUICK_DEPLOYMENT.md` | Development/testing | 5-10 min | Free |
| **Manual Setup** | `ORGANIZATION_SETUP.md` | Custom configurations | 15-30 min | Free |
| **Checklist** | `FORGE_DEPLOYMENT_CHECKLIST.md` | Step-by-step guide | - | - |

## 🎯 What You Get

✅ **Complete HRMS System** for individual organizations  
✅ **Clean Installation** with no demo data interference  
✅ **Custom Branding** ready for your organization  
✅ **Multi-Department Support** within same company  
✅ **Multi-Location Support** for branches/offices  
✅ **Professional Dashboard** for admin and employees  

## 🏢 Organization Features

### For Administrators (`/admin/login`)
- **Employee Management** - Complete lifecycle management
- **Payroll System** - Automated salary processing
- **Attendance Tracking** - Time logs and reports
- **Performance Management** - Reviews and evaluations
- **Recruitment** - Job postings and applications
- **Reports & Analytics** - Comprehensive reporting

### For Employees (`/employee/login`)
- **Personal Dashboard** - Overview of key information
- **Time & Attendance** - Clock in/out and time tracking
- **Leave Management** - Request and track leave
- **Payroll Access** - View pay stubs and salary history
- **Performance Reviews** - Access evaluation results
- **Document Center** - Company documents and policies

### Public Features (`/careers`)
- **Job Board** - Current open positions
- **Online Applications** - Apply directly through website
- **Company Information** - About the organization

## 📋 Pre-Requirements

- **PHP 8.1+** with extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON
- **Composer** (latest version)
- **Database** (MySQL 5.7+ or MariaDB 10.3+)
- **Web Server** (Apache, Nginx, or use `php artisan serve` for development)

## 🔧 Configuration Options

### Database Setup
```env
# Edit .env file for your database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_hrms_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Email Configuration
```env
# For sending notifications
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

## 🏗️ Multi-Organization Deployment Strategies

### Strategy 1: Separate Installations (Recommended)
```bash
# For each organization
git clone [hrms-repo] organization-name-hrms
cd organization-name-hrms
./quick-setup.ps1
```
**Benefits:** Complete isolation, easy backup, independent updates

### Strategy 2: Shared Codebase, Separate Databases
```bash
# Create separate databases
mysql -u root -p -e "CREATE DATABASE org1_hrms;"
mysql -u root -p -e "CREATE DATABASE org2_hrms;"

# Configure separate .env files
cp .env org1.env
cp .env org2.env
# Edit database names in each .env file

# Setup each organization
php artisan migrate --env=org1
php artisan organization:setup --env=org1
```

### Strategy 3: Subdomain Deployment
```
org1.yourhrms.com → /var/www/org1-hrms/
org2.yourhrms.com → /var/www/org2-hrms/
org3.yourhrms.com → /var/www/org3-hrms/
```

## ⚙️ Advanced Setup Commands

```bash
# Create admin user manually
php artisan make:admin-user

# Clear demo data only
php artisan db:seed --class=ClearDemoDataSeeder

# Setup with specific parameters (no interaction)
php artisan organization:setup \
  --company-name="Acme Corporation" \
  --company-code="ACME" \
  --admin-email="admin@acme.com" \
  --admin-password="SecurePass123!" \
  --phone="+1234567890" \
  --address="123 Business St" \
  --website="https://acme.com" \
  --clear-demo \
  --no-interaction

# Reset entire system (WARNING: Deletes all data)
php artisan migrate:fresh --seed
```

## 📊 Post-Setup Checklist

### Immediate Tasks (First Login)
- [ ] Upload company logo
- [ ] Verify company information
- [ ] Review and customize departments
- [ ] Set up job families and titles
- [ ] Configure locations/branches

### System Configuration
- [ ] Set up payroll preferences
- [ ] Configure leave policies
- [ ] Set working hours and schedules
- [ ] Configure email notifications
- [ ] Set up user permissions

### Data Entry
- [ ] Add department heads
- [ ] Create job positions
- [ ] Import existing employees (if any)
- [ ] Set up organizational hierarchy

## 🛠️ Troubleshooting

### Common Issues

**Database Connection Failed**
```bash
# Check database credentials in .env
# Ensure database exists
mysql -u root -p -e "CREATE DATABASE hrms_database;"
```

**Permission Denied**
```bash
# Fix file permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

**Command Not Found**
```bash
# Clear application cache
php artisan optimize:clear
```

**Migration Errors**
```bash
# Reset migrations (WARNING: Deletes data)
php artisan migrate:fresh
```

### Getting Help
1. Check `storage/logs/laravel.log` for error details
2. Run `php artisan optimize:clear` to clear caches
3. Verify PHP extensions with `php -m`
4. Test database connection with `php artisan tinker` then `DB::connection()->getPdo()`

## 🔒 Security Notes

- **Change default passwords** immediately after setup
- **Use HTTPS** in production environments
- **Regular backups** of database and uploaded files
- **Update regularly** to get security patches
- **Restrict file permissions** appropriately

## 📈 Scaling & Maintenance

### Regular Maintenance
```bash
# Weekly tasks
php artisan optimize
php artisan backup:run

# Monthly tasks
php artisan activitylog:clean
php artisan queue:prune-failed

# Annual tasks
php artisan backup:clean
```

### Performance Optimization
```bash
# Production optimization
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📞 Support & Documentation

- **Setup Guide**: `ORGANIZATION_SETUP.md`
- **Quick Deployment**: `QUICK_DEPLOYMENT.md`
- **Configuration Template**: `organization-config.template`
- **Application Logs**: `storage/logs/laravel.log`

---

## 🎉 Success!

After setup, you'll have a complete HRMS system ready for:
- **Employee onboarding and management**
- **Payroll processing and reporting**
- **Attendance tracking and analysis**
- **Performance management cycles**
- **Recruitment and hiring processes**
- **Document management and storage**

**Average setup time per organization: 10-15 minutes**  
**Ready for production use immediately after setup**
