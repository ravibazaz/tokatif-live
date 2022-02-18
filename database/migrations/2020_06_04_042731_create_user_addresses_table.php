<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_addresses')){
            Schema::create('user_addresses', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->string('title');
                $table->string('address',100)->nullable();
                $table->string('city',100)->nullable();
                $table->string('postcode',7)->nullable();
                $table->string('state',100)->nullable();
                $table->string('lat',20)->nullable();
                $table->string('lng',20)->nullable();
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
        Schema::dropIfExists('user_addresses');
    }
}
