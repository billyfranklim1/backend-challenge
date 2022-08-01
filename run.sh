#chmod +x ./run.sh

docker-compose up -d
docker-compose exec app php composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan test

echo "Access the app at http://127.0.0.1::8080"
