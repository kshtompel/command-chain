#!/bin/sh

# Configure server enviroment
echo "cd /var/www/command-chain" >> /home/vagrant/.bashrc

# Update composer
/usr/local/bin/composer selfupdate

# Configure system
cd /var/www/command-chain
/usr/local/bin/composer install --no-interaction
