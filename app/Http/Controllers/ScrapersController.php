<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

use App\Set;

class ScrapersController extends Controller {
	
	public function cardsJson() {
		$titleTag = 'Cards JSON - Scrapers | ';

		$sets = Set::orderBy('id')->lists('name', 'name')->toArray();

		return view('scrapers/cards_json', compact('titleTag', 'sets'));
	}

	public function storeCardsJson(Request $request) {
        $message = 'Success!';
        Session::flash('alert', 'info');
		
		return redirect()->action('ScrapersController@cardsJson')->with('message', $message);
	}

}
