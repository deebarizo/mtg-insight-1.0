<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Http\Request;

use App\Models\Set;
use App\Models\Card;
use App\Models\Layout;

class CardsControllerTest extends TestCase {

    use DatabaseTransactions;

	/** @test */
    public function submits_form_fields_for_creating_card() {

        factory(Set::class)->create([
        
            'code' => 'SOI'
        ]);

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

        factory(Layout::class)->create([
        
            'id' => 1,
            'layout' => 'normal'
        ]);

        factory(Card::class)->create([
        
            'name' => 'Reality Smasher'
        ]);

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

        factory(Set::class)->create([
        
            'code' => 'SOI'
        ]);

        factory(Layout::class)->create([
        
            'id' => 1,
            'layout' => 'normal'
        ]);

        $this->call('POST', 'cards', [

            'set-code' => 'SOI',
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
