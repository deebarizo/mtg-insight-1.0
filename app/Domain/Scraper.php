<?php 

namespace App\Domain;

ini_set('max_execution_time', 10800); // 10800 seconds = 3 hours

use App\Models\Set;
use App\Models\SetCard;
use App\Models\Card;
use App\Models\Layout;
use App\Models\Color;
use App\Models\CardColor;
use App\Models\CardLoyalty;
use App\Models\CardPowerToughness;
use App\Models\CardSubtype;
use App\Models\CardSupertype;
use App\Models\CardType;

use vendor\symfony\DomCrawler\Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

use Illuminate\Support\Facades\Input;

use Session;

class Scraper {

	/****************************************************************************************
	CARDS JSON FILES
	****************************************************************************************/

	public function getCsvFile($input) {

		$csvDirectory = 'files/cards_json/';
		$csvName = Input::file('json_file')->getClientOriginalName();
		$csvFile = $csvDirectory . $csvName;
 
		Input::file('json_file')->move($csvDirectory, $csvName);

		return $csvFile;
	}

	public function storeCsvFile($csvFile) {

		$jsonString = file_get_contents($csvFile);
		$set = json_decode($jsonString, true);

		$set['id'] = Set::where('code', $set['code'])->pluck('id'); 

		$setCardExists = SetCard::where('set_id', $set['id'])->first();

		if ($setCardExists) {

			Session::flash('alert', 'warning');

			return 'This SetCard already exists.';
		}

		foreach ($set['cards'] as $card) {
			$cardExists = Card::where('name', $card['name'])->first();

			if ($cardExists) {

				$cardId = Card::where('name', $card['name'])->pluck('id');

				$this->storeSetCard($set['id'], $cardId, $card);

				continue;
			}

			$cardIsBasicLand = $this->checkIfCardIsBasicLand($card);

			if ($cardIsBasicLand) {
				continue;
			}

			$this->storeCardArray($card, $set['id']);
		}

		Session::flash('alert', 'info');

		return 'Success!';
	}

	private function storeSetCard($setId, $cardId, $card) {
		
		$setCard = new SetCard;

		$setCard->set_id = $setId;
		$setCard->card_id = $cardId;
		$setCard->rarity = $card['rarity'];
		$setCard->multiverseid = $card['multiverseid'];

		$setCard->save();
	}

	private function checkIfCardIsBasicLand($input) {

		if ($input['name'] == 'Plains') {
			return true;
		}

		if ($input['name'] == 'Island') {
			return true;
		}

		if ($input['name'] == 'Swamp') {
			return true;
		}

		if ($input['name'] == 'Mountain') {
			return true;
		}

		if ($input['name'] == 'Forest') {
			return true;
		}

		return false;
	}

	private function storeCardArray($input, $setId) {

		$card = new Card;

		$card->name = $input['name'];

		if (isset($input['manaCost'])) {
			$manaCost = $input['manaCost'];
		} else {
			$manaCost = null;
		} 		
		$card->mana_cost = $manaCost;

		if (isset($input['cmc'])) {
			$cmc = $input['cmc'];
		} else {
			$cmc = 0;
		} 
		$card->cmc = $cmc;

		$card->middle_text = $input['type'];

		if (isset($input['text'])) {
			$text = $input['text'];
		} else {
			$text = '';
		} 
		$card->rules_text = $text;

		$card->layout_id = Layout::where('layout', $input['layout'])->pluck('id');

		$card->save();
		
		$cardId = $card->id;

		if (isset($input['colors'])) {
			
			foreach ($input['colors'] as $color) {
				
				$colorId = Color::where('color', $color)->pluck('id');

				$cardColor = new CardColor;

				$cardColor->card_id = $cardId;
				$cardColor->color_id = $colorId;

				$cardColor->save();
			}
		}	

		if (isset($input['loyalty'])) {
			
			$cardLoyalty = new CardLoyalty;

			$cardLoyalty->card_id = $cardId;
			$cardLoyalty->loyalty = $input['loyalty'];

			$cardLoyalty->save();
		}	

		if (isset($input['power']) && isset($input['toughness'])) {
			
			$cardPowerToughness = new CardPowerToughness;

			$cardPowerToughness->card_id = $cardId;
			$cardPowerToughness->power = $input['power'];
			$cardPowerToughness->toughness = $input['toughness'];

			$cardPowerToughness->save();
		}			
		
		if (isset($input['subtypes'])) {
			
			foreach ($input['subtypes'] as $subtype) {
				
				$cardSubtype = new CardSubtype;

				$cardSubtype->card_id = $cardId;
				$cardSubtype->subtype = $subtype;

				$cardSubtype->save();
			}
		}	

		if (isset($input['supertypes'])) {
			
			foreach ($input['supertypes'] as $supertype) {
				
				$cardSupertype = new CardSupertype;

				$cardSupertype->card_id = $cardId;
				$cardSupertype->supertype = $supertype;

				$cardSupertype->save();
			}
		}	

		if (isset($input['types'])) {
			
			foreach ($input['types'] as $type) {
				
				$cardType = new CardType;

				$cardType->card_id = $cardId;
				$cardType->type = $type;

				$cardType->save();
			}
		}		

		$this->storeSetCard($setId, $cardId, $input);	
	}

}