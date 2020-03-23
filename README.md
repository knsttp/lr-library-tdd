## Setup

### Dependencies

* [PHP 7.2](http://php.net/) - popular general-purpose scripting language suited to web development
* [Laravel 7](https://laravel.com/docs/5.8) - A web application framework built with PHP

### Getting Started

Setting up project in development mode

* Ensure PHP 7.2 is installed by running:
```
php -v
```

* Clone the repository to your machine and navigate into it:
```
git clone https://github.com/knsttp/lr-library-tdd.git && cd lr-library-tdd
```
* Install application dependencies:
```
composer install
```
* Update a *.env* file and include the necessary environment variables.

## Database setup
Create your database locally on your machine, i.e `lr-library-tdd`cand add it as a value to the respective environment variable as below.
```
DB_DATABASE=lr-library-tdd
```
- Also create a sqlite file for testing by running this command on your project root
```
touch database/database.sqlite
```

## Running the application
Inside the project root folder, run the command below in your console
```
$ php artisan migrate:fresh --seed
```
```
$ php artisan serve
```
##### You can now log in via the following credentials
```
Admin - email: admin@example.com | password: secret
```
```
User - email: user@example.com | password: secret
```

### Unit && Feature tests
```
- $ ./vendor/bin/phpunit
```

- Pardon on the UI. The focus of this is on me learning Testing and TDD in Laravel.