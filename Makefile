#
# Running
build:
	@make docker-compose cmd='build'

up:
	@make docker-compose cmd='up -d -V'

down:
	@make docker-compose cmd='down -v --remove-orphans'

test:
	@make docker-compose cmd='run --rm board ./vendor/bin/phpunit -c tests/phpunit.xml --testdox '

#
# Dev
status:
	@make docker-compose cmd='ps'

logs:
	@make docker-compose cmd='logs -f' $(if ${grep},| grep '${grep}')

sh:
	@make docker-exec cmd='sh'

copy-vendor:
	@make docker-compose cmd='cp board:/var/www/vendor ./services/board/vendor'

#
## docker
docker-exec: options = $(if ${user},-u${user})
docker-exec:
	@make docker-compose cmd="exec ${options} ${service} ${cmd}"

docker-compose:
	docker compose -f docker-compose.yaml ${cmd}
