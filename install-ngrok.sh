#!/bin/bash

echo "📦 Installing ngrok for Termux..."

# Detect architecture
ARCH=$(uname -m)
echo "Detected architecture: $ARCH"

if [ "$ARCH" = "aarch64" ]; then
    NGROK_URL="https://bin.equinox.io/c/bNyj1mQVY4c/ngrok-v3-stable-linux-arm64.tgz"
elif [ "$ARCH" = "armv7l" ] || [ "$ARCH" = "armv8l" ]; then
    NGROK_URL="https://bin.equinox.io/c/bNyj1mQVY4c/ngrok-v3-stable-linux-arm.tgz"
else
    NGROK_URL="https://bin.equinox.io/c/bNyj1mQVY4c/ngrok-v3-stable-linux-arm64.tgz"
fi

echo "Downloading from: $NGROK_URL"

# Download
cd /tmp
wget "$NGROK_URL" -O ngrok.tgz

if [ $? -ne 0 ]; then
    echo "❌ Download failed. Trying alternative URL..."
    wget "https://bin.equinox.io/c/bNyj1mQVY4c/ngrok-v3-stable-linux-arm.tgz" -O ngrok.tgz
fi

# Extract
tar -xzf ngrok.tgz

# Move to bin
chmod +x ngrok
mv ngrok $PREFIX/bin/

# Cleanup
rm -f ngrok.tgz

# Verify
echo ""
if command -v ngrok &> /dev/null; then
    echo "✅ ngrok installed successfully!"
    ngrok version
else
    echo "❌ Installation failed"
fi
