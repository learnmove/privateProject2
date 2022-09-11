<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Entities\User;
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

        User::create([
        'name' => '林宥璇',
        'account'=> 'a',
        'email' => 'a12345626@gmail.com',
        'avatar'=> 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/%E4%B8%AD%E8%8F%AF%E6%B0%91%E5%9C%8B%E7%AC%AC12%E3%80%8113%E4%BB%BB%E7%B8%BD%E7%B5%B1%E9%A6%AC%E8%8B%B1%E4%B9%9D%E5%85%88%E7%94%9F%E5%AE%98%E6%96%B9%E8%82%96%E5%83%8F%E7%85%A7.jpg/250px-%E4%B8%AD%E8%8F%AF%E6%B0%91%E5%9C%8B%E7%AC%AC12%E3%80%8113%E4%BB%BB%E7%B8%BD%E7%B5%B1%E9%A6%AC%E8%8B%B1%E4%B9%9D%E5%85%88%E7%94%9F%E5%AE%98%E6%96%B9%E8%82%96%E5%83%8F%E7%85%A7.jpg',
        'school_id'=>3,
        'password' => bcrypt('789789'),
        'remember_token' => str_random(10),
        'wallet' => 100,
        'is_enable' => 1,
        'phone' => '0922582625',
        'shop_name' => '鋪',
        'shop_description' => '',
        
    ]);
        User::create([
            'name' => '蔡英文',
            'account'=> 'b',
            'email' => 'b45626@gmail.com',
            'avatar'=> 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/%E8%94%A1%E8%8B%B1%E6%96%87%E5%AE%98%E6%96%B9%E5%85%83%E9%A6%96%E8%82%96%E5%83%8F%E7%85%A7.png/250px-%E8%94%A1%E8%8B%B1%E6%96%87%E5%AE%98%E6%96%B9%E5%85%83%E9%A6%96%E8%82%96%E5%83%8F%E7%85%A7.png',
            'school_id'=>3,
            'password' => bcrypt('789789'),
            'remember_token' => str_random(10),
            'wallet' => 100,
            'is_enable' => 1,
            'phone' => '0922582625',
            'shop_name' => '鋪',
            'shop_description' => '',

        ]);

    }
}
