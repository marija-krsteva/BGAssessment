<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWheelRequest;
use App\Http\Resources\WheelResource;
use App\Models\Wheel;
use Illuminate\Http\Request;

class WheelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return WheelResource::collection(Wheel::paginate(10));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return WheelResource
     */
    public function store(StoreWheelRequest $request)
    {
        $wheel = Wheel::firstOrCreate(
            [
                'item_id' => $request->item_id,
                'quantity' => $request->quantity
            ]
        );

        return new WheelResource($wheel);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wheel  $wheel
     * @return WheelResource
     */
    public function show(Wheel $wheel)
    {
        return new WheelResource($wheel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wheel  $wheel
     * @return WheelResource
     */
    public function update(Request $request, Wheel $wheel)
    {
        $wheel->update(
            [
                'item_id' => $request->item_id,
                'quantity' => $request->quantity
            ]
        );

        return new WheelResource($wheel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wheel  $wheel
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Wheel $wheel)
    {
        $wheel->delete();

        return response()->json(null, 204);
    }
}
