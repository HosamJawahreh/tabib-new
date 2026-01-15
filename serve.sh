#!/bin/bash

# Laravel Development Server with Fixed Asset Loading
# This script properly serves Laravel with all assets loading correctly

cd "$(dirname "$0")"

# Kill any existing PHP servers first
pkill -9 php 2>/dev/null || true
sleep 1

# Start PHP server with explicit server.php router (ensures assets load correctly)
# -t public: Sets public as document root
# server.php: Router file that handles both Laravel routes AND static assets
php -S 127.0.0.1:8000 -t public server.php# Laravel Development Server with Fixed Asset Loading
# This script properly serves Laravel with all assets loading correctly

cd "$(dirname "$0")"

# Kill any existing PHP servers first
pkill -9 php 2>/dev/null || true
sleep 1

# Use Laravel's artisan serve command (automatically handles assets correctly)
php artisan serve --host=127.0.0.1 --port=8000

