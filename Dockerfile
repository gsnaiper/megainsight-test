FROM php:8.2-apache

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Установка необходимых пакетов
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копирование исходных файлов Laravel в контейнер
#COPY . /var/www/html

# Установка зависимостей Laravel
#RUN cd /var/www/html && composer install

#RUN cp .env.example .env && \
#    php artisan key:generate && \
#    php artisan migrate --seed

# Настройка прав на папки Laravel (для обеспечения доступа к кэшу и логам)
#RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Копирование файла конфигурации виртуального хоста Apache
COPY apache_vh.conf /etc/apache2/sites-available/laravel.conf

# Включение виртуального хоста
RUN a2ensite laravel.conf

# Отключение дефолтного сайта Apache
RUN a2dissite 000-default

# Включение модуля Apache mod_rewrite
RUN a2enmod rewrite

# Перезапуск Apache для применения изменений
RUN service apache2 restart

# Копирование скрипта entrypoint.sh и делаем его исполняемым
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Открытие порта Apache
EXPOSE 80

# Указываем entrypoint скрипт как точку входа в контейнер
ENTRYPOINT ["entrypoint.sh"]
