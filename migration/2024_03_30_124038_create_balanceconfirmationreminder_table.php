<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceconfirmationreminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balanceconfirmationreminder', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->integer('network_count')->default(0);
            $table->text('icon');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('balanceconfirmationreminder');
    }
}
