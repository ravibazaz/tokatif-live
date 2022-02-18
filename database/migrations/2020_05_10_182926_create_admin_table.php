<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('admin')) {

            Schema::create('admin', function (Blueprint $table) {
                $table->id();
                $table->string('name',20);
                $table->string('username',50);
                $table->string('phone',14)->nullable();
                $table->string('email',50)->unique();
                $table->string('password',100);
                $table->string('photo',50)->nullabel();
                $table->enum('status',['active','inactive','disabled']);
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
        Schema::dropIfExists('admin');
    }
}
