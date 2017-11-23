<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('connectionString');
            $table->string('destination');
            $table->string('dir');
            $table->string('ext');
            $table->string('handlers');
            $table->string('location');
            $table->boolean('remove');
            $table->boolean('subDirectory');
            $table->string('unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_log');
    }
}
