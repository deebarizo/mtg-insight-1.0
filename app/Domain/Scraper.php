<?php 

namespace App\Domain;

use App\Models\Set;
use App\Models\SetCard;
use App\Models\Card;
use App\Models\Layout;

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

		$setCardExists = SetCard::where('set_id', $set['code'])->first();

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
		$setCard->rarity = $input['rarity'];
		$setCard->multiverseid = $input['multiverseid'];

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
		$card->mana_cost = $input['manaCost'];
		$card->cmc = $input['cmc'];
		$card->middle_text = $input['type'];
		$card->rules_text = $input['text'];
		$card->layout_id = Layout::where('layout', $input['layout'])->pluck('id');

		$card->save();
		
		$cardId = $card->id;

		

		ddAll($card);
	}

}