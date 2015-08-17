<?php 

namespace App\Domain;

use Request;

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
use App\Models\CardActualCmc;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use Session;

class CardsProcessor {

	/****************************************************************************************
	REST
	****************************************************************************************/

	public function getCardsData() {
		
		$cardsData = DB::table('cards')
						->select('cards.id',
									'cards.name',
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

	public function getCardData($id) {
		
		$cardData = DB::table('cards')
						->select('cards.id',
									'cards.name',
									'cards.mana_cost',
									'cards.middle_text',
									'sets_cards.multiverseid',
									'cards_actual_cmcs.actual_cmc')
						->join('sets_cards', 'sets_cards.card_id', '=', 'cards.id')
						->leftJoin('cards_actual_cmcs', 'cards_actual_cmcs.card_id', '=', 'cards.id')
						->where('cards.id', $id)
						->first();

		$cardData->mana_cost = getManaSymbols($cardData->mana_cost);
	
		return $cardData;
	}

	public function updateCard($request, $id) {

		$input = Request::all();

		if (is_numeric($input['actual_cmc'])) {

			$input['actual_cmc'] = intval($input['actual_cmc']);

			if (is_int($input['actual_cmc'])) {

				if ($input['actual_cmc'] < 0) {

					Session::flash('alert', 'warning');

					return 'Invalid actual CMC.';	
				}

			} else {

				Session::flash('alert', 'warning');

				return 'Invalid actual CMC.';		
			}

		} else {

			if ($input['actual_cmc'] != 'variable') {
				
				Session::flash('alert', 'warning');

				return 'Invalid actual CMC.';	
			}		
		}

		$cardActualCmc = CardActualCmc::where('card_id', $id)->first();

		if ($cardActualCmc) {

			$cardActualCmc->actual_cmc = $input['actual_cmc'];

			$cardActualCmc->save();
		
		} else {

			$cardActualCmc = new CardActualCmc;

			$cardActualCmc->card_id = $id;
			$cardActualCmc->actual_cmc = $input['actual_cmc'];

			$cardActualCmc->save();
		}

		Session::flash('alert', 'info');

		return 'Success!';			
	}

}