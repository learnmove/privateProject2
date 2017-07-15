<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Entities\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Entities\Product::class,function(Faker\Generator $faker){
    return[
        'user_id'=>mt_rand(1,50),
        'name'=>$faker->word,
        'price'=>$faker->numberBetween(100,500),
        'description'=>$faker->paragraph,
        'img'=>$faker->imageUrl($width=640,$height=640),
        'qty'=>$faker->numberBetween(0,3)
    ];
});
