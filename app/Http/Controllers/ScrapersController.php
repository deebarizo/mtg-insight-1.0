<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

use App\Set;

use App\Domain\Scraper;

class ScrapersController extends Controller {
	
	public function cardsJson() {
		$titleTag = 'Cards JSON - Scrapers | ';

		return view('scrapers/cards_json', compact('titleTag'));
	}

	public function storeCardsJson(Request $request) {
		$input = Request::all();

		$scraper = new Scraper;

		$csvFile = $scraper->getCsvFile($input);

		$scraper->storeCsvFile($csvFile);

		$message = 'Success!';
        Session::flash('alert', 'info');
		
		return redirect()->action('ScrapersController@cardsJson')->with('message', $message);
	}

}
