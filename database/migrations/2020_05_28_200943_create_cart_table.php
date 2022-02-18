<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cart')) {
            Schema::create('cart', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->integer('store_id');
                $table->integer('prod_id');
                $table->integer('qty')->default(1);
                $table->float('price')->default(0.0);
                $table->enum('status',['active','inactive','disabled'])->default('active');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
}
