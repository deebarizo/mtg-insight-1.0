<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavedDecklistVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_decklist_versions', function($table)
        {
            $table->increments('id');
            $table->integer('saved_decklist_id')->unsigned(); 
            $table->foreign('saved_decklist_id')->references('id')->on('saved_decklists');
            $table->string('name');
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
        Schema::dropIfExists('saved_decklist_versions');
    }
}
