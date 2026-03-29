<#
  deploy.ps1 — Push local changes to Hostinger production
  
  Usage:
    .\deploy\deploy.ps1              # git push only
    .\deploy\deploy.ps1 -SSH         # git push + SSH to pull & migrate
    .\deploy\deploy.ps1 -Message "fixed login bug" -SSH
#>

param(
    [switch]$SSH,
    [string]$Message = ""
)

$projectRoot = Split-Path $PSScriptRoot -Parent

# ── Phase 1: Git commit & push ────────────────────────────────────────────
Write-Host ""
Write-Host "  [1/3] Committing & pushing to GitHub..." -ForegroundColor Cyan

Set-Location $projectRoot

& git add -A

$timestamp = Get-Date -Format "yyyy-MM-dd HH:mm"
$commitMsg = if ($Message -ne "") { $Message } else { "deploy: $timestamp" }

& git commit -m "$commitMsg"
& git push origin main

Write-Host "  Pushed to GitHub." -ForegroundColor Green

if (-not $SSH) {
    Write-Host ""
    Write-Host "  Tip: run with -SSH to also update the server." -ForegroundColor DarkGray
    Write-Host ""
    exit 0
}

# ── Phase 2: SSH into server & pull ───────────────────────────────────────
Write-Host ""
Write-Host "  [2/3] SSHing into Hostinger to pull updates..." -ForegroundColor Cyan

$sshUser = "u512491826"
$sshHost = "ssh.beauvia.in"

$remoteCmd = @"
cd ~/beauvia && \
git pull origin main && \
composer install --no-dev --optimize-autoloader --no-interaction && \
php artisan migrate --force && \
php artisan config:cache && \
php artisan route:cache && \
php artisan view:cache && \
echo '--- Syncing public assets ---' && \
cp -r public/build/ ~/public_html/build/ 2>/dev/null; \
cp public/.htaccess ~/public_html/.htaccess 2>/dev/null; \
cp public/favicon.ico ~/public_html/favicon.ico 2>/dev/null; \
cp public/robots.txt ~/public_html/robots.txt 2>/dev/null; \
echo 'DEPLOY COMPLETE'
"@

& ssh "${sshUser}@${sshHost}" $remoteCmd

Write-Host ""
Write-Host "  [3/3] Deploy complete! Check https://beauvia.in" -ForegroundColor Green
Write-Host ""
