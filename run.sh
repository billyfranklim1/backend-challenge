#chmod +x ./run.sh

docker-compose up -d


docker-compose exec --user=root app chmod -R 777 /var/www/
docker-compose exec app composer install
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed

echo "Access the app at http://127.0.0.1:8080"
