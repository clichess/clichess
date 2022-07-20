#
# Running
build:
	@make docker-compose cmd='build'

up:
	@make docker-compose cmd='up -d -V'

down:
	@make docker-compose cmd='down -v --remove-orphans'

test: level ?= pipeline
test:
	@make docker-run service=board cmd='make test-${level}'

#
# Dev
status:
	@make docker-compose cmd='ps'

logs:
	@make docker-compose cmd='logs -f' $(if ${grep},| grep '${grep}')

sh:
	@make docker-exec cmd='sh'

copy-vendor:
	@make docker-compose cmd='cp board:/var/www/vendor ./dev/vendors/board'

#
## docker
docker-exec: options = $(if ${user},-u${user})
docker-exec:
	@make docker-compose cmd="exec ${options} ${service} ${cmd}"

docker-run:
	@make docker-compose cmd="run --rm ${service} ${cmd}"

docker-compose: composeFiles = -f docker-compose.yaml $(if ${CI},,-f docker-compose.local.yaml)
docker-compose:
	docker compose ${composeFiles} ${cmd}
