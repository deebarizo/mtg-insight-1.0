<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CardsControllerTest extends TestCase {

	/** @test */
    public function displays_select_drop_down_field_for_set_information() {
        
       	$this->visit('cards/create');
       	$this->select(LATEST_SET_ID, 'set-id');
    }
}
