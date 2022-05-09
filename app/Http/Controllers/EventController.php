<?php

namespace App\Http\Controllers;

use App\Transactions;
use Illuminate\Http\Request;
use App\Services\EventService;

class EventController
{
    private $eventService;
    
    public function __construct (EventService $eventService) {
		$this->eventService = $eventService;
	}

    public function index (Request $request) {

        if ($request->type == 'deposit') {
            return $this->eventService->deposit($request->destination, $request->amount);
        } else if ($request->type == 'withdraw') {
            return $this->eventService->withdraw($request->origin, $request->amount);
        } else if ($request->type == 'transfer') {
            return $this->eventService->transfer($request->origin, $request->destination, $request->amount);
        } else {
            return response('error');
        }
    }
}
