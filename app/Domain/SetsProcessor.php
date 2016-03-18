<?php 

namespace App\Domain;

use Request;

use App\Models\Set;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use Session;

class SetsProcessor {

	/****************************************************************************************
	GET SETS
	****************************************************************************************/

	public function getSets($howMany) {

		$sets = Set::take($howMany)->orderBy('id', 'desc')->get();

		return $sets;
	}

}
