<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reservation;
use App\User;
use App\Book;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
    return [
        'book_id' => factory(Book::class)->create()->id,
        'user_id' => factory(User::class)->create(['password' => bcrypt('secret')])->id,
    ];
});
