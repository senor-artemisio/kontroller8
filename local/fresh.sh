#!/usr/bin/env bash

#!/usr/bin/env bash
cd laradock

docker-compose exec workspace php artisan storage:link
docker-compose exec workspace mv storage/app/public/.gitignore ./.gitignore.storage
docker-compose exec workspace rm -rf storage/app/public/*
docker-compose exec workspace mv ./.gitignore.storage storage/app/public/.gitignore

docker-compose exec mysql mysql -h 127.0.0.1 -uroot -proot -e "DROP DATABASE IF EXISTS \`default\`";
docker-compose exec mysql mysql -h 127.0.0.1 -uroot -proot -e "CREATE DATABASE IF NOT EXISTS \`default\` COLLATE 'utf8_general_ci';";

docker-compose exec mysql mysql -h 127.0.0.1 -uroot -proot -e "DROP DATABASE IF EXISTS \`test\`";
docker-compose exec mysql mysql -h 127.0.0.1 -uroot -proot -e "CREATE DATABASE IF NOT EXISTS \`test\` COLLATE 'utf8_general_ci';";

docker-compose exec workspace php artisan migrate
docker-compose exec workspace php artisan db:seed
docker-compose exec workspace php artisan passport:client --personal --name=web