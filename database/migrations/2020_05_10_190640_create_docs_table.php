<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('docs')) {

            Schema::create('docs', function (Blueprint $table) {
                $table->id();
                $table->string('title',100);
                $table->string('slug',50);
                $table->text('desc')->nullable();
                $table->enum('user_type',['agent','shop','both'])->default('both');
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
        Schema::dropIfExists('docs');
    }
}
