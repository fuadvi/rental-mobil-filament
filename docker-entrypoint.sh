#!/bin/bash

# Enable debug mode
set -x

# Check Caddy binary
echo "Caddy binary path: $(which caddy)"
/usr/local/bin/caddy version

# Wait for PostgreSQL to be ready
echo "Waiting for database..."
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  echo "Waiting for database..."
  sleep 2
done

echo "Database is ready!"

# Run migrations
php artisan migrate
php artisan storage:link
php artisan optimize:clear

# Start Caddy server
echo "Starting Caddy server..."
/usr/local/bin/caddy run --config /etc/caddy/Caddyfile --adapter caddyfile & CADDY_PID=$!
#
#echo "Caddy server started..."

#caddy fmt --overwrite ./Caddyfile

# Start Octane workers
php artisan octane:frankenphp --workers

# Wait for Caddy process
wait $CADDY_PID
