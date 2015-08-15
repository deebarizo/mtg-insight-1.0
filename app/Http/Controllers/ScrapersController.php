<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScrapersController extends Controller {
	
	public function cardsJson() {
		$titleTag = 'Cards JSON - Scrapers | ';

		return view('scrapers/cards_json', compact('titleTag'));
	}

}
