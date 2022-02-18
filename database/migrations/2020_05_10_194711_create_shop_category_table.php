<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('shop_categories')) {
            Schema::create('shop_categories', function (Blueprint $table) {
                $table->id();
                $table->string('category_name',100);
                $table->text('category_desc')->nullable();
                $table->string('cover_photo',100)->nullable();
                $table->enum('status',['active','inactive','pending','disabled'])->default('active');
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
        Schema::dropIfExists('shop_category');
    }
}
