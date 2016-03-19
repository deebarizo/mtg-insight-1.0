<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Http\Request;

class CardsControllerTest extends TestCase {

	/** @test */
    public function submits_form_fields_for_creating_card() {
        
       	$this->visit('cards/create');
       	$this->select('SOI', 'set-code');
       	$this->type('Reality Smasher', 'name');
       	$this->type('{4}{C}', 'mana-cost');
       	$this->type(5, 'cmc');
       	$this->type('same', 'actual-cmc');
       	$this->type(4, 'rating');
       	$this->type('', 'note');
       	$this->type('', 'sources');
        $this->type('Reality Smasher', 'image')
             ->attach('files/card_images/', 'image');
       	$this->press('Submit');
    }

    /** @test */
    public function validates_required_inputs() {

        $this->call('POST', 'cards', [

            'set-code' => '',
            'name' => '',
            'cmc' => '',
            'actual-cmc' => '', 
            'image' => ''
        ]);

        $this->assertRedirectedToRoute('cards.create');

        $this->assertSessionHasErrors(['set-code', 'name', 'cmc', 'actual-cmc', 'image']);

        $this->followRedirects();

        $this->see('Please try again.');
    }

    /** @test */
    public function validates_card_already_exists() {

        $this->call('POST', 'cards', [

            'set-code' => 'OGW',
            'name' => 'Reality Smasher',
            'cmc' => '5',
            'actual-cmc' => 'same', 
            'image' => 'Reality Smasher.jpg'
        ]);

        $this->assertRedirectedToRoute('cards.create');

        $this->assertSessionHasErrors(['name']);

        $this->followRedirects();

        $this->see('This card already exists.');
    }    


    /** @test */
    public function stores_card() {

        $this->call('POST', 'cards', [

            'set-code' => 'TEST',
            'name' => 'Test Name',
            'cmc' => 1,
            'actual-cmc' => 'same', 
            'image' => 'test.jpg'
        ]);

        $this->assertRedirectedToRoute('cards.create');

        $this->followRedirects();

        $this->see('Success!');
    }  

}
