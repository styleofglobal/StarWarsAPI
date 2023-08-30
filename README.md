<p align="center"><a href="#" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## HOWTO, Details are as follows:

1. Open CMD run <code>git clone https://github.com/styleofglobal/TMDb-API-in-Laravel-8</code>
2. cd TMDb-API-in-Laravel-8
3. Run the command <code>composer install</code>
4. After successful completing the step 3, create a database "lv8tmdbapi" and update mysql connection details in ".env" file.
5. Run the command <code>php artisan migrate:fresh --seed</code> & <code>php artisan serv</code> to run the application as php development server.
6. Login from the web is required to fetch movies data from TMDB, default login details are: email: styleofglobal1@gmail.com & password: 123456.
7. Run this command if data is not showing after first login from the web <code>php artisan cache:clear</code>. 

## Test-Driven Development (TDD) approach
Run the command <code>php artisan test</code>
Warning: TTY mode is not supported on Windows platform.

    $ PASS  Tests\Unit\ExampleTest
    $ ✓ basic test
    $ 
    $ PASS  AuthenticationTest
    $ ✓ login screen can be rendered
    $ ✓ users can authenticate using the login screen
    $ ✓ users can not authenticate with invalid password
    $ 
    $ PASS  Tests\Feature\MovieControllerTest
    $ ✓ fetching movie details from t m d b
    $ ✓ listing movies
    $ ✓ create movies
    $ ✓ updating movie
    $ ✓ deleting movie
    $ ✓ fetching movie details
    $ 
    $ PASS  RegistrationTest
    $ ✓ registration screen can be rendered
    $ ✓ new users can register
    $ 
    $ Tests:  12 passed
    $ Time:   7.93s
    $ 

### For URI/API List please check file API Details.xlsx.
### For Postman API export file please check file smallworldfs.postman_collection.json.
