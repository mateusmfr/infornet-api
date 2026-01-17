DOCKER_COMPOSE := $(shell docker compose version > /dev/null 2>&1 && echo "docker compose" || echo "docker-compose")

.PHONY: help setup up down restart logs migrate fresh test clean

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'

setup:
	@echo "🧹 Limpando ambiente anterior..."
	@$(DOCKER_COMPOSE) down -v 2>/dev/null || true
	@echo "🚀 Configurando ambiente..."
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
		echo "✅ Arquivo .env criado"; \
	fi
	@echo "📦 Instalando dependências do Composer..."
	@docker run --rm -v $$(pwd):/app -w /app composer:latest install --prefer-dist --no-interaction
	@echo "🐳 Subindo containers..."
	@$(DOCKER_COMPOSE) up -d
	@echo "⏳ Aguardando MySQL inicializar..."
	@until $(DOCKER_COMPOSE) exec -T mysql sh -c 'mysql -uroot -p$$MYSQL_ROOT_PASSWORD -e "SELECT 1"' >/dev/null 2>&1; do \
		printf '.'; \
		sleep 1; \
	done
	@echo ""
	@echo "✅ MySQL pronto!"
	@echo "🔑 Gerando APP_KEY..."
	@$(DOCKER_COMPOSE) exec -T app php artisan key:generate
	@echo "🗄️  Executando migrations..."
	@$(DOCKER_COMPOSE) exec -T app php artisan migrate --force
	@echo "✅ Ambiente configurado! API disponível em http://localhost:8000"

up:
	@echo "🚀 Iniciando containers..."
	@$(DOCKER_COMPOSE) up -d
	@echo "✅ Containers iniciados! API disponível em http://localhost:8000"

down:
	@echo "🛑 Parando containers..."
	@$(DOCKER_COMPOSE) down
	@echo "✅ Containers parados"

restart:
	@make down
	@make up

logs:
	@$(DOCKER_COMPOSE) logs -f

migrate:
	@echo "🗄️  Executando migrations..."
	@$(DOCKER_COMPOSE) exec app php artisan migrate

seed:
	@echo "🌱 Populando banco de dados..."
	@$(DOCKER_COMPOSE) exec app php artisan db:seed
	@echo "✅ Dados inseridos!"

test:
	@echo "🧪 Executando testes..."
	@$(DOCKER_COMPOSE) exec app php artisan test

clean:
	@echo "🧹 Limpando ambiente..."
	@$(DOCKER_COMPOSE) down -v
	@rm -rf vendor/ bootstrap/cache/*.php storage/framework/cache/* storage/framework/sessions/* storage/framework/views/* storage/logs/*
	@echo "✅ Ambiente limpo"
