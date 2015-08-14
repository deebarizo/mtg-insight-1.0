<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decklists', function($table)
        {
            $table->increments('id');
            $table->string('player');
            $table->string('finish');
            $table->integer('archetype_id')->unsigned();
            $table->foreign('archetype_id')->references('id')->on('archetypes');
            $table->integer('tournament_id')->unsigned();
            $table->foreign('tournament_id')->references('id')->on('tournaments');
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
        Schema::dropIfExists('decklists');
    }
}
