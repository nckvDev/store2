<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposables', function (Blueprint $table) {
            $table->id();
            $table->string('disposable_name');
            $table->integer('disposable_amount');
            $table->integer('disposable_status')->default(0);
            $table->string('image');
            $table->integer('amount_minimum');
            $table->string('disposable_num');
            $table->unsignedBigInteger('type_id');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposables');
    }
}
