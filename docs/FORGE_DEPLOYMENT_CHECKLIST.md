# ✅ HRMS Deployment Checklist: Forge + Linode + Cloudflare

## 📋 Pre-Deployment Setup

### Account Setup
- [ ] **Linode Account** created and payment method added
- [ ] **Laravel Forge Account** active (forge.laravel.com)
- [ ] **Cloudflare Account** created (free tier sufficient)
- [ ] **GitHub/GitLab Repository** with HRMS code ready
- [ ] **Domain Name** registered and available

### Client Information Gathering
- [ ] **Organization Name**: _________________________________
- [ ] **Organization Code**: _________________________________
- [ ] **Domain Name**: _____________________________________
- [ ] **Admin Email**: ______________________________________
- [ ] **Admin Password**: ___________________________________
- [ ] **Company Phone**: ____________________________________
- [ ] **Company Address**: __________________________________
- [ ] **Company Website**: __________________________________

## 🖥️ Step 1: Linode Server Provisioning

### Server Creation
- [ ] **Login to Linode Dashboard**
- [ ] **Create New Linode Instance**:
  - [ ] **Distribution**: Ubuntu 22.04 LTS
  - [ ] **Region**: Choose closest to client
  - [ ] **Plan Selected**:
    - [ ] Nanode 1GB ($5/month) - Small org (<50 employees)
    - [ ] Linode 2GB ($10/month) - Medium org (50-200 employees)  
    - [ ] Linode 4GB ($20/month) - Large org (200+ employees)
  - [ ] **Root Password**: Strong password saved securely
  - [ ] **SSH Keys**: Added (if available)

### Server Details
- [ ] **Server IP Address**: ________________________________
- [ ] **Root Password**: Saved in password manager
- [ ] **SSH Access**: Verified working

### Initial Server Setup
```bash
# Connect and update
ssh root@YOUR_SERVER_IP
apt update && apt upgrade -y

# Create swap (for 1GB servers)
fallocate -l 1G /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo '/swapfile none swap sw 0 0' | tee -a /etc/fstab
```

- [ ] **Server Updated**: System packages updated
- [ ] **Swap File Created**: (for servers with <2GB RAM)
- [ ] **Firewall Configured**: Basic firewall rules applied

## 🔥 Step 2: Laravel Forge Server Setup

### Connect Server to Forge
- [ ] **Login to Laravel Forge**
- [ ] **Create New Server**:
  - [ ] **Server Type**: Custom VPS
  - [ ] **Server Name**: `hrms-[client-name]` or `hrms-production`
  - [ ] **IP Address**: Linode server IP
  - [ ] **Server Provider**: Custom VPS
  - [ ] **Server Size**: Select appropriate size

### Forge Server Configuration
- [ ] **PHP Version**: 8.1 or 8.2 selected
- [ ] **Database**: MySQL 8.0 selected
- [ ] **Web Server**: Nginx selected
- [ ] **Node.js**: Latest LTS selected
- [ ] **Redis**: Selected (recommended for caching)
- [ ] **Memcached**: Optional (can be added later)

### Wait for Forge Setup
- [ ] **Server Provisioning**: Completed (usually 5-10 minutes)
- [ ] **Server Status**: Active in Forge dashboard
- [ ] **SSH Access**: Forge can connect to server

## 🌐 Step 3: Cloudflare DNS Configuration

### Add Domain to Cloudflare
- [ ] **Domain Added**: Added to Cloudflare dashboard
- [ ] **Nameservers Updated**: Domain registrar updated with Cloudflare nameservers
- [ ] **DNS Active**: Cloudflare shows "Active" status

### DNS Records Configuration
- [ ] **A Record**: `@` pointing to Linode server IP (Proxied ☁️)
- [ ] **CNAME Record**: `www` pointing to domain (Proxied ☁️)
- [ ] **Additional Subdomains** (if needed):
  - [ ] `client1` → domain (for multi-org setup)
  - [ ] `client2` → domain (for multi-org setup)

### Cloudflare SSL/TLS Settings
- [ ] **SSL/TLS Mode**: Set to "Full (strict)"
- [ ] **Always Use HTTPS**: Enabled
- [ ] **HSTS**: Enabled
- [ ] **Minimum TLS Version**: 1.2

