#!/bin/bash

# ===========================================
# DEPLOYMENT SCRIPT FOR ANDROID (Termux)
# ===========================================

echo "🚀 Starting deployment..."

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Check if running in Termux
if [ -d "/data/data/com.termux" ]; then
    echo -e "${YELLOW}📱 Detected Termux environment${NC}"
    IS_TERMUX=true
else
    echo -e "${YELLOW}💻 Detected standard Linux environment${NC}"
    IS_TERMUX=false
fi

# Step 1: Copy production env
echo -e "\n${YELLOW}Step 1: Setting up environment...${NC}"
if [ -f ".env.production" ]; then
    cp .env.production .env
    echo -e "${GREEN}✅ Production .env configured${NC}"
else
    echo -e "${RED}❌ .env.production not found!${NC}"
    exit 1
fi

# Step 2: Install dependencies
echo -e "\n${YELLOW}Step 2: Installing dependencies...${NC}"
if [ "$IS_TERMUX" = true ]; then
    # Termux might need different approach
    composer install --optimize-autoloader --no-dev --no-interaction 2>/dev/null || {
        echo -e "${YELLOW}⚠️  Composer install failed, trying alternative...${NC}"
        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
        php composer-setup.php
        php -r "unlink('composer-setup.php');"
        php composer.phar install --optimize-autoloader --no-dev
    }
else
    composer install --optimize-autoloader --no-dev --no-interaction
fi
echo -e "${GREEN}✅ Dependencies installed${NC}"

# Step 3: Generate key if needed
echo -e "\n${YELLOW}Step 3: Checking application key...${NC}"
php artisan key:generate --force 2>/dev/null
echo -e "${GREEN}✅ Application key set${NC}"

# Step 4: Build assets (if node available)
echo -e "\n${YELLOW}Step 4: Building assets...${NC}"
if command -v npm &> /dev/null; then
    npm ci --production=false 2>/dev/null || npm install
    npm run build
    echo -e "${GREEN}✅ Assets built${NC}"
else
    echo -e "${YELLOW}⚠️  npm not found, using pre-built assets${NC}"
    # Make sure build directory exists
    if [ ! -d "public/build" ]; then
        echo -e "${RED}❌ No pre-built assets found!${NC}"
        echo -e "${YELLOW}Run 'npm run build' on your dev machine first${NC}"
    fi
fi

# Step 5: Cache everything
echo -e "\n${YELLOW}Step 5: Caching for production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✅ Caching complete${NC}"

# Step 6: Set permissions
echo -e "\n${YELLOW}Step 6: Setting permissions...${NC}"
chmod -R 755 storage 2>/dev/null
chmod -R 755 bootstrap/cache 2>/dev/null
echo -e "${GREEN}✅ Permissions set${NC}"

# Step 7: Storage link
echo -e "\n${YELLOW}Step 7: Creating storage link...${NC}"
php artisan storage:link --force 2>/dev/null
echo -e "${GREEN}✅ Storage linked${NC}"

# Step 8: Create content directory if not exists
echo -e "\n${YELLOW}Step 8: Setting up content directory...${NC}"
mkdir -p storage/app/content
mkdir -p storage/app/public/uploads
echo -e "${GREEN}✅ Content directories ready${NC}"

echo -e "\n${GREEN}========================================${NC}"
echo -e "${GREEN}✅ DEPLOYMENT COMPLETE!${NC}"
echo -e "${GREEN}========================================${NC}"
echo -e "\n📱 To start the server:"
echo -e "   ${YELLOW}php artisan serve --host=0.0.0.0 --port=8000${NC}"
echo -e "\n🌐 Access from other devices:"
echo -e "   ${YELLOW}http://YOUR_IP:8000${NC}"
echo -e "\n🔧 Admin panel:"
echo -e "   ${YELLOW}http://YOUR_IP:8000/admin${NC}"
echo -e "\n⚠️  ${RED}IMPORTANT: Change default admin password!${NC}"
echo -e "   ${YELLOW}php artisan admin:password${NC}"
echo -e "\n📋 Default login:"
echo -e "   Username: ${YELLOW}admin${NC}"
echo -e "   Password: ${YELLOW}password${NC}"
