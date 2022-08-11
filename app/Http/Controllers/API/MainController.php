<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wheel;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function exchange(Request $request) {
        /** @var User $user */
        $user = User::where('id',$request->user_id)->first();

        $exchanged = $request->item_exchanged_id;
        $exchange_into = $request->item_exchanged_into_id;
        $quantity = intval($request->quantity);

        $response = $user->doExchnage($exchanged, $exchange_into, $quantity);

        if(!$response) {
            return response()->json(['error' => 'User doesn\'t have enough quantity of the item being exchanged to do the exchange, or the exchange is forbidden'], 400);
        }

        return response()->json(['success' => 'User successfully exchanged items'], 200);
    }

    public function spinAction(Request $request) {
        /** @var User $user */
        $user = User::where('id',$request->user_id)->first();
        $wheel = Wheel::find($request->wheel_id);
        $user->rewardWheelToUser($wheel);

        return response()->json(['success' => 'success'], 200);
    }
}
