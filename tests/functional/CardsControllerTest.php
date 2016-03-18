<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CardsControllerTest extends TestCase {

	/** @test */
    public function displays_form_fields_for_creating_card() {
        
       	$this->visit('cards/create');
       	$this->select('BOB', 'set-code');
       	$this->type('Reality Smasher', 'name');
       	$this->type('{4}{C}', 'mana-cost');
       	$this->type(5, 'cmc');
       	$this->type('same', 'actual-cmc');
       	$this->type(4, 'rating');
       	$this->type('', 'note');
    }

	/** @test */
    public function displays_form_fields_for_creating_land_card() {
        
       	$this->visit('cards/create');
       	$this->type('green blue colorless', 'sources');
    }

}
