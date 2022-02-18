<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('agents')) {
            //
        
            Schema::create('agents', function (Blueprint $table) {
                $table->id();
                $table->string('name',255);
                $table->string('phone',15)->unique();
                $table->string('email',100)->unique();
                $table->string('address',100);
                $table->string('cover_photo',100)->nullable();
                $table->string('profile_photo',100)->nullable();
                $table->string('tag',100)->nullable();
                $table->string('lat',25);
                $table->string('lng',25);
                $table->string('desc',100)->nullable();
                $table->string('password',255);
                $table->enum('vehical_type',['cycle','bike','car'])->default('bike');
                $table->enum('is_phone_verified',['N','Y'])->default('N');
                $table->timestamp('email_verified_at')->nullable();
                $table->enum('is_email_verified',['N','Y'])->default('N');
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
        Schema::dropIfExists('agent');
    }
}
