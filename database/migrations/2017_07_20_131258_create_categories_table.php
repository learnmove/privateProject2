<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        DB::table('categories')
        ->insert([
            ['name'=>'服飾'],
            ['name'=>'雜物'],
            ['name'=>'電子產品'],
            ['name'=>'家用'],
            ['name'=>'小說'],
            ['name'=>'理工書'],
            ['name'=>'文組書'],
            ['name'=>'商管書'],
            ['name'=>'專科書'],
            ['name'=>'樂器'],
            ['name'=>'租屋'],
            ['name'=>'票券'],
            ['name'=>'作業'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
