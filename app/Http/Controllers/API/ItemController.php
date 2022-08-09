<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ItemResource::collection(Item::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreItemRequest $request
     * @return ItemResource
     */
    public function store(StoreItemRequest $request)
    {
        $item = Item::firstOrCreate(['name' => $request->name]);

        return new ItemResource($item);
    }

    /**
     * Display the specified resource.
     *
     * @param Item $item
     * @return ItemResource
     */
    public function show(Item $item)
    {
        return new ItemResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreItemRequest $request
     * @param Item $item
     * @return ItemResource
     */
    public function update(StoreItemRequest $request, Item $item)
    {
        $item->update(['name' => $request->name]);

        return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json(null, 204);
    }
}
