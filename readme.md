# Dutch
https://gist.github.com/Allov/c59849077535b061a1edfe490b72de92

## Symfony

symfony console doctrine:database:create

symfony console doctrine:schema:create

symfony serve

docker compose exec php \
    bin/console doctrine:migrations:diff
docker compose exec php \
    bin/console doctrine:migrations:migrate

## Api platform
https://api-platform.com/docs/distribution/#its-ready

php bin/console make:entity

php bin/console make:migration

php bin/console doctrine:migrations:migrate

php bin/console lexik:jwt:generate-keypair