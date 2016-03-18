<?php 

namespace App\Domain;

use App\Models\Set;

use Illuminate\Http\Request;
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
