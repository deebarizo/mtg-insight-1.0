<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRoleFromIntegerToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saved_decklist_version_copies', function($table) 
        { 
            $table->string('role')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saved_decklist_version_copies', function($table) 
        { 
            $table->integer('role')->change();
        });
    }
}
