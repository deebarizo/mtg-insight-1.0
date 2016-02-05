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
		$setData = json_decode($jsonString, true);

		# ddAll($setData);

		$setData['id'] = Set::where('code', $setData['code'])->pluck('id'); 

		$setCardExists = SetCard::where('set_id', $setData['id'])->first();

		if ($setCardExists) {

			Session::flash('alert', 'warning');

			return 'This SetCard already exists.';
		}

		foreach ($setData['cards'] as $cardData) {
			$cardIsBasicLand = $this->checkIfCardIsBasicLand($cardData);

			if ($cardIsBasicLand) {

				continue;
			}
			
			$cardExists = Card::where('name', $cardData['name'])->first();

			if ($cardExists) {

				$cardData['id'] = Card::where('name', $cardData['name'])->pluck('id');

				$this->storeSetCard($setData['id'], $cardData['id'], $cardData);

				continue;
			}

			$this->storeCardArray($cardData, $setData['id']);
		}

		Session::flash('alert', 'info');

		return 'Success!';
	}

	private function storeSetCard($setId, $cardId, $cardData) {
		
		$setCard = new SetCard;

		$setCard->set_id = $setId;
		$setCard->card_id = $cardId;
		$setCard->rarity = $cardData['rarity'];
		$setCard->multiverseid = $cardData['multiverseid'];

		$setCard->save();
	}

	private function checkIfCardIsBasicLand($cardData) {

		if ($cardData['name'] == 'Plains') {

			return true;
		}

		if ($cardData['name'] == 'Island') {

			return true;
		}

		if ($cardData['name'] == 'Swamp') {

			return true;
		}

		if ($cardData['name'] == 'Mountain') {

			return true;
		}

		if ($cardData['name'] == 'Forest') {

			return true;
		}

		return false;
	}

	private function storeCardArray($cardData, $setId) {

		$card = new Card;

		$card->name = $cardData['name'];

		if (isset($cardData['manaCost'])) {

			$manaCost = $cardData['manaCost'];

		} else {

			$manaCost = null;

		} 		

		$card->mana_cost = $manaCost;

		if (isset($cardData['cmc'])) {

			$cmc = $cardData['cmc'];

		} else {

			$cmc = 0;

		} 

		$card->cmc = $cmc;

		$card->middle_text = $cardData['type'];

		if (isset($cardData['text'])) {

			$text = $cardData['text'];

		} else {

			$text = '';

		} 

		$card->rules_text = $text;

		$card->layout_id = Layout::where('layout', $cardData['layout'])->pluck('id');

		$card->save();
		
		$cardData['id'] = $card->id;

		if (isset($cardData['colors'])) {
			
			foreach ($cardData['colors'] as $color) {
				
				$colorId = Color::where('color', $color)->pluck('id');

				$cardColor = new CardColor;

				$cardColor->card_id = $cardData['id'];
				$cardColor->color_id = $colorId;

				$cardColor->save();
			}
		}	

		if (isset($cardData['loyalty'])) {
			
			$cardLoyalty = new CardLoyalty;

			$cardLoyalty->card_id = $cardData['id'];
			$cardLoyalty->loyalty = $cardData['loyalty'];

			$cardLoyalty->save();
		}	

		if (isset($cardData['power']) && isset($cardData['toughness'])) {
			
			$cardPowerToughness = new CardPowerToughness;

			$cardPowerToughness->card_id = $cardData['id'];
			$cardPowerToughness->power = $cardData['power'];
			$cardPowerToughness->toughness = $cardData['toughness'];

			$cardPowerToughness->save();
		}			
		
		if (isset($cardData['subtypes'])) {
			
			foreach ($cardData['subtypes'] as $subtype) {
				
				$cardSubtype = new CardSubtype;

				$cardSubtype->card_id = $cardData['id'];
				$cardSubtype->subtype = $subtype;

				$cardSubtype->save();
			}
		}	

		if (isset($cardData['supertypes'])) {
			
			foreach ($cardData['supertypes'] as $supertype) {
				
				$cardSupertype = new CardSupertype;

				$cardSupertype->card_id = $cardData['id'];
				$cardSupertype->supertype = $supertype;

				$cardSupertype->save();
			}
		}	

		if (isset($cardData['types'])) {
			
			foreach ($cardData['types'] as $type) {
				
				$cardType = new CardType;

				$cardType->card_id = $cardData['id'];
				$cardType->type = $type;

				$cardType->save();
			}
		}		

		$this->storeSetCard($setId, $cardData['id'], $cardData);	
	}

}