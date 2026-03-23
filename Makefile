.PHONY: help setup start stop status frontend-lint frontend-format api-lint api-format api-check lint format all

# Variables
COMPOSE_CMD = docker compose
FRONTEND_SVC = app-frontend
BACKEND_SVC = app-backend

help: ## Show this help message
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

## Docker Operations
start: ## Start all services in the background
	$(COMPOSE_CMD) up -d

stop: ## Stop all services
	$(COMPOSE_CMD) stop

down: ## Stop and remove containers, networks, and images
	$(COMPOSE_CMD) down

rebuild: ## Rebuild and restart all containers
	$(COMPOSE_CMD) down
	$(COMPOSE_CMD) up -d --build

status: ## Show the status of the containers
	$(COMPOSE_CMD) ps

logs: ## Show logs from all containers
	$(COMPOSE_CMD) logs -f

## Frontend Commands
frontend-lint: ## Run ESLint on the frontend
	$(COMPOSE_CMD) run --rm $(FRONTEND_SVC) npm run lint

frontend-format: ## Run Prettier on the frontend
	$(COMPOSE_CMD) run --rm $(FRONTEND_SVC) npm run format

## API (Backend) Commands
api-lint: ## Run Laravel Pint to check style issues
	$(COMPOSE_CMD) run --rm $(BACKEND_SVC) vendor/bin/pint --test

api-format: ## Run Laravel Pint to automatically fix style issues
	$(COMPOSE_CMD) run --rm $(BACKEND_SVC) vendor/bin/pint

api-check: ## Run static analysis (Larastan) to find bugs
	$(COMPOSE_CMD) run --rm $(BACKEND_SVC) vendor/bin/phpstan analyze

## Combined Commands
lint: frontend-lint api-lint ## Run all linting checks (frontend & api)

format: frontend-format api-format ## Run all formatters (frontend & api)

check: api-check ## Run all static analysis checks

all: lint check ## Run all checks (linting and static analysis)
