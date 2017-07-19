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
        factory(App\Entities\Product::class,100)->create()->each(function($p){
            $q=factory(App\Entities\ProductQuestion::class,20)->make();
            $p->questions()->saveMany($q );
        });

        //
    }
}
