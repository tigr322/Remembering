# Базовый PHP-FPM
FROM php:8.3-fpm-alpine

# Установим расширения, часто нужные в веб-проектах
RUN set -eux; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev libzip-dev oniguruma-dev; \
    apk add --no-cache icu-libs libzip oniguruma bash shadow; \
    docker-php-ext-install -j$(nproc) intl mbstring pdo pdo_mysql zip opcache; \
    # (опционально) xdebug для локальной отладки
    # pecl install xdebug && docker-php-ext-enable xdebug; \
    apk del .build-deps

# Composer (multi-stage copy из официального образа)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория внутри контейнера
WORKDIR /var/www/html

# Оптимальный php.ini (минимум)
RUN { \
      echo "display_errors=On"; \
      echo "memory_limit=512M"; \
      echo "upload_max_filesize=50M"; \
      echo "post_max_size=50M"; \
      echo "date.timezone=UTC"; \
      echo "opcache.enable=1"; \
      echo "opcache.validate_timestamps=1"; \
    } > /usr/local/etc/php/conf.d/custom.ini

# Пользователь www-data (иногда помогает на Windows с правами)
RUN usermod -u 1000 www-data || true

# Если есть composer.json — можно автоматически подтягивать зависимости при сборке:
# COPY composer.json composer.lock ./
# RUN composer install --no-interaction --prefer-dist --no-dev || true

# Ничего не копируем на сборке — монтируем код в docker-compose через volume.
