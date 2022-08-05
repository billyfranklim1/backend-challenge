# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git clone https://github.com/billyfranklim1/backend-challenge.git

Switch to the repo folder

    cd backend-challenge


Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

## Environment variables

Configure the database environment variables

    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=backend-challenge
    DB_USERNAME=root
    DB_PASSWORD=root

Configure the email environment variables so that sending email works correctly

    MAIL_DRIVER=
    MAIL_HOST=
    MAIL_PORT=
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=
    MAIL_FROM_ADDRESS=
    MAIL_FROM_NAME=

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Run the database seeder and you're done

    php artisan db:seed

## Start the local development server

    php artisan serve

You can now access the server at http://127.0.0.1:8000

**TL;DR command list**

    git clone https://github.com/billyfranklim1/backend-challenge.git
    cd backend-challenge
    cp .env.example .env
    php artisan migrate
    php artisan db:seed
    php artisan serve


***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    
## Docker

To install with [Docker](https://www.docker.com), run following commands:

```
git clone https://github.com/billyfranklim1/backend-challenge.git
cd backend-challenge
cp .env.example .env
docker-compose up -d
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec --user=root app chmod -R 777 /var/www/
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

The api can be accessed at [http://127.0.0.1:8080/api](http://127.0.0.1:8000/api).

# Testing API

Run the laravel development server

    docker-compose exec app php artisan test

The api can now be accessed at

    http://127.0.0.1:8080/api
