# 🌐 Cloudflare Configuration for HRMS Deployment

## DNS Configuration

### Basic DNS Records for Single Organization
```
Type: A
Name: @
Content: YOUR_LINODE_SERVER_IP
Proxy: ✅ Proxied (Orange Cloud)
TTL: Auto

Type: CNAME
Name: www
Content: yourdomain.com
Proxy: ✅ Proxied (Orange Cloud)
TTL: Auto
```

### Multi-Organization Setup (Subdomains)
```
# Main domain
Type: A
Name: @
Content: YOUR_LINODE_SERVER_IP
Proxy: ✅ Proxied

# Client subdomains
Type: CNAME
Name: client1
Content: yourdomain.com
Proxy: ✅ Proxied

Type: CNAME
Name: client2
Content: yourdomain.com
Proxy: ✅ Proxied

Type: CNAME
Name: client3
Content: yourdomain.com
Proxy: ✅ Proxied
```

### Email Records (Optional)
```
Type: MX
Name: @
Content: mail.yourdomain.com
Priority: 10
Proxy: ❌ DNS Only

Type: A
Name: mail
Content: YOUR_LINODE_SERVER_IP
Proxy: ❌ DNS Only
```

## SSL/TLS Configuration

### Recommended Settings
- **SSL/TLS encryption mode**: Full (strict)
- **Always Use HTTPS**: On
- **HTTP Strict Transport Security (HSTS)**: Enabled
- **Minimum TLS Version**: 1.2
- **Opportunistic Encryption**: On
- **TLS 1.3**: On
- **Automatic HTTPS Rewrites**: On

### Edge Certificates
- **Universal SSL**: Active (free)
- **Certificate Validity**: Let Cloudflare manage
- **Certificate Transparency Monitoring**: On

## Speed Optimization

### Caching Rules
```
Rule 1: Cache Static Assets
- If: File extension is in {css, js, jpg, jpeg, png, gif, ico, svg, woff, woff2, ttf, eot}
- Then: Cache Level = Cache Everything, Edge Cache TTL = 30 days

Rule 2: Cache API Responses (if applicable)
- If: URI Path starts with "/api/"
- Then: Cache Level = Cache Everything, Edge Cache TTL = 5 minutes

Rule 3: Bypass Cache for Admin/Employee Areas
- If: URI Path starts with "/admin/" OR "/employee/"
- Then: Cache Level = Bypass
```

### Speed Settings
- **Auto Minify**: 
  - CSS: ✅ On
  - JavaScript: ✅ On
  - HTML: ✅ On
- **Brotli**: ✅ On
- **Early Hints**: ✅ On
- **Rocket Loader**: ❌ Off (can cause issues with Laravel)
- **Mirage**: ✅ On
- **Polish**: ✅ On (Lossy for faster loading)

## Security Configuration

### Firewall Rules
```
Rule 1: Block Non-Business Hours Access (Optional)
- If: (Time of day not in 08:00-18:00) AND (Country not in [Your Country])
- Then: Block

Rule 2: Rate Limiting for Login Pages
- If: URI Path is "/admin/login" OR "/employee/login"
- Then: Rate Limit = 5 requests per minute per IP

Rule 3: Allow Specific Countries Only (Optional)
- If: Country not in [Your Allowed Countries]
- Then: Challenge (Managed Challenge)

Rule 4: Block Known Bad Bots
- If: Known Bots
- Then: Block
```

### Security Settings
- **Security Level**: Medium
- **Bot Fight Mode**: ✅ On
- **Challenge Passage**: 30 minutes
- **Browser Integrity Check**: ✅ On
- **Privacy Pass Support**: ✅ On

### DDoS Protection
- **DDoS Protection**: Enabled (automatic)
- **Rate Limiting**: Configure based on your needs
- **Zone Lockdown** (if needed for admin areas)

## Page Rules (Legacy - use Rules instead)

If you prefer Page Rules over the new Rules system:

```
1. Force HTTPS
   - URL: http://*yourdomain.com/*
   - Settings: Always Use HTTPS

2. Cache Admin/Employee Pages
   - URL: yourdomain.com/admin/*
   - Settings: Cache Level = Bypass

3. Cache Static Assets
   - URL: yourdomain.com/build/*
   - Settings: Cache Level = Cache Everything, Edge Cache TTL = 30 days
```

## Performance Monitoring

### Analytics to Track
- **Page Load Times**
- **Bandwidth Usage**
- **Cache Hit Ratio**
- **Security Events**
- **Error Rates (4xx, 5xx)**

