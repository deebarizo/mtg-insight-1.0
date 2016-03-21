<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Http\Request;

use App\Models\Set;
use App\Models\Card;
use App\Models\Layout;
use App\Models\CardActualCmc;
use App\Models\CardRating;
use App\Models\CardSource;
use App\Models\SetCard;

use App\Domain\CardsProcessor;

class CardsControllerTest extends TestCase {

    use DatabaseTransactions;

    private function setUpStoreTests() {

        factory(Set::class)->create([
        
            'code' => 'SOI'
        ]);

        factory(Layout::class)->create([
        
            'id' => 1,
            'layout' => 'normal'
        ]);
    }

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
            'rating' => '',
            'image' => ''
        ]);

        $this->assertRedirectedToRoute('cards.create');

        $this->assertSessionHasErrors(['set-code', 'name', 'cmc', 'actual-cmc', 'image', 'rating']);

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
            'cmc' => 5,
            'actual-cmc' => 'same', 
            'rating' => 4,
            'image' => 'Reality Smasher.jpg'
        ]);

        $this->assertRedirectedToRoute('cards.create');

        $this->assertSessionHasErrors(['name']);

        $this->followRedirects();

        $this->see('This card already exists.');
    }    


    /** @test */
    public function validates_successful_input() {

        $this->setUpStoreTests();

        $this->call('POST', 'cards', [

            'set-code' => 'SOI',
            'name' => 'Test Name',
            'cmc' => 1,
            'actual-cmc' => 'same',
            'rating' => 4, 
            'image' => 'test.jpg'
        ]);

        $this->assertRedirectedToRoute('cards.create');

        $this->followRedirects();

        $this->see('Success!');
    }  

    /** @test */
    public function stores_card_without_actual_cmc_and_sources() {

        $this->setUpStoreTests();

        $cardsProcessor = new CardsProcessor;

        $input = [

            'set-code' => 'SOI', 
            'name' => 'Test Name',
            'mana-cost' => '{U}',
            'cmc' => 1,
            'actual-cmc' => 'same',
            'rating' => 4,
            'note' => '',
            'sources' => '',
            'image' => 'test.jpg'
        ];

        $cardsProcessor->addCard($input);

        $cards = Card::where('name', 'Test Name')->get();

        $this->assertCount(1, $cards);

        $cardRating = CardRating::where('rating', 4)->get();

        $this->assertCount(1, $cardRating);

        $setCards = SetCard::where('card_id', $cards[0]->id)->get();

        $this->assertCount(1, $setCards);

        $cardActualCmcs = CardActualCmc::all();

        $this->assertCount(0, $cardActualCmcs);

        $cardSources = CardSource::all();

        $this->assertCount(0, $cardSources);
    }

    /** @test */
    public function stores_card_with_actual_cmc() {

        $this->setUpStoreTests();

        $cardsProcessor = new CardsProcessor;

        $input = [

            'set-code' => 'SOI', 
            'name' => 'Test Name',
            'mana-cost' => '{U}',
            'cmc' => 1,
            'actual-cmc' => 'variable',
            'rating' => 4,
            'note' => '',
            'sources' => '',
            'image' => 'test.jpg'
        ];

        $cardsProcessor->addCard($input);

        $cardActualCmcs = CardActualCmc::where('actual_cmc', 'variable')->get();

        $this->assertCount(1, $cardActualCmcs);
    }

    /** @test */
    public function stores_card_with_sources() {

        $this->setUpStoreTests();

        $cardsProcessor = new CardsProcessor;

        $input = [

            'set-code' => 'SOI', 
            'name' => 'Test Name',
            'mana-cost' => '',
            'cmc' => 0,
            'actual-cmc' => 'same',
            'rating' => 4,
            'note' => '',
            'sources' => 'green blue colorless',
            'image' => 'test.jpg'
        ];

        $cardsProcessor->addCard($input);

        $cardSource = CardSource::where('color', 'green')->orWhere('color', 'blue')->orWhere('color', 'colorless')->get();

        $this->assertCount(3, $cardSource);
    }

}
