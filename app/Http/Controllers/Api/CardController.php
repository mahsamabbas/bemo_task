<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreColumnRequest;
use App\Http\Requests\UpdateColumnRequest;
use App\Http\Resources\TrelloResource;
use App\Http\Services\CardService;
use App\Http\Services\ColumnService;
use App\Models\Card;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Column;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return TrelloResource::collection((new CardService())->getAll($request));
    }

    public function listCards(Request $request)
    {
        return TrelloResource::collection((new CardService())->getList($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreColumnRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCardRequest $request)
    {
        $card = (new CardService())->store($request);
        return response()->json([
            "success" => true,
            "msg" => 'Card created successfully',
            "data" => $card
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCardRequest $request
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCardRequest $request, $id)
    {
        $card = Card::findOrFail($id);
        $card = (new CardService())->update($request, $card);
        return response()->json([
            "success" => true,
            "msg" => 'Card updated successfully',
            "data" => $card
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $column = Column::findOrFail($id);
        (new ColumnService())->delete($column);
        return response()->json([
            "success" => true,
            "msg" => 'Column deleted successfully',
        ],201);
    }
}
