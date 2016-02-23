<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\SavedDecklist;
use App\Models\SavedDecklistVersion;
use App\Models\SavedDecklistVersionCopy;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use Session;

use App\Domain\CardsProcessor;
use App\Domain\SetsProcessor;

class SavedDecklistsController extends Controller
{
    private $format = CURRENT_FORMAT;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
        $savedDecklists = DB::select('SELECT t1.id, t1.saved_decklist_id, t1.name, sets.code FROM saved_decklist_versions AS t1
                                         JOIN (
                                            SELECT saved_decklist_id, MAX(id) AS latest FROM saved_decklist_versions GROUP BY saved_decklist_id
                                         ) AS t2
                                         ON t1.saved_decklist_id = t2.saved_decklist_id AND t1.id = t2.latest
                                      JOIN saved_decklists
                                      ON saved_decklists.id = t1.saved_decklist_id
                                      JOIN sets
                                      ON sets.id = saved_decklists.latest_set_id');

        return view('saved_decklists/index', compact('titleTag', 'savedDecklists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $setsProcessor = new SetsProcessor;

        $sets = $setsProcessor->getSets();

        $cardsProcessor = new CardsProcessor;

        list($cardsData, $actualCmcs) = $cardsProcessor->getCardsData();

        $lands = json_encode($cardsProcessor->getLands());

        $titleTag = 'Saved Decklists | ';
        $format = $this->format;

        return view('saved_decklists/create', compact('titleTag', 'format', 'cardsData', 'actualCmcs', 'lands', 'sets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        $request = Request::all();
        $input = $request['savedDecklist'];
        
        /****************************************************************************************
        ****************************************************************************************/

        $savedDecklist = new SavedDecklist;

        $savedDecklist->latest_set_id = $input['latestSetId'];

        $savedDecklist->save();

        /****************************************************************************************
        ****************************************************************************************/        

        $savedDecklistVersion = new SavedDecklistVersion;

        $savedDecklistVersion->saved_decklist_id = $savedDecklist->id;
        $savedDecklistVersion->name = $input['name'];

        $savedDecklistVersion->save();

        /****************************************************************************************
        ****************************************************************************************/        

        foreach ($input['copies'] as $copy) {

            $savedDecklistVersionCopy = new SavedDecklistVersionCopy;
            
            $savedDecklistVersionCopy->saved_decklist_version_id = $savedDecklistVersion->id;
            $savedDecklistVersionCopy->quantity = $copy['quantity'];
            $savedDecklistVersionCopy->card_id = $copy['cardId'];
            $savedDecklistVersionCopy->role = $copy['role'];

            $savedDecklistVersionCopy->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
