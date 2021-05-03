#!/usr/bin/bash
cd ~/www/InvestmentMarketplace/assets/full/
sudo brotli --quality=9 full.css
sudo brotli --quality=9 full.js
sudo gzip -kv9 full.css
sudo gzip -kv9 full.js
chown -R stas:stas ./