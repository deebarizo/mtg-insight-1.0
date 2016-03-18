<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Domain\CardsProcessor;
use App\Domain\SetsProcessor;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $titleTag = 'Cards | ';

        $cardsProcessor = new CardsProcessor;

        list($cardsData, $actualCmcs) = $cardsProcessor->getCardsData();

        return view('cards/index', compact('titleTag', 'cardsData', 'actualCmcs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titleTag = 'Create Card | ';

        $setsProcessor = new SetsProcessor;

        $sets = $setsProcessor->getSets(6);

        return view('cards/create', compact('titleTag', 'sets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $cardsProcessor = new CardsProcessor;

        $cardData = $cardsProcessor->getCardData($id);

        $titleTag = $cardData->name.' | ';

        return view('cards/show', compact('titleTag', 'cardData', 'message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $cardsProcessor = new CardsProcessor;

        $cardData = $cardsProcessor->getCardData($id);

        $titleTag = 'Edit - '.$cardData->name.' | ';

        return view('cards/edit', compact('titleTag', 'cardData', 'message'));
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
        $cardsProcessor = new CardsProcessor;

        $message = $cardsProcessor->updateCard($request, $id);

        if ($message == 'Success!') {

            return redirect()->action('CardsController@show', [$id])->with('message', $message);
        
        } else {

            return redirect()->action('CardsController@edit', [$id])->with('message', $message);
        }
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
