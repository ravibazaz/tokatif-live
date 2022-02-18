<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        if (!Schema::hasTable('users')) {

            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name',255);
                $table->string('phone',15)->unique();
                $table->string('email',255)->unique();
                $table->integer('otp')->nullable();
                $table->string('address',100);
                $table->string('photo',100)->nullable();
                $table->string('desc',100)->nullable();
                $table->string('password',255);
                $table->enum('is_phone_verified',['N','Y'])->default('N');
                $table->timestamp('email_verified_at')->nullable();
                $table->enum('is_email_verified',['N','Y'])->default('N');
                $table->enum('status',['active','inactive','disabled'])->default('active');
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
