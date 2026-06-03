#!/bin/bash

# Quick start script
echo "🚀 Starting FYANZ XDEV Portfolio..."

# Get local IP
LOCAL_IP=$(ip addr show wlan0 2>/dev/null | grep "inet " | awk '{print $2}' | cut -d/ -f1)
if [ -z "$LOCAL_IP" ]; then
    LOCAL_IP=$(ifconfig 2>/dev/null | grep "inet " | grep -v "127.0.0.1" | awk '{print $2}' | head -1)
fi

echo ""
echo "🌐 Local:   http://localhost:8000"
if [ -n "$LOCAL_IP" ]; then
    echo "📱 Network: http://${LOCAL_IP}:8000"
fi
echo "🔧 Admin:   http://localhost:8000/admin"
echo ""
echo "Press Ctrl+C to stop"
echo ""

php artisan serve --host=0.0.0.0 --port=8000
