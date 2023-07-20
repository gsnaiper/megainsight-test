#!/bin/bash

# Переходим в директорию с приложением Laravel
cd /var/www/html

cp .env.example .env

# Устанавливаем права на директории
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache


# Установка зависимостей Laravel с использованием Composer
composer install

# Генерация ключа приложения Laravel
php artisan key:generate

# Запуск миграций базы данных
php artisan migrate --seed

# Запуск генерации документации API
php artisan l5-swagger:generate

# Запуск Apache сервера
apache2-foreground
