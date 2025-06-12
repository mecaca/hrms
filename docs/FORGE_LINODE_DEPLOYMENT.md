# 🚀 HRMS Deployment Guide: Laravel Forge + Linode + Cloudflare

## Overview

This guide covers deploying your HRMS system using:
- **Laravel Forge** for server management and deployment
- **Linode** for cloud hosting infrastructure
- **Cloudflare** for DNS, CDN, and security

## 🏗️ Architecture Overview

```
[Client] → [Cloudflare CDN/DNS] → [Linode Server] → [Laravel Forge] → [HRMS App]
```

## 📋 Prerequisites

### Required Accounts
- [ ] **Laravel Forge** account (forge.laravel.com)
- [ ] **Linode** account (linode.com)
- [ ] **Cloudflare** account (cloudflare.com)
- [ ] **GitHub/GitLab** repository with your HRMS code

### Domain Requirements
- [ ] Domain name registered
- [ ] Domain transferred to Cloudflare DNS (or nameservers pointed to Cloudflare)

## 🔧 Step 1: Linode Server Setup

### 1.1 Create Linode Instance
1. **Login to Linode Dashboard**
2. **Create New Linode**:
   - **Distribution**: Ubuntu 22.04 LTS
   - **Region**: Choose closest to your users
   - **Plan**: 
     - **Development**: Nanode 1GB ($5/month)
     - **Production**: Linode 2GB ($10/month) or higher
   - **Root Password**: Strong password (save securely)
   - **SSH Keys**: Add your public key (recommended)

### 1.2 Server Specifications by Usage

#### Small Organization (< 50 employees)
- **Plan**: Nanode 1GB
- **RAM**: 1GB
- **CPU**: 1 Core
- **Storage**: 25GB SSD
- **Cost**: ~$5/month

#### Medium Organization (50-200 employees)
- **Plan**: Linode 2GB
- **RAM**: 2GB
- **CPU**: 1 Core
- **Storage**: 50GB SSD
- **Cost**: ~$10/month

#### Large Organization (200+ employees)
- **Plan**: Linode 4GB or higher
- **RAM**: 4GB+
- **CPU**: 2+ Cores
- **Storage**: 80GB+ SSD
- **Cost**: ~$20+/month

### 1.3 Initial Server Configuration
```bash
# Connect to your server
ssh root@your-server-ip

# Update system
apt update && apt upgrade -y

# Create swap file (recommended for 1GB servers)
fallocate -l 1G /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo '/swapfile none swap sw 0 0' | tee -a /etc/fstab
```

## 🔥 Step 2: Laravel Forge Integration

### 2.1 Connect Forge to Linode
1. **Login to Laravel Forge**
2. **Go to Servers → Create Server**
3. **Select "Custom VPS"**
4. **Enter Server Details**:
   - **Name**: `hrms-production` (or client name)
   - **IP Address**: Your Linode server IP
   - **Username**: `forge`
   - **Password**: Leave blank (Forge will set this up)

### 2.2 Forge Server Configuration
Choose your stack:
- **PHP Version**: 8.1 or 8.2
- **Database**: MySQL 8.0
- **Web Server**: Nginx (recommended)
- **Node.js**: Latest LTS
- **Cache**: Redis (optional but recommended)

### 2.3 Wait for Forge Setup
- Forge will automatically install and configure the server
- This typically takes 5-10 minutes
- Monitor the setup progress in Forge dashboard

## 🌐 Step 3: Domain & Cloudflare Setup

### 3.1 Configure Cloudflare DNS
1. **Add Site to Cloudflare**
2. **Create DNS Records**:
   ```
   Type: A
   Name: @ (or your subdomain)
   Content: Your Linode server IP
   Proxy: Enabled (orange cloud)
   
   Type: CNAME
   Name: www
   Content: yourdomain.com
   Proxy: Enabled
   ```

### 3.2 Cloudflare Settings
**SSL/TLS Settings**:
- **SSL/TLS encryption mode**: Full (strict)
- **Always Use HTTPS**: On
- **Minimum TLS Version**: 1.2

**Security Settings**:
- **Security Level**: Medium
- **Bot Fight Mode**: On
- **Challenge Passage**: 30 minutes

