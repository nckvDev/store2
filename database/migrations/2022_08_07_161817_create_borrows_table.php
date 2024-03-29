<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('borrow_list_id');
            $table->string('borrow_name');
            $table->integer('borrow_status')->default(0);
            $table->string('borrow_amount');
            $table->unsignedBigInteger('user_id');
            $table->string('description')->nullable();
            $table->string('started_at')->nullable();
            $table->string('end_at')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('borrows');
    }
}
