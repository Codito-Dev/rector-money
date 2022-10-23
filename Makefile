.DEFAULT_GOAL := help

help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

run: check-command ## Runs specified command on PHP container (starts it automatically)
	docker-compose run php $(cmd)

qa: sa rector phpunit ## Runs QA suite
sa: cs arkitect phpstan ## Runs static analysis
fix: rector-fix ## Applies automatic fixes

arkitect: ## Checks architectural consistency
	docker-compose run php composer arkitect
cs: ## Checks coding standards
	docker-compose run php composer cs:check
cs-fix: ## Fixes coding standards violations
	docker-compose run php composer cs:fix
phpstan: ## Runs PHPStan analysis
	docker-compose run php composer phpstan
phpunit: ## Runs unit tests
	docker-compose run php composer phpunit
rector: ## Runs Rector analysis
	docker-compose run php composer rector:check
rector-fix: ## Runs Rector analysis
	docker-compose run php composer rector:fix

check-command:
ifndef cmd
	$(error Command not specified, please add script argument like: cmd="composer install")
endif
