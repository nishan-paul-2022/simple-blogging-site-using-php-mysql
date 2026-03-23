#!/usr/bin/env bash

set -euo pipefail

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

print_ok() {
	echo -e "${GREEN}[ok]${NC} $1"
}

print_step() {
	echo -e "${YELLOW}[step]${NC} $1"
}

print_err() {
	echo -e "${RED}[error]${NC} $1"
}

upsert_env() {
	local file="$1"
	local key="$2"
	local value="$3"

	if grep -qE "^${key}=" "$file"; then
		sed -i "s|^${key}=.*|${key}=${value}|" "$file"
	else
		echo "${key}=${value}" >> "$file"
	fi
}

if ! command -v docker >/dev/null 2>&1; then
	print_err "Docker is not installed. Install Docker first."
	exit 1
fi

if docker compose version >/dev/null 2>&1; then
	COMPOSE_CMD="docker compose"
elif command -v docker-compose >/dev/null 2>&1; then
	COMPOSE_CMD="docker-compose"
else
	print_err "Docker Compose is not available. Install docker compose plugin or docker-compose."
	exit 1
fi

if ! docker info >/dev/null 2>&1; then
	print_err "Docker daemon is not running. Start Docker and run again."
	exit 1
fi

print_ok "Using compose command: ${COMPOSE_CMD}"

ROOT_DIR="$(cd "$(dirname "$0")" && pwd)"
cd "$ROOT_DIR"

print_step "Preparing environment files"
if [ ! -f api/.env ]; then
	cp api/.env.example api/.env
	print_ok "Created api/.env"
else
	print_ok "api/.env already exists"
fi

upsert_env api/.env APP_NAME '"Blog API"'
upsert_env api/.env APP_ENV local
upsert_env api/.env APP_DEBUG true
upsert_env api/.env APP_URL http://localhost:8000
upsert_env api/.env DB_CONNECTION mysql
upsert_env api/.env DB_HOST database
upsert_env api/.env DB_PORT 3306
upsert_env api/.env DB_DATABASE blog_db
upsert_env api/.env DB_USERNAME blog_user
upsert_env api/.env DB_PASSWORD blog_password
upsert_env api/.env CACHE_DRIVER redis
upsert_env api/.env REDIS_HOST cache
upsert_env api/.env REDIS_PORT 6379
upsert_env api/.env SESSION_DRIVER cookie
upsert_env api/.env SANCTUM_STATEFUL_DOMAINS 'localhost,localhost:3000,127.0.0.1'
upsert_env api/.env VITE_API_BASE_URL http://localhost:8000/api
print_ok "api/.env values are set for Docker runtime"

if [ ! -f frontend/.env.local ]; then
	cp frontend/.env.example frontend/.env.local
	print_ok "Created frontend/.env.local"
else
	print_ok "frontend/.env.local already exists"
fi

upsert_env frontend/.env.local NEXT_PUBLIC_API_URL http://localhost:8000/api
upsert_env frontend/.env.local NEXT_PUBLIC_APP_NAME '"Modern Blog Platform"'
print_ok "frontend/.env.local values are set"

print_step "Building images"
$COMPOSE_CMD build
print_ok "Images built"

print_step "Starting infrastructure services"
$COMPOSE_CMD up -d database cache

print_step "Waiting for MySQL to become healthy"
for i in $(seq 1 30); do
	if $COMPOSE_CMD exec -T database mysqladmin ping -h localhost --silent >/dev/null 2>&1; then
		print_ok "MySQL is ready"
		break
	fi
	if [ "$i" -eq 30 ]; then
		print_err "MySQL did not become ready in time"
		exit 1
	fi
	sleep 2
done

print_step "Starting application services"
$COMPOSE_CMD up -d app-backend app-frontend web-server
print_ok "Services started"

print_step "Installing backend dependencies"
$COMPOSE_CMD exec -T app-backend composer install --no-interaction --prefer-dist

print_step "Generating Laravel app key"
$COMPOSE_CMD exec -T app-backend php artisan key:generate --force

print_step "Running migrations and seeders"
$COMPOSE_CMD exec -T app-backend php artisan migrate --seed --force

print_step "Optimizing Laravel caches"
$COMPOSE_CMD exec -T app-backend php artisan config:clear
$COMPOSE_CMD exec -T app-backend php artisan route:clear

print_ok "Full setup complete"
echo
echo "Frontend: http://localhost:3000"
echo "API:      http://localhost:8000/api"
echo "Nginx:    http://localhost"
echo
echo "Admin user:"
echo "  email:    admin@blog.test"
echo "  password: password"
echo
echo "Useful commands:"
echo "  ${COMPOSE_CMD} logs -f"
echo "  ${COMPOSE_CMD} down"
echo "  ${COMPOSE_CMD} down -v"
