# 🚀 Deployment Guide - KidsLearn Laravel

Panduan lengkap untuk deploy aplikasi KidsLearn ke production server.

---

## 📋 Daftar Isi

1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Production Environment Setup](#production-environment-setup)
3. [Server Requirements](#server-requirements)
4. [Deployment Steps](#deployment-steps)
5. [Post-Deployment](#post-deployment)
6. [Rollback Procedure](#rollback-procedure)
7. [Maintenance](#maintenance)

---

## 1. Pre-Deployment Checklist

### ✅ Code Review

-   [ ] All features tested locally
-   [ ] No debug code or console.logs
-   [ ] All dependencies up to date
-   [ ] Code follows PSR standards
-   [ ] No sensitive data in code

### ✅ Configuration

-   [ ] .env.example updated
-   [ ] APP_DEBUG=false
-   [ ] APP_ENV=production
-   [ ] Secure APP_KEY generated
-   [ ] Database credentials ready
-   [ ] Mail configuration ready
-   [ ] Queue driver configured

### ✅ Assets

-   [ ] All images optimized
-   [ ] All sounds compressed
-   [ ] npm run build executed
-   [ ] Assets uploaded to CDN (optional)

### ✅ Security

-   [ ] SSL certificate ready
-   [ ] Firewall configured
-   [ ] Strong database password
-   [ ] Rate limiting configured
-   [ ] Security headers configured

---

## 2. Production Environment Setup

### Option 1: Shared Hosting (cPanel)

#### Requirements:

-   PHP 8.2+
-   MySQL 5.7+
-   Composer
-   SSH access (recommended)

#### Steps:

1. **Upload Files via FTP/SFTP**

    ```
    Upload all files except:
    - .git/
    - node_modules/
    - tests/
    - .env
    ```

2. **Create Database**

    - Login to cPanel
    - MySQL Databases → Create Database
    - Create user and assign to database

3. **Configure .env**

    - Copy .env.example to .env
    - Update production settings

4. **Run Setup Commands** (via SSH)

    ```bash
    composer install --optimize-autoloader --no-dev
    php artisan key:generate
    php artisan migrate --force
    php artisan db:seed
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

5. **Set Document Root**
    - Point to `/public` folder

---

### Option 2: VPS (Ubuntu/Debian)

#### Initial Server Setup

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Nginx
sudo apt install nginx -y

# Install PHP 8.2 and extensions
sudo apt install php8.2-fpm php8.2-mysql php8.2-mbstring \
php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath -y

# Install MySQL
sudo apt install mysql-server -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs -y
```

#### Configure Nginx

Create file: `/etc/nginx/sites-available/kidslearn`

```nginx
server {
    listen 80;
    server_name kidslearn.com www.kidslearn.com;
    root /var/www/kidslearn/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/kidslearn /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

### Option 3: Docker

Create `Dockerfile`:

```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
```

Create `docker-compose.yml`:

```yaml
version: "3.8"

services:
    app:
        build:
            context: .
            dockerfile: Dockerfile
        container_name: kidslearn-app
        restart: unless-stopped
        working_dir: /var/www
        volumes:
            - ./:/var/www
        networks:
            - kidslearn

    nginx:
        image: nginx:alpine
        container_name: kidslearn-nginx
        restart: unless-stopped
        ports:
            - "80:80"
            - "443:443"
        volumes:
            - ./:/var/www
            - ./docker/nginx:/etc/nginx/conf.d
        networks:
            - kidslearn

    db:
        image: mysql:8.0
        container_name: kidslearn-db
        restart: unless-stopped
        environment:
            MYSQL_DATABASE: kidslearn
            MYSQL_ROOT_PASSWORD: secret
            MYSQL_PASSWORD: secret
            MYSQL_USER: kidslearn
        volumes:
            - dbdata:/var/lib/mysql
        networks:
            - kidslearn

networks:
    kidslearn:
        driver: bridge

volumes:
    dbdata:
        driver: local
```

Run:

```bash
docker-compose up -d
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed
```

---

## 3. Server Requirements

### Minimum Requirements:

-   **CPU:** 1 Core
-   **RAM:** 512 MB (1 GB recommended)
-   **Storage:** 5 GB
-   **Bandwidth:** 10 GB/month

### Recommended for 1000+ users:

-   **CPU:** 2+ Cores
-   **RAM:** 2 GB+
-   **Storage:** 20 GB SSD
-   **Bandwidth:** 100 GB/month

### Software Requirements:

-   **PHP:** 8.2 or higher
-   **Web Server:** Nginx or Apache
-   **Database:** MySQL 5.7+ or PostgreSQL 10+
-   **Composer:** Latest version
-   **Node.js:** 18.x or higher (for assets)

### PHP Extensions Required:

-   OpenSSL
-   PDO
-   Mbstring
-   Tokenizer
-   XML
-   Ctype
-   JSON
-   BCMath
-   Fileinfo
-   GD

---

## 4. Deployment Steps

### Step 1: Clone Repository

```bash
cd /var/www
git clone https://github.com/your-repo/kidslearn.git
cd kidslearn
```

### Step 2: Install Dependencies

```bash
# PHP dependencies
composer install --optimize-autoloader --no-dev

# Node dependencies (if needed)
npm install
npm run build
```

### Step 3: Environment Configuration

```bash
# Copy and edit .env
cp .env.example .env
nano .env
```

Update `.env`:

```env
APP_NAME=KidsLearn
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://kidslearn.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kidslearn_prod
DB_USERNAME=kidslearn_user
DB_PASSWORD=your_secure_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password

SESSION_DRIVER=database
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Setup Database

```bash
# Create database
mysql -u root -p
CREATE DATABASE kidslearn_prod;
CREATE USER 'kidslearn_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON kidslearn_prod.* TO 'kidslearn_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Run migrations
php artisan migrate --force

# Run seeders (optional for production)
php artisan db:seed
```

### Step 6: Set Permissions

```bash
# Set correct ownership
sudo chown -R www-data:www-data /var/www/kidslearn

# Set correct permissions
sudo chmod -R 755 /var/www/kidslearn
sudo chmod -R 775 /var/www/kidslearn/storage
sudo chmod -R 775 /var/www/kidslearn/bootstrap/cache
```

### Step 7: Optimize Application

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

### Step 8: Setup SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Get certificate
sudo certbot --nginx -d kidslearn.com -d www.kidslearn.com

# Auto-renewal (cron job already created by certbot)
sudo certbot renew --dry-run
```

### Step 9: Setup Firewall

```bash
# Enable UFW
sudo ufw enable

# Allow SSH
sudo ufw allow 22

# Allow HTTP & HTTPS
sudo ufw allow 80
sudo ufw allow 443

# Check status
sudo ufw status
```

### Step 10: Setup Process Manager (Optional)

For queue workers:

```bash
# Install Supervisor
sudo apt install supervisor -y

# Create config
sudo nano /etc/supervisor/conf.d/kidslearn-worker.conf
```

Add:

```ini
[program:kidslearn-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/kidslearn/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/kidslearn/storage/logs/worker.log
```

Start:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start kidslearn-worker:*
```

---

## 5. Post-Deployment

### Verify Deployment

```bash
# Check PHP version
php -v

# Check Laravel version
php artisan --version

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check permissions
ls -la storage/
ls -la bootstrap/cache/

# Check Nginx status
sudo systemctl status nginx

# Check PHP-FPM status
sudo systemctl status php8.2-fpm
```

### Test Application

1. ✅ Open website in browser
2. ✅ Test register functionality
3. ✅ Test login functionality
4. ✅ Test all learning modules
5. ✅ Test quiz functionality
6. ✅ Test logout
7. ✅ Check console for errors
8. ✅ Test on mobile devices

### Setup Monitoring

**1. Log Monitoring:**

```bash
# Watch Laravel logs
tail -f storage/logs/laravel.log

# Watch Nginx error logs
sudo tail -f /var/log/nginx/error.log
```

**2. Uptime Monitoring:**

-   Use services like UptimeRobot
-   Or self-host with Uptime Kuma

**3. Performance Monitoring:**

-   Setup New Relic or Datadog
-   Monitor database queries
-   Monitor server resources

### Setup Backup

**Database Backup (Cron Job):**

```bash
# Create backup script
sudo nano /usr/local/bin/backup-kidslearn.sh
```

Add:

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/kidslearn"
DB_NAME="kidslearn_prod"
DB_USER="kidslearn_user"
DB_PASS="your_secure_password"

mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_$DATE.sql

# Backup files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/kidslearn

# Keep only last 7 days
find $BACKUP_DIR -type f -mtime +7 -delete

echo "Backup completed: $DATE"
```

Make executable and schedule:

```bash
sudo chmod +x /usr/local/bin/backup-kidslearn.sh
sudo crontab -e
```

Add:

```
0 2 * * * /usr/local/bin/backup-kidslearn.sh >> /var/log/kidslearn-backup.log 2>&1
```

---

## 6. Rollback Procedure

### Quick Rollback

```bash
# Go to project directory
cd /var/www/kidslearn

# Stash current changes
git stash

# Checkout previous version
git checkout previous-tag-or-commit

# Install dependencies
composer install --optimize-autoloader --no-dev

# Clear and cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
sudo systemctl reload nginx
sudo systemctl reload php8.2-fpm
```

### Database Rollback

```bash
# Rollback last migration
php artisan migrate:rollback

# Rollback specific steps
php artisan migrate:rollback --step=5

# Restore from backup
mysql -u kidslearn_user -p kidslearn_prod < /var/backups/kidslearn/db_YYYYMMDD.sql
```

---

## 7. Maintenance

### Regular Tasks

**Daily:**

-   [ ] Check error logs
-   [ ] Monitor disk space
-   [ ] Check application uptime

**Weekly:**

-   [ ] Review performance metrics
-   [ ] Update dependencies (test first)
-   [ ] Check backups
-   [ ] Review security alerts

**Monthly:**

-   [ ] Server updates
-   [ ] SSL certificate renewal (auto)
-   [ ] Database optimization
-   [ ] Performance audit

### Update Application

```bash
cd /var/www/kidslearn

# Pull latest code
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Run migrations
php artisan migrate --force

# Clear cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
sudo systemctl reload nginx
sudo systemctl reload php8.2-fpm
```

### Database Optimization

```bash
# Optimize tables
php artisan db:optimize

# Or manually
mysql -u root -p
USE kidslearn_prod;
OPTIMIZE TABLE users, animals, quiz_questions, user_progress;
```

---

## 🔒 Security Best Practices

1. **Always use HTTPS**
2. **Keep software updated**
3. **Use strong passwords**
4. **Enable firewall**
5. **Regular backups**
6. **Monitor logs**
7. **Limit SSH access**
8. **Use fail2ban**
9. **Disable directory listing**
10. **Set proper file permissions**

---

## 📞 Emergency Contacts

-   **Server Provider Support:** support@hosting.com
-   **Developer:** dev@kidslearn.com
-   **Database Admin:** dba@kidslearn.com

---

## 📊 Deployment Checklist Summary

-   [ ] Code tested locally
-   [ ] Production server ready
-   [ ] Domain configured
-   [ ] SSL certificate installed
-   [ ] Database created
-   [ ] .env configured
-   [ ] Dependencies installed
-   [ ] Migrations run
-   [ ] Permissions set
-   [ ] Application optimized
-   [ ] Firewall configured
-   [ ] Backup system setup
-   [ ] Monitoring setup
-   [ ] Application tested
-   [ ] Documentation updated
-   [ ] Team notified

---

**Deployment Date:** ******\_******

**Deployed by:** ******\_******

**Status:** ⬜ Success ⬜ Failed ⬜ Rolled Back

**Notes:** **********************\_**********************

---

Good luck with your deployment! 🚀
