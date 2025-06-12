# 🚀 HRMS Forge Quick Reference Guide

## 🔧 Common Deployment Commands

### Organization Setup (Run on Server)
```bash
# SSH into your Forge server
ssh forge@your-domain.com

# Navigate to site directory
cd /home/forge/your-domain.com

# Run organization setup
php artisan organization:setup \
  --company-name="Client Name" \
  --company-code="CLIENT" \
  --admin-email="admin@client.com" \
  --admin-password="SecurePass123" \
  --phone="+1234567890" \
  --address="123 Client St, City, State" \
  --website="https://client.com" \
  --clear-demo \
  --no-interaction
```

### Cache Management
```bash
# Clear all caches
php artisan optimize:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### Database Operations
```bash
# Run migrations
php artisan migrate --force

# Clear demo data
php artisan db:seed --class=ClearDemoDataSeeder

# Create admin user
php artisan make:admin-user
```

### Permission Fixes
```bash
# Fix Laravel permissions
sudo chown -R forge:www-data storage
sudo chown -R forge:www-data bootstrap/cache
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
```

## 🌐 Cloudflare Quick Setup

### DNS Records Template
```
# Main domain
A     @      YOUR_LINODE_IP      Proxied
CNAME www    yourdomain.com      Proxied

# Multi-client subdomains
CNAME client1  yourdomain.com    Proxied
CNAME client2  yourdomain.com    Proxied
```

### Essential Cloudflare Settings
- **SSL/TLS**: Full (strict)
- **Always Use HTTPS**: ON
- **Auto Minify**: CSS + JS + HTML
- **Brotli**: ON
- **Security Level**: Medium
- **Bot Fight Mode**: ON

### Page Rules for HRMS
```
1. *yourdomain.com/admin*
   - Cache Level: Bypass

2. *yourdomain.com/employee*
   - Cache Level: Bypass

3. *yourdomain.com/build/*
   - Cache Level: Cache Everything
   - Edge Cache TTL: 30 days
```

## 🔥 Laravel Forge Quick Tasks

### Deployment Script Template
```bash
cd $FORGE_SITE_PATH
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
npm ci --only=production
npm run build

# Fix permissions
sudo chown -R forge:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Quick Site Setup
1. **Create Site** → Enter domain
2. **Git Repository** → Connect repo
3. **Environment** → Update .env
4. **SSL** → LetsEncrypt certificate
5. **Deploy** → Trigger first deployment

### Database Management
```bash
# Create database
forge database:create client_hrms

# Create database user
forge database:user client_user password123

# Grant permissions
forge database:grant client_hrms client_user
```

## 🖥️ Linode Server Management

### Server Sizing Guide
| Organization Size | Plan | RAM | Storage | Cost/Month |
|---|---|---|---|---|
| < 50 employees | Nanode 1GB | 1GB | 25GB | $5 |
| 50-200 employees | Linode 2GB | 2GB | 50GB | $10 |
| 200+ employees | Linode 4GB | 4GB | 80GB | $20 |

### Server Monitoring
```bash
# Check server resources
htop
df -h
free -h

# Check services
sudo systemctl status nginx
sudo systemctl status mysql
sudo systemctl status php8.2-fpm
```

### Common Server Commands
```bash
# Restart services
sudo systemctl restart nginx
sudo systemctl restart mysql
sudo systemctl restart php8.2-fpm

# View logs
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/mysql/error.log
tail -f storage/logs/laravel.log
```

## 📊 Multi-Organization Deployment Strategy

### Option 1: Subdomains (Recommended)
```
client1.yourhrms.com → Separate Forge site
client2.yourhrms.com → Separate Forge site
client3.yourhrms.com → Separate Forge site
```

**Pros**: Complete isolation, easier management
**Cons**: More Forge sites to manage

### Option 2: Separate Servers
```
client1.com → Dedicated Linode server
client2.com → Dedicated Linode server
```

**Pros**: Complete isolation, custom domains
**Cons**: Higher costs, more servers to manage

### Option 3: Shared Server, Separate Databases
```
Same server, different databases:
- client1_hrms
- client2_hrms
- client3_hrms
```

**Pros**: Cost-effective
**Cons**: Shared resources, potential conflicts

## 🔍 Troubleshooting Quick Fixes

### Common Issues & Solutions

#### 502 Bad Gateway
```bash
# Check PHP-FPM
sudo systemctl status php8.2-fpm
sudo systemctl restart php8.2-fpm

# Check Nginx
sudo systemctl status nginx
sudo systemctl restart nginx
```

#### Database Connection Error
```bash
# Check MySQL
sudo systemctl status mysql
sudo systemctl restart mysql

# Test connection
mysql -u forge -p
```

#### SSL Certificate Issues
1. Check Cloudflare SSL mode: "Full (strict)"
2. Verify Forge SSL certificate
3. Check domain DNS propagation

#### Application Errors
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear caches
php artisan optimize:clear

# Fix permissions
sudo chown -R forge:www-data storage
sudo chmod -R 775 storage
```

#### Performance Issues
```bash
# Enable caching
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Check server resources
htop
df -h
```

## 💡 Pro Tips

### Forge Optimization
- Use deployment scripts for consistency
- Set up monitoring for all sites
- Configure automated backups
- Use staging environments for testing

### Cloudflare Optimization
- Enable Brotli compression
- Use appropriate caching rules
- Monitor analytics regularly
- Set up security rules for admin areas

### Linode Optimization
- Add swap file for small servers
- Monitor resource usage
- Set up automatic backups
- Use longviews for detailed monitoring

### Laravel Optimization
- Use Redis for caching and sessions
- Enable OPcache
- Optimize database queries
- Use queues for heavy operations

## 📞 Emergency Contacts & Resources

### Support Resources
- **Laravel Forge**: forge.laravel.com/support
- **Linode Support**: linode.com/support
- **Cloudflare Support**: support.cloudflare.com

### Useful Tools
- **SSL Checker**: ssllabs.com/ssltest
- **DNS Checker**: whatsmydns.net
- **Speed Test**: gtmetrix.com
- **Uptime Monitoring**: uptimerobot.com

### Quick Health Check URLs
```bash
# Test application
curl -I https://yourdomain.com

# Check SSL
curl -I https://yourdomain.com | grep -i ssl

# Test admin area
curl -I https://yourdomain.com/admin/login
```

---

## 🎯 Deployment Time Estimates

| Task | Time Estimate |
|------|---------------|
| Linode server setup | 10-15 minutes |
| Forge server connection | 10-15 minutes |
| Cloudflare DNS setup | 5-10 minutes |
| Site creation in Forge | 5-10 minutes |
| Initial deployment | 10-15 minutes |
| Organization setup | 5-10 minutes |
| Testing & verification | 15-30 minutes |
| **Total** | **60-90 minutes** |

**With experience, this process can be completed in under 60 minutes per organization!**
