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
        'account'=>$faker->username,
        'email' => $faker->unique()->safeEmail,
        'school_id'=>$faker->numberBetween(1,370),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Entities\Product::class,function(Faker\Generator $faker){
    return[
        'user_id'=>mt_rand(1,50),
        'school_id'=>mt_rand(1,370),
        'name'=>$faker->word,
        'price'=>$faker->numberBetween(100,500),
        'description'=>$faker->paragraph,
        'img'=>$faker->imageUrl($width=640,$height=640),
        'qty'=>$faker->numberBetween(0,3)
    ];
});
$factory->define(App\Entities\Invoice::class,function(Faker\Generator $faker){
  return [
      'user_id'=>mt_rand(1,50),
       'total_price'=>mt_rand(1000,5000),
       'total_qty'=>mt_rand(5,10)
  ]  ;
});
$factory->define(App\Entities\InvoiceItem::class,function(Faker\Generator $faker){
  return [
     'product_id'=>mt_rand(1,50),
     'item_total_price'=>mt_rand(100,500),
     'item_total_qty'=>mt_rand(1,2)
  ]  ;
});
$factory->define(App\Entities\ProductQuestion::class,function(Faker\Generator $faker){
    return [
     'account'=>$faker->username,
     'content'=>$faker->sentence
  ]  ;
});