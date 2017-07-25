<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     protected $faker;
    public function run()
    {
        $faker=Faker::create();
        factory(App\Entities\User::class,50)->create()->each(function($u) use ($faker){
            foreach(range(0,12) as $number ){
            $u->chat_user()->attach(mt_rand(1,50));
            $list=$u->chat_user()->first();
            $u->sender()->attach(mt_rand(1,50),['message'=>$faker->sentence,'channel_id'=> $list->id]);
            }
        });
    }
}
