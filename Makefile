SHELL  := /bin/bash

init: up
restart: kill up status
status: ps compose-logs
kill:
	docker-compose kill && docker-compose rm -vf
up:
	docker-compose up -d --remove-orphans
ps:
	docker-compose ps
compose-logs:
	docker-compose logs --tail=100;
compose-logs-follow:
	docker-compose logs --tail=100 -f
logs:
	tail -f ./docker/var/log/*/* -f
pull:
	docker-compose pull
build:
	docker-compose build --no-cache --parallel
nginx-reload:
	docker-compose exec nginx bash -c 'nginx -t && nginx -s reload'

php-bash:
	docker-compose exec php bash
supervisor-cli:
	docker-compose exec php supervisorctl
redis-cli:
	docker-compose exec redis redis-cli
redis-monitor:
	docker-compose exec redis redis-cli monitor

mysql-cli:
	docker exec -it `docker-compose ps -q mysql` bash -c 'export MYSQL_PWD=$$MYSQL_ROOT_PASSWORD; mysql -uroot'
mysql-dump:
	docker exec -i `docker-compose ps -q mysql` bash -c 'export MYSQL_PWD=$$MYSQL_ROOT_PASSWORD; mysqldump --force --opt --comments=false --quote-names --single_transaction --routines --events -uroot -h mysql $$MYSQL_DATABASE' | gzip -c > dump.sql.gz
mysql-import:
	gzip -dc dump.sql.gz | docker exec -i `docker-compose ps -q mysql` bash -c 'export MYSQL_PWD=$$MYSQL_ROOT_PASSWORD; mysql -uroot -h mysql $$MYSQL_DATABASE'
mysql-monitor:
	docker-compose exec mysql bash -c 'export TERM=xterm; export MYSQL_PWD=$$MYSQL_ROOT_PASSWORD; watch "mysql -uroot -e \"show processlist\" 2>/dev/null"'
mysql-tuner:
	docker-compose exec mysql bash -c 'cd /opt; \
      if [ ! -x ./mysqltuner.pl ]; then \
        if [ ! -x /usr/bin/wget ]; then apt update && apt install -y wget; fi; \
        wget "https://raw.githubusercontent.com/major/MySQLTuner-perl/master/mysqltuner.pl" -O mysqltuner.pl; \
      fi; \
      chmod +x mysqltuner.pl && ./mysqltuner.pl --pass="$$MYSQL_ROOT_PASSWORD" --user=root;'
mysql-delete-data:
	rm -rv ./docker/var/lib/mysql/*

composer-init:
	docker-compose exec php bash -c "cd /var/www/; composer install -vvv; chown -R www-data:www-data ./vendor/"
composer-up:
	docker-compose exec php bash -c "cd /var/www/; rm -rvf ./vendor/*; composer install --no-dev -vvv; chown -R www-data:www-data ./vendor/"
composer-dump:
	docker-compose exec php bash -c "cd /var/www/; composer dumpautoload"
composer-update-packages:
	docker-compose exec php bash -c "cd /var/www/; composer update;"

artisan-init:
	docker-compose exec php bash -c "cd /var/www/; php artisan key:generate; php artisan config:cache;"
artisan-migrate:
	docker-compose exec php bash -c "cd /var/www/; php artisan migrate --force"
artisan-tinker:
	docker-compose exec php bash -c "cd /var/www/; php artisan tinker"
artisan-clear-cache:
	docker-compose exec php bash -c "cd /var/www/; php artisan config:cache; php artisan config:clear; php artisan cache:clear; php artisan view:clear"
artisan-opt:
	docker-compose exec php bash -c "cd /var/www/; php artisan optimize"
artisan-serve:
	docker-compose exec php bash -c "cd /var/www/; php artisan serve"
artisan-seed:
	docker-compose exec php bash -c "cd /var/www/; php artisan migrate:refresh --seed"

laravel-init: composer-init artisan-init artisan-seed
