{{-- PROJECT SETUP --}}
    {{-- SETUP BACK-END--}}
        {{-- 1 Install Xampp/PHP - Composer - Node.js/npm - laravel --}}
        {{-- 2 laravel new ProjectName --}}
        {{-- 3 Set Up database configuration at .ENV file --}}
        {{-- 4 php artisan migrate to migrate our Database --}}
        {{-- 5 Install Passport to make authentication process --}}
            {{-- composer require laravel/passport --}}
            {{-- It will create auth tables in our database, so run again php artisan migrate --}}
        {{-- 6 Run php artisan passport:install --}}
            {{-- It will create our very first client (personal access and password grant client) --}}
            {{-- We will use passoword grant client because this work with processes of auth - SEARCH MORE ABOUT IT--}}
        {{-- 7 Now we have to bring this logic and settings for our User in User model--}}
            {{-- In our User class set it to use HasApiTokens --}}
            {{-- Passport use special routes to make athentications. Go to AuthServiceProvider --}}
                {{-- In the function boot() after registerPolicies import that routes --}}
            {{-- Now we have to say to Laravel that we are gonna use Passport as our auth driver. Go to config-> auth.php--}}
                {{-- Change api->driver->passport --}}
                'guards' => [
                'web' => [
                'driver' => 'session',
                'provider' => 'users',
                ],

                'api' => [
                'driver' => 'passport',
                'provider' => 'users',
                'hash' => false,
                ],
                ],
            {{-- Add passport middleware (Http\Kernel.php file) to consume passport API --}}
            {{-- add \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class in the middlewareGroups and 'web'--}}
    {{-- SET UP FRONT-END --}}
        {{-- 1 Installing Laravel UI -> package --}}
            {{-- composer require laravel/ui --}}
        {{-- 2 php artisan preset vue --}}
            {{-- Add/require Vue to our resources/js/app.js --}}
 {{--IMPORTANT NOTE: WHEN WE MAKE CHANGES IN OUR resources/js/app.js or resources/css/app.css we have to run:--}}
 {{-- npm run dev or to maintain it consistent npm run watch--}}
        {{-- 3 Scaffolding basic loguin and registration views --}}
            {{-- php artisan ui:auth -> scafolding some files --}}
                {{-- This also put the div.app in our app.blade that is necessary to run VUE COMPONENTS --}}
            {{-- npm install to pull and javaScript libraries that we have required --}}
            {{-- npm run watch to compile all changes --}}
        {{-- 4 Create a controller to handle our web front-end --}}
            {{-- php artisan make:controller AppController. A controller redirect our routes to the correct place.
             So we have to procted this process with authorization --}}
            public
            {{-- Go to web.php and make the config for our home Route. You can see comments there--}}
        {{-- 5 Add Vue Components --}}
        {{-- 6 Using Vue Router --}}
            <!-- npm i vue-router --save-dev. SEARCH -->
            <!-- In resources/js we create a router for handle all our Vue Routers -->
        {{-- 7 --}}
        {{-- 7 --}}
        {{-- 7 --}}

