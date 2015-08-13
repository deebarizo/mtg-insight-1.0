<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsActualCmcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards_actual_cmcs', function($table)
        {
            $table->increments('id');
            $table->integer('card_id')->unsigned();
            $table->foreign('card_id')->references('id')->on('cards');
            $table->string('actual_cmc');
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
        Schema::dropIfExists('cards_actual_cmcs');
    }
}
