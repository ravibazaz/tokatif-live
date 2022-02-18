<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->integer('prod_cat_id');
                $table->integer('store_id');
                $table->string('prod_name');
                $table->text('prod_img')->nullable();
                $table->text('prod_desc')->nullable();
                $table->integer('prod_price');
                $table->integer('prod_delivery_time');
                $table->enum('is_avail',['Y','N'])->default('Y');
                $table->enum('status',['pending','active','rejected','deleted'])->default('pending');
                $table->integer('prod_qty')->nullable();
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
        Schema::dropIfExists('products');
    }
}
