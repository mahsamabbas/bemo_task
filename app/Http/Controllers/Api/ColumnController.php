<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TrelloResource;
use App\Http\Services\ColumnService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Column;
use App\Http\Requests\StoreColumnRequest;
use App\Http\Requests\UpdateColumnRequest;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return TrelloResource::collection((new ColumnService())->getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreColumnRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreColumnRequest $request)
    {
        $column = (new ColumnService())->store($request);
        $column->cards = [];
        return response()->json([
            "success" => true,
            "msg" => 'Column created successfully',
            "data" => $column
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateColumnRequest  $request
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateColumnRequest $request, $id)
    {
        $column = Column::findOrFail($id);
        $column = (new ColumnService())->update($request, $column);
        return response()->json([
            "success" => true,
            "msg" => 'Column updated successfully',
            "data" => $column
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
