<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavedDecklistVersionCopies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_decklist_version_copies', function($table)
        {
            $table->increments('id');
            $table->integer('saved_decklist_version_id')->unsigned(); 
            $table->foreign('saved_decklist_version_id')->references('id')->on('saved_decklist_versions');
            $table->integer('quantity');
            $table->integer('card_id')->unsigned(); 
            $table->foreign('card_id')->references('id')->on('cards');
            $table->integer('role'); // maindeck (md) or sideboard (sb)
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
        Schema::dropIfExists('saved_decklist_version_copies');
    }
}
