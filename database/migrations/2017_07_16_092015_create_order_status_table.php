<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateOrderStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cht_name');
            $table->timestamps();
        });
        DB::table('order_status')->insert([
            ['id' => '1', 'name'=>'not_pay','cht_name'=>'買家未付款'],
            ['id' => '2', 'name'=>'payed','cht_name'=>'買家已付款']
            ,['id' => '3', 'name'=>'confirm_payed','cht_name'=>'賣家已確認']
            ,['id' => '4', 'name'=>'sended','cht_name'=>'賣家已出貨']
            ,['id' => '5', 'name'=>'carry','cht_name'=>'運送中']
            ,['id' => '6', 'name'=>'arrived','cht_name'=>'已抵逹']
            ,['id' => '7', 'name'=>'get_stuff','cht_name'=>'已取貨']
            ,['id' => '8', 'name'=>'asked_cancel','cht_name'=>'要求取消交易']
            ,['id' => '9', 'name'=>'canceled','cht_name'=>'已取消交易']
            ,['id' => '10', 'name'=>'refund','cht_name'=>'要求退貨']
            ,['id' => '11', 'name'=>'refunded','cht_name'=>'已退貨']
            ,['id' => '12', 'name'=>'trade_complete','cht_name'=>'交易完成']
            ,['id' => '13', 'name'=>'get_confirm','cht_name'=>'收貨確認']
            ,['id' => '14', 'name'=>'refund_angree','cht_name'=>'同意退貨']]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status');
    }
}
