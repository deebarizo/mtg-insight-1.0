<?php 

namespace App\Domain;

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

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use Session;

class CardsProcessor {

	/****************************************************************************************
	REST
	****************************************************************************************/

	public function getDataForIndex() {
		
		$cardsData = DB::table('cards')
						->select('cards.name',
									'cards.mana_cost',
									'cards.middle_text',
									'sets_cards.multiverseid')
						->join('sets_cards', 'sets_cards.card_id', '=', 'cards.id')
						->orderBy('cards.name')
						->groupBy('cards.name')
						->get();

		foreach ($cardsData as $card) {
			$card->mana_cost = getManaSymbols($card->mana_cost);
		}

		return $cardsData;
	}

}