**Speed Settings**:
- **Auto Minify**: CSS, JavaScript, HTML
- **Brotli**: On
- **Rocket Loader**: Off (can cause issues with some JS)

## 🚀 Step 4: Deploy HRMS Application

### 4.1 Create Site in Forge
1. **Go to your Forge server**
2. **Click "New Site"**
3. **Site Details**:
   - **Domain**: `yourdomain.com`
   - **Project Type**: Laravel
   - **Web Directory**: `/public` (default)

### 4.2 Connect Git Repository
1. **Go to Site → Git Repository**
2. **Connect Repository**:
   - **Provider**: GitHub/GitLab
   - **Repository**: `your-username/hrms`
   - **Branch**: `main` or `master`
3. **Deploy Script**: Use the custom deploy script below

### 4.3 Custom Deploy Script for HRMS
```bash
cd /home/forge/yourdomain.com
git pull origin $FORGE_SITE_BRANCH

$FORGE_COMPOSER install --no-interaction --prefer-dist --optimize-autoloader --no-dev

if [ -f artisan ]; then
    $FORGE_PHP artisan migrate --force
    $FORGE_PHP artisan config:cache
    $FORGE_PHP artisan route:cache
    $FORGE_PHP artisan view:cache
    $FORGE_PHP artisan queue:restart
    $FORGE_PHP artisan optimize
fi

# Build frontend assets
npm install --production
npm run build
```

### 4.4 Environment Configuration
1. **Go to Site → Environment**
2. **Update .env variables**:
```env
APP_NAME="Client HRMS"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forge
DB_USERNAME=forge
DB_PASSWORD=your-db-password

# Mail Configuration (using services like Mailgun, SES, etc.)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=your-mailgun-username
MAIL_PASSWORD=your-mailgun-password
MAIL_ENCRYPTION=tls

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis Configuration
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## 🔒 Step 5: SSL Certificate & Security

### 5.1 SSL Certificate in Forge
1. **Go to Site → SSL**
2. **Choose "LetsEncrypt"**
3. **Domains**: `yourdomain.com,www.yourdomain.com`
4. **Click "Obtain Certificate"**

### 5.2 Configure Nginx for Cloudflare
Add this to your Nginx configuration in Forge:
```nginx
# Cloudflare IPs - restore real visitor IP
set_real_ip_from 103.21.244.0/22;
set_real_ip_from 103.22.200.0/22;
set_real_ip_from 103.31.4.0/22;
set_real_ip_from 104.16.0.0/13;
set_real_ip_from 104.24.0.0/14;
set_real_ip_from 108.162.192.0/18;
set_real_ip_from 131.0.72.0/22;
set_real_ip_from 141.101.64.0/18;
set_real_ip_from 162.158.0.0/15;
set_real_ip_from 172.64.0.0/13;
set_real_ip_from 173.245.48.0/20;
set_real_ip_from 188.114.96.0/20;
set_real_ip_from 190.93.240.0/20;
set_real_ip_from 197.234.240.0/22;
set_real_ip_from 198.41.128.0/17;
real_ip_header CF-Connecting-IP;
```

## ⚙️ Step 6: Organization Setup

### 6.1 Database Setup
1. **Go to Forge → Database**
2. **Create Database** for the organization
3. **Update .env** with database credentials

### 6.2 Run Organization Setup
SSH into your server and run:
```bash
cd /home/forge/yourdomain.com
php artisan organization:setup \
  --company-name="Client Company Name" \
  --company-code="CLIENT" \
  --admin-email="admin@clientdomain.com" \
  --admin-password="SecurePassword123" \
  --phone="+1234567890" \
  --address="123 Client St, City, State 12345" \
  --website="https://clientdomain.com" \
  --clear-demo \
  --no-interaction
```

### 6.3 Post-Setup Tasks
```bash
# Clear all caches
php artisan optimize:clear

# Generate application key if needed
php artisan key:generate

# Set proper permissions
chown -R forge:www-data storage
chown -R forge:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## 📊 Step 7: Monitoring & Maintenance

### 7.1 Enable Forge Monitoring
- **Site Monitoring**: Enable uptime monitoring
- **Server Monitoring**: CPU, memory, disk usage
- **Database Monitoring**: Connection and performance metrics

