# Beauvia — Local Development Guide

## Prerequisites
- **Laragon** installed at `D:\Softwares\laragon`
- **PHP 8.5.4** selected in Laragon (Menu → PHP → php-8.5.4-Win32-vs17-x64)
- **MySQL** running via Laragon
- **Git** installed

---

## First Time Setup (One-time only)

### Step 1: Clone the project
```bash
cd D:\WORK
git clone https://github.com/hamad-mf/beauvia.git Beauvia
cd Beauvia
```

### Step 2: Install PHP dependencies
```bash
composer install
```

### Step 3: Create local .env file
```bash
copy .env.example .env
```
Then open `.env` and set:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=beauvia
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Generate app key
```bash
php artisan key:generate
```

### Step 5: Create the database
Open Laragon → click **Database** → create a new database called `beauvia`

### Step 6: Run migrations
```bash
php artisan migrate
```

### Step 7: Seed categories
```bash
php artisan db:seed --class=CategorySeeder
```

---

## Run the Project (Every time)

### Step 1: Make sure Laragon is running (Apache + MySQL)

### Step 2: Start Laravel server
```bash
cd D:\WORK\Beauvia
php artisan serve
```

### Step 3: Open browser
Go to: **http://127.0.0.1:8000**

---

## Deploy Changes to Production

### Step 1: Commit your changes
```bash
git add -A
git commit -m "your message here"
git push origin main
```

### Step 2: SSH into server and update
```bash
ssh u512491826@in-mum-web2109.hostinger.com
cd ~/beauvia
git pull
/opt/alt/php84/usr/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader --no-interaction
/opt/alt/php84/usr/bin/php artisan migrate --force
/opt/alt/php84/usr/bin/php artisan config:cache
/opt/alt/php84/usr/bin/php artisan route:cache
/opt/alt/php84/usr/bin/php artisan view:cache
cp -r public/build/ ~/domains/beauvia.in/public_html/build/
```

---

## Important Paths

| What | Local | Production (Hostinger) |
|---|---|---|
| Project | `D:\WORK\Beauvia` | `~/beauvia/` |
| PHP binary | `php` (Laragon) | `/opt/alt/php84/usr/bin/php` |
| Composer | `composer` (Laragon) | `/usr/local/bin/composer` |
| Web root | `http://127.0.0.1:8000` | `https://beauvia.in` |
| Public HTML | — | `~/domains/beauvia.in/public_html/` |
| Database | `beauvia` (local MySQL) | `u512491826_beauvia` (Hostinger MySQL) |

---

## Useful Commands

```bash
# Reset database and re-migrate (WARNING: deletes all data)
php artisan migrate:fresh

# Seed only categories
php artisan db:seed --class=CategorySeeder

# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```
