<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Http\Request;

class CardsControllerTest extends TestCase {

    public function __construct() {

        $this->mock = Mockery::mock('Eloquent', 'App\Models\Card');
     }
     
    public function tearDown() {

        Mockery::close();
    }

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

        Input::replace($input = [

            'set-code' => '',
            'name' => '',
            'cmc' => '',
            'actual-cmc' => '',
            'image' => ''
        ]);

        // http://code.tutsplus.com/tutorials/testing-laravel-controllers--net-31456
        $this->app->instance('App\Models\Card', $this->mock); 

        $this->call('POST', 'cards');

        $this->assertRedirectedToRoute('cards.create');

        $this->assertSessionHasErrors(['set-code', 'name', 'cmc', 'actual-cmc', 'image']);
    }

    /** @test */
    public function stores_card() {  

        Input::replace($input = [

            'set-code' => 'SOI',
            'name' => 'Test Name',
            'cmc' => '1',
            'actual-cmc' => 'variable',
            'image' => 'test.jpg'
        ]);
    
        $this->mock
             ->shouldReceive('create')
             ->once();
        
        // http://code.tutsplus.com/tutorials/testing-laravel-controllers--net-31456
        $this->app->instance('App\Models\Card', $this->mock); 

        $this->call('POST', 'cards');

        $this->assertRedirectedToRoute('cards.index');
    }  

}
