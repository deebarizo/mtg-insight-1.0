<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTypesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards_types', function($table)
        {
            $table->increments('id');
            $table->integer('card_id')->unsigned();
            $table->foreign('card_id')->references('id')->on('cards');
            $table->string('type');
            $table->date('created_at');
            $table->date('updated_at');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards_types');
    }
}
