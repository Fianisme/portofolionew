# 📱 Deploy Laravel ke Android (Termux)

## Prerequisites di HP Android

```bash
# Install Termux dari F-Droid (bukan Play Store)
# https://f-droid.org/en/packages/com.termux/

# Update packages
pkg update && pkg upgrade -y

# Install PHP & extensions
pkg install php php-apache php-sqlite php-mbstring php-xml php-curl php-zip php-gd

# Install Composer
pkg install composer

# Install Node.js (opsional, untuk build assets)
pkg install nodejs

# Install git
pkg install git

# Install unzip
pkg install unzip
```

## Cara Deploy

### Method 1: Clone dari Git

```bash
# Clone repository
cd ~
git clone https://github.com/YOUR_USERNAME/riotporto.git
cd riotporto

# Run deployment script
chmod +x deploy.sh
./deploy.sh

# Start server
php artisan serve --host=0.0.0.0 --port=8000
```

### Method 2: Transfer File dari PC

```bash
# Di PC, buat archive (tanpa node_modules & vendor)
cd /path/to/riotporto
tar -czf riotporto.tar.gz --exclude='node_modules' --exclude='vendor' --exclude='.git' .

# Transfer ke HP via:
# - ADB: adb push riotporto.tar.gz /data/data/com.termux/files/home/
# - SCP: scp riotporto.tar.gz phone_ip:~/
# - Share via app (Termux + Termux:API)

# Di Termux
cd ~
mkdir riotporto && cd riotporto
tar -xzf ~/riotporto.tar.gz

# Install dependencies
composer install --optimize-autoloader --no-dev

# Copy .env
cp .env.production .env

# Generate key
php artisan key:generate

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link
php artisan storage:link

# Start server
php artisan serve --host=0.0.0.0 --port=8000
```

## Akses dari Device Lain

### 1. Cek IP HP
```bash
# Di Termux
ifconfig | grep "inet "
# atau
ip addr show wlan0
```

### 2. Akses dari Browser
```
http://192.168.x.x:8000        # Akses lokal
http://192.168.x.x:8000/admin  # Admin panel
```

### 3. Pastikan Firewall tidak block
- Settings → WiFi → Advanced → AP Isolation → OFF
- Atau gunakan mobile hotspot

## Auto-Start saat Boot (opsional)

### Install Termux:Boot
```bash
# Install dari F-Droid
# https://f-droid.org/en/packages/com.termux.boot/
```

### Create boot script
```bash
mkdir -p ~/.termux/boot
cat > ~/.termux/boot/start-portfolio.sh << 'EOF'
#!/data/data/com.termux/files/usr/bin/sh
termux-wake-lock
cd ~/riotporto
php artisan serve --host=0.0.0.0 --port=8000
EOF

chmod +x ~/.termux/boot/start-portfolio.sh
```

## Troubleshooting

### Port 8000 sudah dipakai
```bash
php artisan serve --host=0.0.0.0 --port=8080
```

### Permission error
```bash
chmod -R 755 storage bootstrap/cache
```

### SQLite error
```bash
# Pastikan php-sqlite terinstall
pkg install php-sqlite
```

### Composer memory limit
```bash
php -d memory_limit=-1 $(which composer) install
```

### Cek log error
```bash
tail -f storage/logs/laravel.log
```

## Update Project

```bash
cd ~/riotporto

# Pull update
git pull

# Update dependencies
composer install --optimize-autoloader --no-dev

# Clear & rebuild cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart server (jika pakai screen/tmux)
# Ctrl+C lalu jalankan lagi
php artisan serve --host=0.0.0.0 --port=8000
```

## Tips

1. **Gunakan screen/tmux** agar server tetap jalan setelah tutup Termux:
   ```bash
   pkg install tmux
   tmux new -s portfolio
   php artisan serve --host=0.0.0.0 --port=8000
   # Tekan Ctrl+B, lalu D untuk detach
   # tmux attach -t portfolio untuk kembali
   ```

2. **Monitor resource**:
   ```bash
   pkg install htop
   htop
   ```

3. **Cek koneksi**:
   ```bash
   curl http://localhost:8000
   ```
