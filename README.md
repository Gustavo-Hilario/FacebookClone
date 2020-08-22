<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## Project setup

`````
Make sure that you have installed:
    1- PHP 7
    2- Composer (Dependency Manager for PHP)
    3- A database of your choice
`````

- composer install
- npm install
- copy .env.example to .env in the root folder and set your:
    - DB_DATABASE, APP_NAME, APP_URL
- php artisan key:generate 
    - to generate a APP_KEY in .env
- composer require laravel/passport
- php artisan migrate
- php artisan passport:install
- Go to storage/app/public and add two folders: user-images and post-images 
    - user-images must have the 
default images to user => cover-default-image && profile-default-image
- php artisan storage:link

- Ps: This project works making api request to our back-end, make sure your working URL does not have a port like (:8000)
