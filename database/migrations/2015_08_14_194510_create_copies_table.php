<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copies', function($table)
        {
            $table->increments('id');
            $table->integer('decklist_id')->unsigned();
            $table->foreign('decklist_id')->references('id')->on('decklists');
            $table->integer('quantity');
            $table->integer('card_id')->unsigned();
            $table->foreign('card_id')->references('id')->on('cards');
            $table->string('role'); // md or sb
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
        Schema::dropIfExists('copies');
    }
}
