<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('display_order_id',50);
                $table->integer('user_id');
                $table->integer('agent_id')->nullable();
                $table->integer('store_id');
                $table->float('total_price')->default(0.0);
                $table->float('service_charge')->default(0.0);
                $table->text('delivery_address')->nullable();
                $table->text('shipping_address')->nullable();
                $table->enum('status',['pending','accepted','rejected','ready_to_pickup','pickuped','deliverd','completed','canceled'])->default('pending');
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
        Schema::dropIfExists('orders');
    }
}
