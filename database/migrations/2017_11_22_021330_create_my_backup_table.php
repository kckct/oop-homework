<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyBackupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_backup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->dateTime('fileDateTime');
            $table->integer('size');
            $table->string('handlers');
            $table->text('target');
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
        Schema::dropIfExists('my_backup');
    }
}
