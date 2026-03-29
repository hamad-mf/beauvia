#!/bin/bash
# ============================================================
#  Beauvia — First-time server setup on Hostinger
#  Run this via SSH: bash server_setup.sh
# ============================================================

echo ""
echo "=== Beauvia Server Setup ==="
echo ""

# 1. Clone the repo
if [ ! -d "$HOME/beauvia" ]; then
    echo "[1/7] Cloning repository..."
    cd ~
    git clone https://github.com/hamad-mf/beauvia.git beauvia
else
    echo "[1/7] Repository already exists, pulling latest..."
    cd ~/beauvia
    git pull origin main
fi

cd ~/beauvia

# 2. Install Composer dependencies
echo ""
echo "[2/7] Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Copy production .env
echo ""
echo "[3/7] Setting up .env..."
if [ ! -f ".env" ]; then
    cp deploy/.env.production .env
    echo "  Copied .env.production -> .env"
    echo "  !! IMPORTANT: Edit ~/beauvia/.env and set your real DB_PASSWORD !!"
else
    echo "  .env already exists, skipping."
fi

# 4. Generate app key
echo ""
echo "[4/7] Generating application key..."
php artisan key:generate --force

# 5. Run migrations
echo ""
echo "[5/7] Running database migrations..."
php artisan migrate --force

# 6. Cache configs
echo ""
echo "[6/7] Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Set up public_html gateway
echo ""
echo "[7/7] Setting up public_html gateway..."

# Remove default file
rm -f ~/public_html/default.php

# Copy gateway index.php
cp ~/beauvia/deploy/public_html_index.php ~/public_html/index.php

# Copy static assets
cp ~/beauvia/public/.htaccess ~/public_html/.htaccess
cp -r ~/beauvia/public/build/ ~/public_html/build/ 2>/dev/null
cp ~/beauvia/public/favicon.ico ~/public_html/favicon.ico 2>/dev/null
cp ~/beauvia/public/robots.txt ~/public_html/robots.txt 2>/dev/null

# 8. Set permissions
echo ""
echo "Setting permissions..."
chmod -R 775 ~/beauvia/storage
chmod -R 775 ~/beauvia/bootstrap/cache

echo ""
echo "============================================"
echo "  SETUP COMPLETE!"
echo "  Visit: https://beauvia.in"
echo "============================================"
echo ""
echo "  If .env was just created, remember to:"
echo "  nano ~/beauvia/.env"
echo "  Update DB_PASSWORD and then run:"
echo "  cd ~/beauvia && php artisan config:cache"
echo ""
