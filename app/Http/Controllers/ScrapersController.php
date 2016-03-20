<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

		$message = $scraper->storeCsvFile($csvFile);

		return redirect()->action('ScrapersController@cardsJson')->with('message', $message);
	}

	public function sites() {

		$titleTag = 'Sites - Scrapers | ';

		return view('scrapers/sites', compact('titleTag'));
	}

	public function scrapeSites() {


	}

}
