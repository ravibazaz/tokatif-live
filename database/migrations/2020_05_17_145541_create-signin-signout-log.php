<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSigninSignoutLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('login_log')) {
            Schema::create('login_log', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->enum('userType',['c','s','a'])->default('c');
                $table->enum('logType',['login','logout'])->default('login');
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
         Schema::dropIfExists('login_log');
        //
    }
}
