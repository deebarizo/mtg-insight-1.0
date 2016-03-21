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

        $titleTag = 'Saved Decklists | ';

        return view('saved_decklists/index', compact('titleTag', 'savedDecklists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        list($sets, $cardsData, $actualCmcs, $lands) = $this->generateCards();

        $titleTag = 'Create - Saved Decklists | ';

        $savedDecklistVersion = [

            'meta' => new \stdClass(),
            'md_copies' => null,
            'sb_copies' => null
        ];

        $savedDecklistVersion['meta']->saved_decklist_id = null;
        $savedDecklistVersion['meta']->name = '';
        $savedDecklistVersion['meta']->latest_set_id = $sets[0]['id'];
        $savedDecklistVersion['meta']->h3_tag = 'Create Decklist';

        $button = [

            'css_class' => 'submit-decklist',
            'anchor_text' => 'Submit Decklist'    
        ];

        # ddAll($savedDecklistVersion);
        # ddAll($sets);

        return view('saved_decklists/create', compact('titleTag', 'cardsData', 'actualCmcs', 'lands', 'sets', 'savedDecklistVersion', 'button'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        $this->storeNewVersion($request, 'store');
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
    public function edit($id) {
        
        list($sets, $cardsData, $actualCmcs, $lands) = $this->generateCards();

        $titleTag = 'Edit - Saved Decklists | ';

        /****************************************************************************************
        ****************************************************************************************/   

        $versionId = SavedDecklistVersion::where('saved_decklist_id', $id)->orderBy('id', 'desc')->take(1)->pluck('id');

        $savedDecklistVersion = [];

        $savedDecklistVersion['meta'] = DB::table('saved_decklists')
                                            ->select('saved_decklist_id', 
                                                     'saved_decklist_versions.name',
                                                     'latest_set_id')
                                            ->join('sets', 'sets.id', '=', 'saved_decklists.latest_set_id')
                                            ->join('saved_decklist_versions', 'saved_decklist_versions.saved_decklist_id', '=', 'saved_decklists.id')
                                            ->where('saved_decklist_versions.id', $versionId)
                                            ->first();

        $savedDecklistVersion['meta']->h3_tag = 'Edit Decklist';

        $roles = ['md', 'sb'];

        foreach ($roles as $role) {

            $savedDecklistVersion[$role.'_copies'] = DB::table('saved_decklists')
                                                        ->select('quantity', 
                                                                 'saved_decklist_version_copies.card_id',
                                                                 'role', 
                                                                 'cards.name', 
                                                                 'cmc', 
                                                                 'actual_cmc', 
                                                                 'middle_text',
                                                                 'multiverseid',
                                                                 'rating',
                                                                 'mana_cost')
                                                        ->join('saved_decklist_versions', 'saved_decklist_versions.saved_decklist_id', '=', 'saved_decklists.id')
                                                        ->join('saved_decklist_version_copies', 'saved_decklist_version_copies.saved_decklist_version_id', '=', 'saved_decklist_versions.id')
                                                        ->join('sets_cards', 'sets_cards.card_id', '=', 'saved_decklist_version_copies.card_id')
                                                        ->leftJoin('cards', 'cards.id', '=', 'saved_decklist_version_copies.card_id')
                                                        ->leftJoin('cards_actual_cmcs', 'cards_actual_cmcs.card_id', '=', 'saved_decklist_version_copies.card_id')
                                                        ->leftJoin('cards_ratings', 'cards_ratings.card_id', '=', 'saved_decklist_version_copies.card_id')
                                                        ->where('role', $role)
                                                        ->where('saved_decklist_versions.id', $versionId)
                                                        ->groupBy('sets_cards.card_id')
                                                        ->get();

            foreach ($savedDecklistVersion[$role.'_copies'] as $copy) {
                
                $copy->mana_cost = getManaSymbols($copy->mana_cost);

                if (is_null($copy->actual_cmc)) {

                    $copy->actual_cmc = $copy->cmc;
                }

                if ($copy->multiverseid == '') {

                    $copy->multiverseid = $copy->name;
                }
            }
        }

        $button = [

            'css_class' => 'edit-decklist',
            'anchor_text' => 'Edit Decklist'    
        ];

        # ddAll($savedDecklistVersion);

        return view('saved_decklists/edit', compact('titleTag', 'cardsData', 'actualCmcs', 'lands', 'sets', 'savedDecklistVersion', 'button'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request) {

        $this->storeNewVersion($request, 'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        $savedDecklistVersions = SavedDecklistVersion::where('saved_decklist_id', $id)->get();

        foreach ($savedDecklistVersions as $savedDecklistVersion) {
            
            SavedDecklistVersionCopy::where('saved_decklist_version_id', $savedDecklistVersion->id)->delete();
        }

        SavedDecklistVersion::where('saved_decklist_id', $id)->delete();

        SavedDecklist::where('id', $id)->delete();

        return redirect('saved_decklists');
    }


    /****************************************************************************************
    HELPERS
    ****************************************************************************************/

    public function generateCards() {

        $setsProcessor = new SetsProcessor;

        $sets = $setsProcessor->getSets(2);

        $cardsProcessor = new CardsProcessor;

        list($cardsData, $actualCmcs) = $cardsProcessor->getCardsData();

        $lands = json_encode($cardsProcessor->getLands());

        return array($sets, $cardsData, $actualCmcs, $lands);
    }

    public function storeNewVersion($request, $type) {

        $request = Request::all();
        $input = $request['savedDecklist'];

        # prf($type);
        # ddAll($input);

        /****************************************************************************************
        ****************************************************************************************/

        if ($type == 'store') {

            $savedDecklist = new SavedDecklist;

            $savedDecklist->latest_set_id = $input['latestSetId'];

            $savedDecklist->save();
        }

        /****************************************************************************************
        ****************************************************************************************/        

        if ($type == 'store') {

            $savedDecklistId = $savedDecklist->id;
        }

        if ($type == 'update') {

            $savedDecklistId = $input['id'];
        }

        $savedDecklistVersion = new SavedDecklistVersion;

        $savedDecklistVersion->saved_decklist_id = $savedDecklistId;
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
}