### Cloudflare Security Settings
- [ ] **Security Level**: Medium
- [ ] **Bot Fight Mode**: Enabled
- [ ] **DDoS Protection**: Enabled (automatic)
- [ ] **Firewall Rules**: Basic rules configured

### Cloudflare Performance Settings
- [ ] **Auto Minify**: CSS, JavaScript, HTML enabled
- [ ] **Brotli Compression**: Enabled
- [ ] **Caching Rules**: Configured for static assets
- [ ] **Page Rules**: Set up to bypass cache for admin areas

## 🚀 Step 4: Site Creation in Forge

### Create New Site
- [ ] **Site Created** in Forge:
  - [ ] **Domain**: Correct domain entered
  - [ ] **Project Type**: Laravel
  - [ ] **Web Directory**: `/public`
  - [ ] **PHP Version**: Matches server PHP version

### Git Repository Connection
- [ ] **Repository Connected**:
  - [ ] **Provider**: GitHub/GitLab
  - [ ] **Repository**: Correct HRMS repository
  - [ ] **Branch**: `main` or `master`
  - [ ] **Deploy Key**: Added to repository (if private)

### Environment Configuration
- [ ] **Environment File** (.env) configured with:
  - [ ] **App Settings**: Name, URL, environment
  - [ ] **Database Settings**: Host, database, credentials
  - [ ] **Mail Settings**: SMTP configuration
  - [ ] **Cache Settings**: Redis configuration
  - [ ] **Queue Settings**: Redis or database

### Database Setup
- [ ] **Database Created** in Forge
- [ ] **Database User**: Created with proper permissions
- [ ] **Database Connection**: Tested and working

## 🔒 Step 5: SSL Certificate & Security

### SSL Certificate
- [ ] **Let's Encrypt Certificate**: Obtained through Forge
- [ ] **Certificate Domains**: Includes both domain and www.domain
- [ ] **Auto-Renewal**: Enabled
- [ ] **HTTPS Redirect**: Configured in Nginx

### Security Configuration
- [ ] **Nginx Configuration**: Cloudflare IP ranges configured
- [ ] **File Permissions**: Laravel directories have correct permissions
- [ ] **Environment File**: Secured (not web accessible)

## ⚙️ Step 6: Application Deployment

### Initial Deployment
- [ ] **Deploy Script**: Custom deployment script configured
- [ ] **Initial Deploy**: Triggered from Forge
- [ ] **Composer Install**: Dependencies installed successfully
- [ ] **NPM Build**: Frontend assets built (if applicable)

### Database Migration
- [ ] **Migrations Run**: Database tables created
- [ ] **Migration Success**: No errors in deployment log

### Organization Setup
- [ ] **SSH into Server**: Connected successfully
- [ ] **Organization Setup Command**: Run with correct parameters
- [ ] **Admin User Created**: Successfully created
- [ ] **Demo Data Cleared**: Existing demo data removed
- [ ] **Basic Structure**: Departments and job families created

### Post-Deployment Tasks
- [ ] **Caches Cleared**: All Laravel caches cleared
- [ ] **Permissions Set**: Storage and cache directories writable
- [ ] **Queue Workers**: Started (if using queues)
- [ ] **Scheduled Tasks**: Cron jobs configured

## 🧪 Step 7: Testing & Verification

### SSL & Security Testing
- [ ] **HTTPS Access**: Site loads over HTTPS
- [ ] **SSL Certificate**: Valid and properly configured
- [ ] **Security Headers**: HSTS and other headers present
- [ ] **Mixed Content**: No mixed HTTP/HTTPS content

### Application Testing
- [ ] **Homepage**: Loads correctly
- [ ] **Admin Login**: `/admin/login` accessible
- [ ] **Admin Dashboard**: Admin can log in and access dashboard
- [ ] **Employee Login**: `/employee/login` accessible
- [ ] **Public Pages**: `/careers` and other public pages work

### Performance Testing
- [ ] **Page Load Speed**: Acceptable load times (<3 seconds)
- [ ] **Cloudflare Caching**: Cache hit ratio >70%
- [ ] **Database Performance**: Queries execute efficiently
- [ ] **Mobile Responsiveness**: Site works on mobile devices

### Functionality Testing
- [ ] **Employee Management**: Can create/edit employees
- [ ] **Attendance System**: Attendance tracking works
- [ ] **Leave Management**: Leave requests function
- [ ] **Payroll System**: Payroll calculations work
- [ ] **Reports**: Can generate basic reports

