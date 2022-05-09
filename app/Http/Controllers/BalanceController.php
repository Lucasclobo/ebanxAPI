<?php

namespace App\Http\Controllers;

use App\Accounts;
use Illuminate\Http\Request;

class BalanceController
{
    public function index () {
        return Transactions::all();
    }

    public function get(Request $request) {
        $balance = Accounts::where('account_id', $request->account_id)->first();

        if(is_null($balance)) {
            return response('0', 404);
        }

        return response($balance->balance);
    }
}
