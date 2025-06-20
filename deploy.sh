#!/bin/bash

# Script de despliegue para Railway

echo "🚀 Iniciando despliegue..."

# Instalar dependencias de PHP
echo "📦 Instalando dependencias de PHP..."
composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node.js
echo "📦 Instalando dependencias de Node.js..."
npm ci

# Compilar assets
echo "🔨 Compilando assets..."
npm run build

# Generar clave de aplicación si no existe
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generando clave de aplicación..."
    php artisan key:generate
fi

# Ejecutar migraciones
echo "🗄️ Ejecutando migraciones..."
php artisan migrate --force

# Cachear configuraciones
echo "⚡ Cacheando configuraciones..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Despliegue completado!" 