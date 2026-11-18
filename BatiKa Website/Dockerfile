# syntax=docker/dockerfile:1

# ---------------------------------------------------------------------------
# BatiKa — Laravel container image for Vercel Functions (Container runtime)
# ---------------------------------------------------------------------------
# Stages:
#   assets       -> builds the Vite frontend bundle (public/build)
#   dependencies -> installs production Composer packages
#   runtime      -> FrankenPHP image that actually serves the application
# ---------------------------------------------------------------------------

FROM dunglas/frankenphp:1-php8.3-bookworm AS base

# PHP extensions required by Laravel and this application:
#   pdo_mysql -> MySQL connection
#   intl, zip -> Laravel framework requirements
#   gd        -> image handling
#   bcmath    -> numeric helpers used by payment libraries
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && install-php-extensions \
        bcmath \
        gd \
        intl \
        opcache \
        pdo_mysql \
        zip

# Uploads are forwarded to Firebase Storage. Keep PHP limits aligned with the
# request size that Vercel Functions accept (the platform caps bodies at ~4.5MB).
RUN printf '%s\n' \
        'memory_limit = 256M' \
        'upload_max_filesize = 4M' \
        'post_max_size = 8M' \
        > "$PHP_INI_DIR/conf.d/zz-batika.ini"

WORKDIR /app

# ---------------------------------------------------------------------------
# 1. Frontend assets (Vite + Bootstrap + Alpine + GSAP)
# ---------------------------------------------------------------------------
FROM node:22-bookworm-slim AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build

# ---------------------------------------------------------------------------
# 2. PHP dependencies
# ---------------------------------------------------------------------------
FROM base AS dependencies

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --no-scripts \
        --optimize-autoloader \
        --prefer-dist

COPY . .
COPY --from=assets /app/public/build ./public/build

RUN mkdir -p \
        bootstrap/cache \
        storage/app/public \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
    && composer dump-autoload --no-dev --classmap-authoritative \
    && php artisan view:cache

# ---------------------------------------------------------------------------
# 3. Runtime (FrankenPHP + Caddy)
# ---------------------------------------------------------------------------
FROM base AS runtime

COPY --from=dependencies --chown=www-data:www-data /app /app
COPY --chown=www-data:www-data Caddyfile /etc/frankenphp/Caddyfile

RUN setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp \
    && chown -R www-data:www-data /config/caddy /data/caddy

ENV PORT=80 \
    APP_ENV=production \
    APP_DEBUG=false \
    APP_MAINTENANCE_DRIVER=file \
    LOG_CHANNEL=stderr \
    CACHE_STORE=database \
    SESSION_DRIVER=database \
    QUEUE_CONNECTION=sync \
    FILESYSTEM_DISK=public

USER www-data

EXPOSE 80

CMD ["frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile"]
