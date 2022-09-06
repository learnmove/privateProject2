<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->string('name');
			$table->integer('price');
			$table->text('description');
			$table->integer('quantity');
			$table->integer('school_id');
			$table->integer('category_id');
			$table->boolean('visible')->default(1);
			$table->string('img')->nullable();
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
		Schema::drop('products');
	}

}
