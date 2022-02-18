<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('stores')) {

            Schema::create('stores', function (Blueprint $table) {
                $table->id();
                $table->string('store_name',255);
                $table->string('store_phone',255)->unique();
                $table->string('store_email',255)->unique();
                $table->string('store_address',100);
                $table->string('store_cover_photo',100)->nullable();
                $table->string('store_tag',100)->nullable();
                $table->integer('shop_cat_id');
                $table->string('lat',25);
                $table->string('lng',25);
                $table->string('desc',100)->nullable();
                $table->string('password',255);
                $table->string('otp',8)->nullable();
                $table->enum('is_phone_verified',['N','Y'])->default('N');
                $table->timestamp('email_verified_at')->nullable();
                $table->enum('is_email_verified',['N','Y'])->default('N');
                $table->enum('is_online',['Y','N'])->default('N');
                $table->enum('status',['active','inactive','pending','disabled'])->default('pending');
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
        Schema::dropIfExists('store');
    }
}
