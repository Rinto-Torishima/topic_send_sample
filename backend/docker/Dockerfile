FROM php:8.2-fpm

WORKDIR /var/www/html

# PHP拡張
RUN docker-php-ext-install pdo pdo_mysql

# 必要なツールをインストール（git, unzip, zip）
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 先に composer.json / composer.lock をコピーして依存関係をインストール
COPY backend/composer.json backend/composer.lock ./
RUN composer install

# 🔥 アプリ全体（config, public, .env など）を最後にコピー
COPY backend /var/www/html

CMD ["php-fpm"]
