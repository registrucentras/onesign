install:
	@docker run -it -w /data -v ${PWD}:/data:delegated -v ~/.composer:/root/.composer:delegated --entrypoint composer --rm ghcr.io/benycode/php:7.4-base update
	@docker run -it -w /data -v ${PWD}:/data:delegated -v ~/.composer:/root/.composer:delegated --entrypoint composer --rm ghcr.io/benycode/php:7.4-base bin all update

phpunit:
	@docker run -it -w /data -v ${PWD}:/data:delegated --entrypoint vendor/bin/phpunit --rm ghcr.io/benycode/php:7.4-cli

phpstan-analyze:
	@docker run -it -w /data -v ${PWD}:/data:delegated --entrypoint vendor/bin/phpstan --rm ghcr.io/benycode/php:7.4-cli analyze

phpstan-baseline:
	@docker run -it -w /data -v ${PWD}:/data:delegated --entrypoint vendor/bin/phpstan --rm ghcr.io/benycode/php:7.4-cli analyze --generate-baseline

psalm-analyze:
	@docker run -it -w /data -v ${PWD}:/data:delegated --entrypoint vendor/bin/psalm.phar --rm ghcr.io/benycode/php:7.4-cli

psalm-baseline:
	@docker run -it -w /data -v ${PWD}:/data:delegated --entrypoint vendor/bin/psalm.phar --rm ghcr.io/benycode/php:7.4-cli --set-baseline=psalm-baseline.xml
	
phpcs:
	@docker run -it -w /data -v ${PWD}:/data:delegated --entrypoint vendor/bin/phpcs --rm ghcr.io/benycode/php:7.4-cli

phpcbf:
	@docker run -it -w /data -v ${PWD}:/data:delegated --entrypoint vendor/bin/phpcbf --rm ghcr.io/benycode/php:7.4-cli

psalm-show-info:
	@docker run -it -w /data -v ${PWD}:/data:delegated --entrypoint vendor/bin/psalm.phar --rm ghcr.io/benycode/php:7.4-cli --show-info=true

fix: phpcbf

test: phpunit phpstan-analyze psalm-analyze phpcbf phpcs

clean:
	@rm -rf .phpunit.result.cache composer.lock vendor vendor-bin/*/composer.lock vendor-bin/*/vendor
