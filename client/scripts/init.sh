#!/bin/sh

cd /var/www/html

set -e

echo "🔍 Check if node_modules exists..."

if [ ! -d "node_modules" ]; then
  echo "📦 node_modules not found. Installing dependencies..."
  npm ci
else
  echo "✅ node_modules already exists. Skipping..."
fi

echo "🚀 Starting Next.js server..."
exec npm run dev