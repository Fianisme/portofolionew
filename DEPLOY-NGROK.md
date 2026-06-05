# 🌐 Setup ngrok di Termux

## Cara Install

```bash
# Download ngrok untuk ARM (Android)
curl -sSL https://ngrok-agent.s3.amazonaws.com/ngrok-v3-stable-linux-arm64.tgz | tar -xzf - -C $PREFIX/bin

# Atau pakai cara ini jika curl gagal
wget https://ngrok-agent.s3.amazonaws.com/ngrok-v3-stable-linux-arm64.tgz
tar -xzf ngrok-v3-stable-linux-arm64.tgz -C $PREFIX/bin
rm ngrok-v3-stable-linux-arm64.tgz
```

## Setup

```bash
# 1. Daftar di https://ngrok.com (gratis)
# 2. Copy authtoken dari dashboard ngrok
# 3. Jalankan:
ngrok config add-authtoken YOUR_TOKEN_HERE
```

## Pakai

```bash
# Terminal 1: Start Laravel
cd ~/web/portofolio/portofolionew
./start.sh

# Terminal 2: Start ngrok
ngrok http 8000
```

## Hasil

```
Session Status    online
Account           your-email (Plan: Free)
Forwarding        https://xxxx-xx-xx.ngrok-free.app -> http://localhost:8000
```

Portfolio bisa diakses dari mana saja pakai URL tersebut!

## Troubleshooting

### Command not found
```bash
# Cek lokasi ngrok
which ngrok

# Jika tidak ada, tambah ke PATH
export PATH=$PATH:$HOME/.ngrok
```

### Permission denied
```bash
chmod +x $PREFIX/bin/ngrok
```

### Tunnel error
```bash
# Pastikan Laravel server jalan dulu
curl http://localhost:8000
```
