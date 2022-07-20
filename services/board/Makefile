test-pipeline:
	@make -s test-cs
	@make -s test-mutation

test-cs:
	#composer exec phpcs -- -sp --colors --standard=config/phpcs.xml
	composer exec deptrac -- analyze --config-file=config/deptrac.yaml --cache-file=$$CACHE_TEST_DIR/deptrac.cache

test-unit:
	@make -s run-phpunit testsuite=Unit

test-coverage:
	@make -s run-phpunit coverage=y

test-mutation:
	composer exec infection -- run -s -c config/infection.json

run-phpunit: options = -c config/phpunit.xml
run-phpunit: options += --cache-result-file $$CACHE_TEST_DIR/phpunit.cache
run-phpunit: options += $(if ${filter},--filter=${filter})
run-phpunit: options += $(if ${testsuite},--testsuite ${testsuite})
run-phpunit: options += $(if ${coverage},--coverage-html $$REPORTS_DIR/coverage)
run-phpunit:
	composer exec phpunit -- ${options}
