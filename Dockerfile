# Base stage
FROM dunglas/frankenphp:php8.2-alpine AS base

# Set environment
ENV SERVER_NAME=":80"
ENV FRANKENPHP_CONFIG="worker ./public/frankenphp-worker.php"
ENV APP_ENV=production
ENV APP_DEBUG=false

# Working directory
WORKDIR /app

# Install system dependencies
RUN apk add --no-cache \
    postgresql-client \
    curl \
    ca-certificates \
    bash

# Install PHP extensions
RUN install-php-extensions \
    pdo_pgsql \
    pcntl \
    intl \
    zip \
    exif \
    gd \
    opcache

# Composer stage
FROM composer:2 AS composer

# Production stage
FROM base AS production

# Copy Composer from composer image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy application files
COPY --chown=1000:1000 . /app

# Create non-root user
RUN adduser -D -u 1000 app

# Install Composer dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --optimize-autoloader \
    --no-scripts \
    --no-progress \
    --ignore-platform-req=ext-intl \
    --ignore-platform-req=ext-zip \
    --ignore-platform-req=ext-exif

# Download Caddy
RUN curl -L -o /usr/local/bin/caddy \
    "https://caddyserver.com/api/download?os=linux&arch=amd64" \
    && chmod 755 /usr/local/bin/caddy \
    && /usr/local/bin/caddy version

# Copy Caddyfile and entrypoint
COPY --chown=1000:1000 Caddyfile /etc/caddy/Caddyfile
COPY --chown=1000:1000 docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Set permissions
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Switch to non-root user
USER 1000

# Entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

# Development stage (optional)
FROM production AS development
ENV APP_ENV=local
ENV APP_DEBUG=true
USER root
