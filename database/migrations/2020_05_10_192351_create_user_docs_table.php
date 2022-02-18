<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_docs')){

            Schema::create('user_docs', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->enum('user_type',['agent','shop'])->default('agent');
                $table->string('doc_slug',50);
                $table->string('url',100);
                $table->enum('status',['pending','approved','rejected'])->default('pending');
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
        Schema::dropIfExists('user_docs');
    }
}
