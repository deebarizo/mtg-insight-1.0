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
use App\Models\CardRating;
use App\Models\CardTag;
use App\Models\CardSource;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use Session;

class CardsProcessor {

	/****************************************************************************************
	GET CARDS
	****************************************************************************************/

	public function getCardsData() {
		
		$cardsData = DB::table('cards')
						->select('cards.id',
									'cards.name',
									'cards.cmc',
									'cards.mana_cost',
									'cards.middle_text',
									'sets_cards.multiverseid',
									'cards_actual_cmcs.actual_cmc',
									'cards_ratings.rating',
									'cards_ratings.note')
						->join('sets_cards', 'sets_cards.card_id', '=', 'cards.id')
						->leftJoin('cards_actual_cmcs', 'cards_actual_cmcs.card_id', '=', 'cards.id')
						->leftJoin('cards_ratings', 'cards_ratings.card_id', '=', 'cards.id')
						->orderBy('cards.name')
						->groupBy('cards.name')
						->get();

		$actualCmcs = [];

		foreach ($cardsData as $card) {

			$card->mana_cost = getManaSymbols($card->mana_cost);

			if (is_null($card->actual_cmc)) {
				$card->actual_cmc = $card->cmc;
			}

			if ($card->actual_cmc != 'variable') {

				array_push($actualCmcs, $card->actual_cmc);
			}
		}

		$actualCmcs = array_unique($actualCmcs);

		sort($actualCmcs);

		array_push($actualCmcs, 'variable');

		return array($cardsData, $actualCmcs);
	}


	/****************************************************************************************
	GET CARD
	****************************************************************************************/

	public function getCardData($id) {
		
		$cardData = DB::table('cards')
						->select('cards.id',
									'cards.name',
									'cards.mana_cost',
									'cards.cmc',
									'cards.middle_text',
									'sets_cards.multiverseid',
									'cards_actual_cmcs.actual_cmc',
									'cards_ratings.rating',
									'cards_ratings.note')
						->join('sets_cards', 'sets_cards.card_id', '=', 'cards.id')
						->leftJoin('cards_actual_cmcs', 'cards_actual_cmcs.card_id', '=', 'cards.id')
						->leftJoin('cards_ratings', 'cards_ratings.card_id', '=', 'cards.id')
						->where('cards.id', $id)
						->first();

		$cardData->mana_cost = getManaSymbols($cardData->mana_cost);

		if (is_null($cardData->actual_cmc)) {

			$cardData->actual_cmc = 'N/A';
		}

		return $cardData;
	}


	/****************************************************************************************
	UPDATE CARD
	****************************************************************************************/

	public function updateCard($request, $id) {

		$input = Request::all();

		$processActualCmcMsg = $this->processActualCmc($input['actual_cmc'], $id);

		if ($processActualCmcMsg === false) {

			Session::flash('alert', 'warning');

			return 'Invalid actual CMC.';	
		}

		$processRatingMsg = $this->processRating($input['rating'], $id);

		if ($processRatingMsg === false) {

			Session::flash('alert', 'warning');

			return 'Invalid rating.';	
		}

		$processNoteMsg = $this->processNote($input['note'], $id);

		if ($processNoteMsg === false) {

			Session::flash('alert', 'warning');

			return 'Invalid note.';	
		}

		Session::flash('alert', 'info');

		return 'Success!';			
	}


	/****************************************************************************************
	PROCESS ACTUAL CMC
	****************************************************************************************/

	private function processActualCmc($actualCmc, $id) {

		$cardActualCmc = CardActualCmc::where('card_id', $id)->first();

		if (!is_null($cardActualCmc) && $actualCmc == 'N/A') {
			
			$cardActualCmc->delete();

			return true;
		}

		if ($actualCmc == 'N/A') {
			
			return true;
		}

		if (is_numeric($actualCmc)) {

			$actualCmc = intval($actualCmc);

			if (is_int($actualCmc)) {

				if ($actualCmc < 0) {

					return false;
				}

			} else {

				return false;	
			}

		} else {

			if ($actualCmc != 'variable') {
				
				return false;
			}		
		}

		if ($cardActualCmc) {

			$cardActualCmc->actual_cmc = $actualCmc;

			$cardActualCmc->save();
		
		} else {

			$cardActualCmc = new CardActualCmc;

			$cardActualCmc->card_id = $id;
			$cardActualCmc->actual_cmc = $actualCmc;

			$cardActualCmc->save();
		}

		return true;	
	}


	/****************************************************************************************
	PROCESS RATING
	****************************************************************************************/

	private function processRating($rating, $id) {

		if (is_numeric($rating)) {

			$rating = intval($rating);

			if (is_int($rating)) {

				if ($rating < 0) {

					return false;
				}

			} else {

				return false;	
			}

		} else if ($rating != '') {

			return false;
		}

		$cardRating = CardRating::where('card_id', $id)->first();

		if ($cardRating) {

			if ($rating == '0' || $rating == '') {

				$cardRating->delete();

				return true;
			}

			$cardRating->rating = $rating;

			$cardRating->save();

		} else {

			if ($rating == '0' || $rating == '') {

				return true;
			}

			$cardRating = new CardRating;

			$cardRating->card_id = $id;
			$cardRating->rating = $rating;

			$cardRating->save();
		}

		return true;
	}


	/****************************************************************************************
	PROCESS NOTE
	****************************************************************************************/

	private function processNote($note, $id) {

		$cardRating = CardRating::where('card_id', $id)->first();

		if ($cardRating) {

			$cardRating->note = $note;

			$cardRating->save();
		
		} else {

			if ($note == '') {

				return true;
			}

			$cardRating = new CardRating;

			$cardRating->card_id = $id;
			$cardRating->note = $note;

			$cardRating->save();
		}

		return true;
	}


	/****************************************************************************************
	GET LANDS
	****************************************************************************************/

	public function getLands() {

		$landSources = Card::has('sources')->where('cards.middle_text', 'LIKE', '%Land%')->get();

		$lands = [];

        foreach ($landSources as $landSource) {

        	array_push($lands, $landSource->sources()->get());
        }   

        return $lands;
	}

}