### 7.2 Backup Configuration
```bash
# Database backup (daily)
php artisan backup:run --only-db

# Full backup (weekly)
php artisan backup:run
```

### 7.3 Log Monitoring
Monitor these logs:
- **Laravel Logs**: `storage/logs/laravel.log`
- **Nginx Logs**: `/var/log/nginx/`
- **MySQL Logs**: `/var/log/mysql/`

## 🔄 Step 8: Multi-Organization Deployment

### 8.1 Subdomain Strategy
For multiple organizations, use subdomains:
- `client1.yourhrms.com`
- `client2.yourhrms.com`
- `client3.yourhrms.com`

### 8.2 Cloudflare Subdomain Setup
```
Type: CNAME
Name: client1
Content: yourhrms.com
Proxy: Enabled

Type: CNAME
Name: client2
Content: yourhrms.com
Proxy: Enabled
```

### 8.3 Forge Multi-Site Setup
1. **Create new site** for each organization
2. **Use same server** (cost-effective)
3. **Separate databases** for each client
4. **Independent deployments**

## 💰 Cost Breakdown

### Monthly Costs (per organization)
- **Linode Server**: $5-20/month
- **Laravel Forge**: $12/month
- **Cloudflare**: Free (Pro $20/month optional)
- **Domain**: $10-15/year
- **SSL**: Free (Let's Encrypt)

### Shared Infrastructure
- **One Linode server** can host multiple organizations
- **One Forge subscription** can manage multiple sites
- **One Cloudflare account** can handle multiple domains

## 🚨 Troubleshooting

### Common Issues

#### 1. 502 Bad Gateway
```bash
# Check PHP-FPM status
sudo systemctl status php8.1-fpm

# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
```

#### 2. Database Connection Issues
```bash
# Check MySQL status
sudo systemctl status mysql

# Check database credentials in .env
```

#### 3. SSL Certificate Issues
- Ensure Cloudflare SSL is set to "Full (strict)"
- Verify Let's Encrypt certificate is installed
- Check that both domain and www.domain are covered

#### 4. Performance Issues
```bash
# Enable Redis cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Check server resources
htop
df -h
```

## 📋 Deployment Checklist

### Pre-Deployment
- [ ] Linode server created and configured
- [ ] Forge server connected and provisioned
- [ ] Domain configured in Cloudflare
- [ ] DNS records pointing to server
- [ ] SSL certificate obtained

### Deployment
- [ ] Git repository connected to Forge
- [ ] Environment variables configured
- [ ] Database created and migrated
- [ ] Organization setup completed
- [ ] Frontend assets built and deployed

### Post-Deployment
- [ ] SSL certificate verified
- [ ] Site monitoring enabled
- [ ] Backups configured
- [ ] Performance optimization applied
- [ ] Admin login tested
- [ ] Employee portal tested

## 🎯 Performance Optimization

### Server Level
```bash
# Enable OPcache
sudo nano /etc/php/8.1/fpm/php.ini
# opcache.enable=1
# opcache.memory_consumption=128

# Configure PHP-FPM
sudo nano /etc/php/8.1/fpm/pool.d/www.conf
# pm.max_children = 50
# pm.start_servers = 5
# pm.min_spare_servers = 5
# pm.max_spare_servers = 35
```

### Application Level
```bash
# Enable Laravel optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Enable compression
# (Already handled by Cloudflare)
```

### Database Optimization
```sql
-- Add indexes for performance
CREATE INDEX idx_employees_status ON employees(employment_status);
CREATE INDEX idx_attendances_date ON attendances(date);
CREATE INDEX idx_users_email ON users(email);
```

---

## 🎉 Conclusion

This setup provides:
- ✅ **Scalable infrastructure** with Linode
- ✅ **Automated deployments** with Forge
- ✅ **Global CDN and security** with Cloudflare
- ✅ **Professional SSL certificates**
- ✅ **Easy multi-organization management**
- ✅ **Cost-effective hosting** (~$17-32/month per org)

**Your HRMS is now production-ready and can be deployed to unlimited organizations using this battle-tested stack!**
