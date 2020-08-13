<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Repositories\Interfaces\FlutterwaveInterface;
use App\Transaction;
use Validator;

class FlutterwaveRepository implements FlutterwaveInterface
{
    public function transfer(Request $request){ 

        $rules = [
            'account_bank' => 'required',
            'account_number' => 'required',
            'amount' => 'required',
            'currency' => 'required',
            'narration' => 'required',
            'debit_currency' => 'required',
        ];
        $validation = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        error_reporting(E_ALL);
        ini_set('display_errors',1);
        

        $data = array(
        'account_bank'=> $request->account_bank,
        'account_number' => $request->account_number,      
        'amount'=> $request->amount,
        'currency'=> $request->currency,
        'narration'=> $request->narration,
        'debit_currency'=> 'NGN');

        $SecKey = 'FLWSECK_TEST-43eef95d8fef8979f5560f297a74fc18-X';
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, "https://api.flutterwave.com/v3/transfers");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 200);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "content-type:application/json",
            "Authorization: Bearer FLWSECK_TEST-43eef95d8fef8979f5560f297a74fc18-X"
        ));
        $curl_request = curl_exec($ch);
        if ($curl_request) {
        $result = json_decode($curl_request, true);
            if($result['status']=="success"){
                $data = $result['data'];

                $transaction = new Transaction;
                $transaction->bank_code = $data['bank_code'];
                $transaction->account_number = $data['account_number'];
                $transaction->amount = $data['amount'];
                $transaction->full_name = $data['full_name'];
                $transaction->currency = $data['currency'];
                $transaction->debit_currency = $data['debit_currency'];
                $transaction->narration = $data['narration'];
                $transaction->fee = $data['fee'];
                $transaction->status = $data['status'];
                $transaction->requires_approval = $data['requires_approval'];
                $transaction->is_approved = $data['is_approved'];
                $transaction->bank_name = $data['bank_name'];
                $transaction->save();

            }else{
                return response()->json(Array("message"=>"Transfer Unsuccessful"));
            }
        }else{
            if(curl_error($ch))
            {
            return response()->json(curl_error($ch));
            }
        }
    
        curl_close($ch);
    } 
    public function Transactions(){

        return Transaction::whereUser_id(Auth::user()->id);

    }
    public function search($firstname){
        $transaction = Transaction::find($firstname);
        if(is_null($firstname)){
            return response()->json(["message" => "Record not found!"], 404);
        }
        return response()->json($transaction, 200);
    }
}