### Alerts to Set Up
- **Origin Server Down**
- **High Error Rate**
- **DDoS Attack**
- **SSL Certificate Expiry**

## Custom Error Pages

### 503 Service Unavailable
Create a maintenance page for deployments:
```html
<!DOCTYPE html>
<html>
<head>
    <title>System Maintenance</title>
    <style>
        body { font-family: Arial; text-align: center; padding: 50px; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>System Maintenance</h1>
    <p>Our HRMS system is currently being updated.</p>
    <p>We'll be back online shortly.</p>
</body>
</html>
```

## Load Balancing (For High Traffic)

If you need to scale to multiple servers:

### Load Balancer Setup
1. **Create multiple Linode servers**
2. **Set up Load Balancer in Cloudflare**:
   - **Pool Name**: HRMS-Production
   - **Origins**: 
     - Server 1: IP_ADDRESS_1
     - Server 2: IP_ADDRESS_2
   - **Health Checks**: /health (create this endpoint)

### Health Check Endpoint
Add to your Laravel routes:
```php
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected'
    ]);
});
```

## Mobile Optimization

### Mobile-Specific Rules
```
Rule: Mobile Optimization
- If: Device Type is Mobile
- Then: Polish = Lossy, Image Resizing = On
```

### Progressive Web App (PWA) Support
Configure caching for PWA manifest:
```
Rule: PWA Assets
- If: File extension is "webmanifest" OR "json"
- Then: Cache Level = Cache Everything, Edge Cache TTL = 24 hours
```

## Development vs Production

### Development Environment
- **Development Mode**: On
- **Always Use HTTPS**: Off (for local testing)
- **Minification**: Off
- **Caching**: Minimal

### Production Environment
- **Development Mode**: Off
- **Always Use HTTPS**: On
- **Minification**: On
- **Caching**: Aggressive
- **Security**: Maximum

## Troubleshooting Common Issues

### SSL Issues
1. **Check SSL Mode**: Should be "Full (strict)"
2. **Verify Origin Certificate**: Ensure Let's Encrypt is working
3. **Check Mixed Content**: All resources should use HTTPS

### Caching Issues
1. **Purge Cache**: Use "Purge Everything" for immediate updates
2. **Check Cache Rules**: Ensure admin areas are bypassed
3. **Disable Rocket Loader**: If JavaScript isn't working

### Performance Issues
1. **Check Cache Hit Ratio**: Should be >80%
2. **Optimize Images**: Use Polish and Mirage
3. **Enable Brotli**: For better compression
4. **Check Origin Response Times**: May need server optimization

### Security Issues
1. **Review Firewall Events**: Check blocked requests
2. **Adjust Security Level**: Lower if legitimate users are blocked
3. **Whitelist IPs**: For admin users if needed

## Cost Optimization

### Free Tier Limits
- **Bandwidth**: Unlimited
- **DNS Queries**: Unlimited
- **SSL Certificates**: 1 Universal SSL
- **Page Rules**: 3 rules
- **Firewall Rules**: 5 rules

### Pro Tier Benefits ($20/month)
- **Image Optimization**: Polish, Mirage
- **Mobile Optimization**: Automatic
- **Priority Support**: Faster response
- **Advanced Analytics**: Detailed insights
- **Page Rules**: 20 rules

### When to Upgrade
- **High Traffic**: >100K requests/month
- **Multiple Organizations**: Need more Page Rules
- **Advanced Security**: Need more Firewall Rules
- **Image Heavy**: Benefit from image optimization

---

## 📋 Cloudflare Setup Checklist

### Initial Setup
- [ ] Domain added to Cloudflare
- [ ] Nameservers updated
- [ ] DNS records configured
- [ ] SSL/TLS set to "Full (strict)"
- [ ] Always Use HTTPS enabled

### Security Configuration
- [ ] Firewall rules configured
- [ ] Bot Fight Mode enabled
- [ ] Rate limiting set up for login pages
- [ ] Security level set to Medium

### Performance Optimization
- [ ] Auto Minify enabled
- [ ] Brotli compression enabled
- [ ] Caching rules configured
- [ ] Static asset caching optimized

### Monitoring Setup
- [ ] Analytics enabled
- [ ] Alerts configured
- [ ] Error tracking set up
- [ ] Performance monitoring active

---

This configuration will provide enterprise-level performance, security, and reliability for your HRMS deployment!
