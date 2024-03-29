<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('buyer_id');
            $table->integer('seller_id');
            $table->integer('amount');
            $table->integer('quantity');
            $table->integer('order_status_id');
            $table->integer('pay_type_id');
            $table->integer('ship_type_id');
            $table->integer('is_visible')->default(1);
            $table->integer('is_enable')->default(1);
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoice_items');
	}

}
