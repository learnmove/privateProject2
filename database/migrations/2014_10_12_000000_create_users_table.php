<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account');
            $table->text('avatar');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 10)->default('1234567890');
            $table->string('password');
            $table->integer('school_id');
            $table->integer('wallet')->default(0);
            $table->tinyInteger('is_enable')->default(1);

            $table->string('shop_name');
            $table->text('shop_description')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
