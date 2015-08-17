<?php

/****************************************************************************************
PAGES
****************************************************************************************/

Route::get('/', function () {
	$titleTag = '';
    return view('pages/home', compact('titleTag'));
});

Route::get('scrapers', function () {
	$titleTag = 'Scrapers | ';
    return view('pages/scrapers', compact('titleTag'));
});


/****************************************************************************************
CARDS
****************************************************************************************/

Route::resource('cards', 'CardsController');


/****************************************************************************************
SCRAPERS
****************************************************************************************/

Route::get('scrapers/cards_json', 'ScrapersController@cardsJson');
Route::post('scrapers/store_cards_json', 'ScrapersController@storeCardsJson');