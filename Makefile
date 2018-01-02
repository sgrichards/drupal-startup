#####
# Utility commands for Startup.
#####

profile = startup
scope = dev

webexec = docker-compose exec web
webbash = docker-compose exec web bash -c
remotedocroot = /app/docroot
drushcmd = cd $(remotedocroot) && drush -y -v

# This is the default task that is run when just running make.
list:
	@grep '^[^#[:space:]].*:' Makefile


refresh: clear-cache module-sync updatedb clear-cache entity-update

onboard: composer-install

##
# DOCKER COMPOSE SHORTCUTS.
##
composer-install:
	@docker-compose exec web composer install

start:
	@docker-compose up -d

stop:
	@docker-compose stop

down:
	@docker-compose down

build:
	@docker-compose build web

logs:
	-@docker-compose logs --follow

weblog:
	-@docker-compose logs --follow web

shell:
	-@$(webexec) bash

status:
	@docker-compose ps

install:
	@$(webbash) "$(drushcmd) site-install $(profile) --debug --account-pass=t3st3r"

clear-cache:
	@$(webbash) "$(drushcmd) cr"

entity-update:
	@$(webbash) "$(drushcmd) entup"

updatedb:
	@$(webbash) "$(drushcmd) updb"

module-sync:
	@$(webbash) "$(drushcmd) module-sync --scope=$(scope)"

login:
	@$(webbash) "$(drushcmd) user-login --uri=http://127.0.0.1:8080"

##
# GENERAL.
##
.PHONY: phpcs
phpcs:
	@$(webbash) "bin/phpcs"

.PHONY: phpmd
phpmd:
	@$(webbash) "bin/phpmd"

.PHONY: phpspec
phpspec:
	@$(webbash) "bin/phpspec run"

.PHONY: phpunit
phpunit:
	@$(webbash) "bin/phpunit"

.PHONY: behat
behat:
	@$(webbash) "bin/behat"

