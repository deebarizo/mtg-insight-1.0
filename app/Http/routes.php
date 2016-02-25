<?php

/****************************************************************************************
GLOBAL VARIABLES
****************************************************************************************/

define('CURRENT_FORMAT','Shadows over Innistrad Standard');
define('STARTING_SET_ID','3');

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
SAVED DECKLISTS
****************************************************************************************/

Route::post('saved_decklists/store', 'SavedDecklistsController@store'); // this is needed because i'm using ajax
Route::post('saved_decklists/update', 'SavedDecklistsController@update'); // this is needed because i'm using ajax
Route::resource('saved_decklists', 'SavedDecklistsController');


/****************************************************************************************
SCRAPERS
****************************************************************************************/

Route::get('scrapers/cards_json', 'ScrapersController@cardsJson');
Route::post('scrapers/store_cards_json', 'ScrapersController@storeCardsJson');