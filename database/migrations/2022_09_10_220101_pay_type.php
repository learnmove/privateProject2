<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PayType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cht_name');
            $table->tinyInteger('is_enable');
            $table->timestamps();
        });
        DB::table('pay_type')->insert([
            ['id' => '1', 'name'=>'point','cht_name'=>'點數', 'is_enable' => 1],
            ['id' => '2', 'name'=>'bank','cht_name'=>'銀行轉帳', 'is_enable' => 0],
            ['id' => '3', 'name'=>'arrived_pay','cht_name'=>'貨到付款', 'is_enable' => 0],
            ['id' => '4', 'name'=>'cash','cht_name'=>'現金', 'is_enable' => 1],
            ['id' => '5', 'name'=>'visa','cht_name'=>'信用卡/金融卡', 'is_enable' => 0],
            ['id' => '6', 'name'=>'pay','cht_name'=>'電子支付', 'is_enable' => 0],
            ['id' => '7', 'name'=>'stuff','cht_name'=>'以物易物', 'is_enable' => 0],
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pay_type');
        
        //
    }
}
