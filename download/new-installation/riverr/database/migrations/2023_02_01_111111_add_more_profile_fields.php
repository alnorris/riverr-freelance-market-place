<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_education', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 500);
            $table->string('institution', 500);
            $table->date('from');
            $table->date('to');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::create('user_experience', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 500);
            $table->string('company', 500);
            $table->string('description', 1000);
            $table->date('from');
            $table->date('to');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_education');
        Schema::dropIfExists('user_experience');
    }
};
