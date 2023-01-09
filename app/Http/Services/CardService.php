<?php


namespace App\Http\Services;


use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardService
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return collection
     */
    public function getAll($request)
    {
        return $request->user()->columns()->with('cards')->get()->pluck('cards')->flatten();
    }

    public function getList($request)
    {
        $query = '';

        if (!isset($request->status))
            $query = Card::withTrashed();

        else if (isset($request->status) && $request->status == 0)
            $query = Card::onlyTrashed();

        if (!empty($request->date))
            $query = Card::where('created_at', '>=', $request->date.' 00:00:00');


        return $query->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function store($request)
    {
        $order = $this->getAll($request)->where('column_id', $request->column_id)->max('order')+1 ?? 1;
        return Card::create([
            'title' => $request->title,
            'column_id' => $request->column_id,
            'order' => $order
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $column
     * @return \Illuminate\Support\Collection
     */
    public function update($request, $card)
    {
        $card_reset_column_id = false;
        if (!empty($request->title))
            $card->title = $request->title;

        if (!empty($request->order))
            $card->order = $request->order;

        if (!empty($request->description))
            $card->description = $request->description;

        if (!empty($request->column_id)){
            $card_reset_column_id = $card->column_id;
            $card->column_id = $request->column_id;
        }

        $card->save();

        ///
        if (!empty($request->order)){
            $this->syncCardsOrder($request->order, $card);
        }

        if (!empty($request->column_id) && $card_reset_column_id){
            $this->resetUsersCardsOrder($card_reset_column_id);
        }
        return $card;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $column
     * @return \Illuminate\Support\Collection
     */
    public function delete($card)
    {
        $card->delete();
        $this->resetUsersCardsOrder($card->column_id);
    }

    public function syncCardsOrder($order, $card)
    {
        $cards = Card::where('column_id', $card->column_id)
            ->where('order','>=', $order)
            ->where('id','<>', $card->id)
            ->orderBy('order', 'asc')
            ->get();
        foreach ($cards as $card){
            $order++;
            $card->order = $order;
            $card->save();
        }
    }

    public function resetUsersCardsOrder($column_id)
    {
        $cards = Card::where('column_id', $column_id)->get();
        $order = 0;
        foreach ($cards as $card){
            $order++;
            $card->order = $order;
            $card->save();
        }
    }
}
