<?php

use Illuminate\Database\Seeder;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Entities\Invoice::class,100)->create()->each(
            function($i){

                $i->items()->save(factory(App\Entities\InvoiceItem::class)->make());


            }
        );
    }
}
