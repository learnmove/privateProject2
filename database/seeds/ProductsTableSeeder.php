<?php

use Illuminate\Database\Seeder;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Entities\Product::class,1000)->create()->each(function($p){
            $p->categories()->attach(mt_rand(1,7),['school_id'=>$p->school_id]);
            $q=factory(App\Entities\ProductQuestion::class,2)->make();
            $p->questions()->saveMany($q);
        });

        //
    }
}
