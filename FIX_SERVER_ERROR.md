# Fix 500 Error on Production Server

## What Was Wrong
The models were missing new database columns in their `$fillable` arrays. This caused mass assignment errors when trying to update records.

## Fixed Files (Already in Git)
- `app/Models/Shop.php` - Added `approval_status`, `rejection_reason`
- `app/Models/FreelancerProfile.php` - Added `approval_status`, `rejection_reason`  
- `app/Models/Review.php` - Added `is_flagged`
- `app/Models/User.php` - Added `is_suspended`, `suspended_at`

## Run These Commands on Server

```bash
# 1. Pull latest code
git pull origin main

# 2. Clear ALL caches (CRITICAL!)
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 3. Verify migrations ran
php artisan migrate:status

# 4. If migrations pending, run them
php artisan migrate --force

# 5. Restart PHP-FPM
sudo systemctl restart php8.3-fpm

# 6. Restart web server
sudo systemctl restart nginx
```

## Test Login
- URL: `https://beauvia.in/login`
- Email: `admin@beauvia.com`
- Password: `password`

Should redirect to `/admin/dashboard`

## Still Getting Error?

Check logs:
```bash
tail -50 storage/logs/laravel.log
```

The error message will tell you exactly what's wrong.
