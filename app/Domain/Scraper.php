<?php 

namespace App\Domain;

use App\Set;

use vendor\symfony\DomCrawler\Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

use Illuminate\Support\Facades\Input;

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

		ddAll($set);
	}

}