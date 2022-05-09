<?php

namespace App\Services;

use App\Accounts;
use App\Transactions;

class EventService
{
    public function deposit($destination, $amount){

        $account = Accounts::where('account_id', $destination)->first();            

        if(is_null($account)) {

            $account = Accounts::create([
                'account_id' => $destination,
                'name' => 'User ' . $destination,
                'balance' => $amount   
            ]);

            $transaction = Transactions::create(
                [
                    'account_id' => $destination, 
                    'type' => 'deposit', 
                    'destination' => $destination,
                    'amount' => $amount
                ]
            );

            return response()->json([
                'destination' => [
                    "id" => $transaction->account_id,
                    "balance" => $transaction->amount
                ]
            ], 201);

        } else {
            $value = $account->balance + $amount;
            $account = Accounts::where('account_id', $destination)->update(array('balance' => $value));

            $transaction = Transactions::create(
                [
                    'account_id' => $destination, 
                    'type' => 'deposit', 
                    'destination' => $destination,
                    'amount' => $amount
                ]
            );

            return response()->json([
                'destination' => [
                    "id" => $destination,
                    "balance" => $value
                ]
            ], 201);
        }
    }

    public function withdraw($origin, $amount){
        $account = Accounts::where('account_id', $origin)->first();

        if(is_null($account)) {
            return response('0', 404);
        } else {
            $value = ($account->balance - $amount);
            $account = Accounts::where('account_id', $origin)->update(array('balance' => $value));

            $transaction = Transactions::create(
                [
                    'account_id' => $origin, 
                    'type' => 'withdraw',
                    'amount' => $amount
                ]
            );

            return response()->json([
                'origin' => [
                    "id" => $origin,
                    "balance" => $value
                ]
            ], 201);
        }
    }

    public function transfer($origin, $destination, $amount){
        $account_origin = Accounts::where('account_id', $origin)->first();
        $account_destination = Accounts::where('account_id', $destination)->first();

        if(is_null($account_origin)) {
            return response('0', 404);
        } else {

            if(is_null($account_destination)) {
                $account_destination = Accounts::create([
                    'account_id' => $destination,
                    'name' => 'User ' . $destination,
                    'balance' => 0   
                ]);
            }

            $value_origin = ($account_origin->balance - $amount);
            $account_origin = Accounts::where('account_id', $origin)->update(array('balance' => $value_origin));

            $value_destination = ($account_destination->balance + $amount);
            $account_destination = Accounts::where('account_id', $destination)->update(array('balance' => $value_destination));

            $transaction = Transactions::create(
                [
                    'account_id' => $origin, 
                    'type' => 'transfer',
                    'destination' => $destination,
                    'amount' => $amount
                ]
            );

            return response()->json([
                'origin' => [
                    "id" => $origin,
                    "balance" => $value_origin
                ],
                'destination' => [
                    "id" => $destination,
                    "balance" => $value_destination
                ]
            ], 201);
        }
    }
}