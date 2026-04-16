# Admin Panel Deployment Guide

## Beauvia Production Deployment Steps

### Local Machine (Windows)

1. Make your changes
2. Run `npm run build`
3. Push to GitHub:
   ```bash
   git add .
   git commit -m "commit message"
   git push
   ```

### Production Server

1. SSH into server:
   ```powershell
   ssh u512491826@145.79.212.105 -p 65002
   # Password: @Beauviassh123
   ```

2. Navigate to project:
   ```bash
   cd beauvia
   ```

3. Pull latest code:
   ```bash
   git pull
   ```

4. Copy build files to live server:
   ```bash
   cp -r ~/beauvia/public/build/* ~/domains/beauvia.in/public_html/build/
   ```

5. Clear Laravel caches:
   ```bash
   php artisan view:clear
   php artisan config:clear
   php artisan cache:clear
   ```

## First-Time Admin Panel Setup (One-Time Only)

After deploying the admin panel code for the first time, run these additional steps:

### 1. Run Database Migrations
```bash
php artisan migrate
```

This will create all the necessary database tables and columns:
- Add `admin` role to users table
- Add `approval_status` columns to shops and freelancer_profiles tables
- Create `settings`, `announcements`, and `admin_activity_logs` tables
- Add `is_flagged` to reviews table
- Add `sort_order` to categories table

### 2. Create Admin User
```bash
php artisan db:seed --class=AdminUserSeeder
```

This creates the admin user with:
- Email: `admin@beauvia.com`
- Password: `password`

**IMPORTANT FOR PRODUCTION**: After first login, immediately:
1. Go to admin user management
2. Change the admin email to your real email
3. Change the password to a strong password

Or manually create admin user via tinker:
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Your Name',
    'email' => 'your-email@example.com',
    'password' => Hash::make('your-secure-password'),
    'role' => 'admin',
    'phone' => '+1234567890',
    'email_verified_at' => now(),
]);
```

### 3. Clear Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 4. Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Set Proper Permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. Test Admin Login
1. Go to `https://your-domain.com/login`
2. Login with admin credentials
3. You should be redirected to `/admin/dashboard`

## Verification Checklist

After deployment, verify:

- [ ] Migrations ran successfully (check database tables)
- [ ] Admin user exists in database
- [ ] Can login with admin credentials
- [ ] Redirected to admin dashboard after login
- [ ] All admin routes accessible (users, shops, freelancers, etc.)
- [ ] Non-admin users get 403 error on admin routes
- [ ] Admin panel matches purple theme
- [ ] All metrics display correctly on dashboard

## Troubleshooting

### Issue: "Unable to locate a class or view for component [layouts.admin]"
**Solution**: Make sure the file exists at `resources/views/components/layouts/admin.blade.php` (not in `resources/views/layouts/`)

### Issue: "Nothing to migrate"
**Solution**: Migrations already ran. Check if columns exist:
```bash
php artisan tinker
```
```php
Schema::hasColumn('shops', 'approval_status')
Schema::hasColumn('users', 'is_suspended')
```

### Issue: "Admin user already exists"
**Solution**: User already created. Login with existing credentials or reset password:
```bash
php artisan tinker
```
```php
$user = User::where('email', 'admin@beauvia.com')->first();
$user->password = Hash::make('new-password');
$user->save();
```

### Issue: 403 Forbidden on admin routes
**Solution**: Check user role:
```bash
php artisan tinker
```
```php
$user = User::where('email', 'admin@beauvia.com')->first();
$user->role; // Should be 'admin'
```

### Issue: Pending shops/freelancers count shows 0
**Solution**: This is normal if no shops/freelancers have registered yet. The approval workflow will work when providers register.

## Security Notes for Production

1. **Change default admin credentials immediately**
2. **Use strong passwords** (minimum 12 characters, mixed case, numbers, symbols)
3. **Enable HTTPS** for all admin routes
4. **Set up proper firewall rules**
5. **Enable rate limiting** on admin routes (already configured in middleware)
6. **Monitor admin activity logs** regularly
7. **Keep Laravel and dependencies updated**
8. **Set `APP_DEBUG=false`** in production `.env`
9. **Use environment-specific email settings**
10. **Backup database regularly** (especially admin_activity_logs)

## Email Configuration

For email notifications to work, configure in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Optional: CSV Export

If you want CSV export functionality:
```bash
composer require league/csv
```

Note: This requires PHP 8.4+. If you have PHP 8.3, skip this or use an alternative package.

## Quick Deployment Script

Create a file `deploy-admin.sh`:
```bash
#!/bin/bash

echo "🚀 Deploying Admin Panel..."

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Seed admin user (will fail if exists, that's ok)
php artisan db:seed --class=AdminUserSeeder || true

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 775 storage bootstrap/cache

echo "✅ Admin Panel deployed successfully!"
echo "📧 Login at: https://your-domain.com/login"
echo "👤 Email: admin@beauvia.com"
echo "🔑 Password: password"
echo ""
echo "⚠️  IMPORTANT: Change admin credentials immediately!"
```

Make it executable:
```bash
chmod +x deploy-admin.sh
```

Run it:
```bash
./deploy-admin.sh
```

## Support

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check web server logs (nginx/apache)
3. Verify database connection in `.env`
4. Ensure all migrations ran: `php artisan migrate:status`
5. Check file permissions on storage and bootstrap/cache

---

**Last Updated**: Admin Panel v1.0
**Laravel Version**: 11.x
**PHP Version**: 8.3+
