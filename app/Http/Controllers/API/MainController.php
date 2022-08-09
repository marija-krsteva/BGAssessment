<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function exchange(Request $request) {
        $user = auth()->user();
        dd($user);
        $exchanged = $request->item_exchanged_id;
        $exchange_into = $request->item_exchanged_into_id;
        $quantity = intval($request->quantity);

        $user->doExchnage($exchanged, $exchange_into, $quantity);

        return response()->json('Success', 204);
    }
}
