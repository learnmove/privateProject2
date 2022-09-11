<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShipType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cht_name');
            $table->tinyInteger('is_enable');
            $table->timestamps();
        });
        DB::table('ship_type')->insert([
            ['id' => '1', 'name'=>'familymart','cht_name'=>'全家', 'is_enable' => '0'] ,
            ['id' => '2', 'name'=>'seveneleven','cht_name'=>'711', 'is_enable' => '0'] ,
            ['id' => '3', 'name'=>'shopee','cht_name'=>'蝦皮', 'is_enable' => '0'] ,
            ['id' => '4', 'name'=>'face_pay','cht_name'=>'面交', 'is_enable' => '1'] ,
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ship_type');
        
        //
    }
}
