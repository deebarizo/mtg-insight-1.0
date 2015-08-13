<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function($table)
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('mana_cost');
            $table->integer('cmc');
            $table->string('middle_text');
            $table->text('rules_text');
            $table->integer('layout_id')->unsigned();
            $table->foreign('layout_id')->references('id')->on('layouts');
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
        Schema::dropIfExists('cards');
    }
}