## 📊 Step 8: Monitoring & Backup Setup

### Monitoring Configuration
- [ ] **Forge Monitoring**: Server monitoring enabled
- [ ] **Uptime Monitoring**: Site uptime monitoring active
- [ ] **Email Alerts**: Configured for downtime/issues
- [ ] **Log Monitoring**: Error logs being monitored

### Backup Configuration
- [ ] **Database Backups**: Automated daily backups
- [ ] **File Backups**: Application files backed up
- [ ] **Backup Storage**: Backups stored securely (S3, etc.)
- [ ] **Backup Testing**: Restore process tested

### Performance Monitoring
- [ ] **Cloudflare Analytics**: Monitoring traffic and performance
- [ ] **Server Resources**: CPU, memory, disk usage monitored
- [ ] **Database Performance**: Query performance monitored

## 📋 Step 9: Documentation & Handover

### Client Documentation
- [ ] **Login Credentials**: Provided securely to client
- [ ] **Staff User Guide**: `docs/USER_GUIDE_STAFF.md` provided to all employees
- [ ] **Admin User Guide**: `docs/USER_GUIDE_ADMIN.md` provided to administrators
- [ ] **Training Guide**: `docs/TRAINING_GUIDE.md` provided for implementation
- [ ] **Support Information**: Contact details for support

### System Documentation
- [ ] **Server Details**: IP, credentials documented
- [ ] **Deployment Process**: Documented for future updates
- [ ] **Configuration Details**: Environment and settings documented
- [ ] **Troubleshooting Guide**: Common issues and solutions

### Knowledge Transfer
- [ ] **Client Training**: Basic system training provided
- [ ] **Admin Training**: Administrator training completed
- [ ] **Support Handover**: Ongoing support arrangements made

## 🔄 Step 10: Go-Live & Post-Launch

### Final Pre-Launch Checks
- [ ] **All Tests Passed**: Complete testing checklist verified
- [ ] **Client Approval**: Client has approved the system
- [ ] **Backup Verified**: Recent backup confirmed working
- [ ] **Support Ready**: Support team prepared for launch

### Launch Activities
- [ ] **DNS Propagation**: Confirmed globally propagated
- [ ] **Final Testing**: Live site tested end-to-end
- [ ] **Client Notification**: Client informed of go-live
- [ ] **Monitoring Active**: All monitoring systems active

### Post-Launch Follow-up
- [ ] **24-Hour Check**: System stable after 24 hours
- [ ] **Performance Review**: Performance metrics reviewed
- [ ] **Client Feedback**: Initial feedback collected
- [ ] **Issues Addressed**: Any launch issues resolved

## 💰 Cost Summary

### Monthly Costs
- [ ] **Linode Server**: $5-20/month (depending on size)
- [ ] **Laravel Forge**: $12/month
- [ ] **Cloudflare**: Free (or Pro $20/month)
- [ ] **Domain**: ~$1/month (annual payment)
- [ ] **Total**: ~$18-33/month per organization

### One-Time Costs
- [ ] **Setup Time**: 2-4 hours (labor cost)
- [ ] **Domain Registration**: $10-15/year
- [ ] **SSL Certificate**: Free (Let's Encrypt)

## 📞 Support & Maintenance Plan

### Regular Maintenance
- [ ] **Security Updates**: Monthly server updates
- [ ] **Application Updates**: Laravel/package updates
- [ ] **Backup Verification**: Monthly backup tests
- [ ] **Performance Review**: Quarterly performance analysis

### Support Contacts
- [ ] **Primary Support**: _________________________________
- [ ] **Emergency Contact**: _______________________________
- [ ] **Client Contact**: ___________________________________

---

## 🎉 Deployment Complete!

**Congratulations! Your HRMS system is now live and ready for use.**

### Next Steps for Client:
1. **Start Adding Employees**: Begin entering employee data
2. **Configure Advanced Settings**: Customize payroll, leave policies
3. **User Training**: Train staff on system usage
4. **Regular Backups**: Ensure backup procedures are followed

### Quick Access URLs:
- **Admin Portal**: https://[domain]/admin/login
- **Employee Portal**: https://[domain]/employee/login
- **Public Careers**: https://[domain]/careers

**Support**: Contact your deployment team for any questions or issues.
