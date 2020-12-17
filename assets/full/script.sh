#!/usr/bin/bash
sudo brotli --quality=9 full.css
sudo brotli --quality=9 full.js
chown -R stas:stas ./