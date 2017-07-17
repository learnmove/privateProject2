<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateItemStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event');
            $table->string('content');
            $table->timestamps();
        });
        DB::table('item_statuses')->insert([
            ['event'=>'not_pay','content'=>'買家未付款'],
            ['event'=>'payed','content'=>'買家已付款']
            ,['event'=>'confirm_payed','content'=>'賣家已確認']
            ,['event'=>'sended','content'=>'賣家已出貨']
            ,['event'=>'carry','content'=>'運送中']
            ,['event'=>'arrived','content'=>'已抵逹']
            ,['event'=>'get_stuff','content'=>'已取貨']
            ,['event'=>'cancel','content'=>'要求取消交易']
            ,['event'=>'canceled','content'=>'已取消交易']
            ,['event'=>'refund','content'=>'要求退貨']
            ,['event'=>'refunded','content'=>'已退貨']
            ,['event'=>'complete','content'=>'交易完成']
            ,['event'=>'get_confirm','content'=>'收貨確認']
            ,['event'=>'refund_angreen','content'=>'同意退貨']]);
            
            
            
            
            
            

            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_statuses');
    }
}
