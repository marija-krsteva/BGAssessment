<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExchangeRequest;
use App\Http\Resources\ExchangeResource;
use App\Models\Exchange;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ExchangeResource::collection(Exchange::paginate(10));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreExchangeRequest $request
     * @return ExchangeResource
     */
    public function store(StoreExchangeRequest $request)
    {
        $exchange = Exchange::firstOrCreate([
            'item_exchanged_id'  => $request->item_exchanged_id,
            'item_exchanged_into_id' => $request->item_exchanged_into_id,
            'rate' => $request->rate,
        ]);

        return new ExchangeResource($exchange);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exchange  $exchange
     * @return ExchangeResource
     */
    public function show(Exchange $exchange)
    {
        return new ExchangeResource($exchange);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreExchangeRequest $request
     * @param  \App\Models\Exchange  $exchange
     * @return ExchangeResource
     */
    public function update(StoreExchangeRequest $request, Exchange $exchange)
    {
        $exchange->update([
            'item_exchanged_id'  => $request->item_exchanged_id,
            'item_exchanged_into_id' => $request->item_exchanged_into_id,
            'rate' => $request->rate,
        ]);

        return new ExchangeResource($exchange);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exchange  $exchange
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Exchange $exchange)
    {
        $exchange->delete();

        return response()->json(null, 204);
    }
}
