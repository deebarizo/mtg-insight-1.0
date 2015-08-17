<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Domain\CardsProcessor;

class CardsController extends Controller
{
    private $format = 'Battle for Zendikar Standard';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cardsProcessor = new CardsProcessor;

        $cardsData = $cardsProcessor->getCardsData();

        $titleTag = 'Cards | ';
        $format = $this->format;

        return view('cards/index', compact('titleTag', 'format', 'cardsData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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

        $titleTag = $cardData->name.' - Cards | ';

        return view('cards/show', compact('titleTag', 'cardData'));
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

        $titleTag = $cardData->name.' - Edit Cards | ';

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

        return redirect()->action('CardsController@edit', [$id])->with('message', $message);
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
