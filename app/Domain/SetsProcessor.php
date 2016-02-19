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

	public function getSets() {

		$sets = Set::take(2)->orderBy('id', 'desc')->get()->toArray();

		return $sets;
	}

}
