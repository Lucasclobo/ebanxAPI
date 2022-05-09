<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Transactions;
use Illuminate\Http\Request;

class ResetController
{
    public function index () {
        $truncate = Accounts::truncate();
        $truncate = Transactions::truncate();
        return response('OK', 200);
    }
}
