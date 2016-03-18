<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CardsControllerTest extends TestCase {

	/** @test */
    public function display_form_fields_for_creating_nonland_card() {
        
       	$this->visit('cards/create');
       	$this->select('SOI', 'set-code');
       	$this->type('Reality Smasher', 'name');
       	$this->type('{4}{C}', 'mana-cost');
       	$this->type(5, 'cmc');
       	$this->type('same', 'actual-cmc');
       	$this->type(4, 'rating');
       	$this->type('', 'note');
       	$this->type('', 'sources');
       	$this->press('Submit');
    }

	/** @test */
    public function display_form_fields_for_creating_land_card() {
        
       	$this->visit('cards/create');
       	$this->select('SOI', 'set-code');
       	$this->type('Yavimaya Coast', 'name');
       	$this->type('', 'mana-cost');
       	$this->type(0, 'cmc');
       	$this->type('same', 'actual-cmc');
       	$this->type('', 'rating');
       	$this->type('', 'note');
       	$this->type('green blue colorless', 'sources');
       	$this->press('Submit');
    }

}
