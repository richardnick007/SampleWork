<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Transaction;
use App\Respository\transfer;

class TransactionController extends Controller
{
    public function getKey($seckey){
        $hashedkey = md5($seckey);
        $hashedkeylast12 = substr($hashedkey, -12);
      
        $seckeyadjusted = str_replace("FLWSECK-", "", $seckey);
        $seckeyadjustedfirst12 = substr($seckeyadjusted, 0, 12);
      
        $encryptionkey = $seckeyadjustedfirst12.$hashedkeylast12;
        return $encryptionkey;
      
    }

    public function encrypt3Des($data, $key){
        $encData = openssl_encrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA);
        return base64_encode($encData);
    }
    
    // Process Transfer and store to DB
    public function payViaUssd(Request $request){ // set up a function to test card payment.
        try {
            
            if(!$request){
                return response()->json(Array("message"=>"Enter valid information"));
            }
        error_reporting(E_ALL);
        ini_set('display_errors',1);
        
        $data = array(
        'account_bank'=> $request->account_bank,
        'account_number' =>  $request->account_number,      
        'amount'=> $request->amount,
        'narration'=> $request->narration,
        'currency'=> $request->currency,
        'reference'=> $request->reference,
        'callback_url'=> 'https://webhook.site/b3e505b0-fe02-430e-a538-22bbbce8ce0d',
        'debit_currency'=> 'NGN');

        
        $SecKey = 'FLWSECK_TEST-43eef95d8fef8979f5560f297a74fc18-X';
        
        $key = $this->getKey($SecKey); 
        
        $dataReq = json_encode($data);
        
        $post_enc = $this->encrypt3Des( $dataReq, $key );
    
        var_dump($dataReq);
        
        $postdata = array(
         'PBFPubKey' => 'FLWPUBK_TEST-5e407cf07c9d5b4c930bbd7022cabca5-X',
         'client' => $post_enc,
         'alg' => '3DES-24');
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, "https://api.flutterwave.com/v3/transfers");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata)); //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 200);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        
        
        $headers = array('Content-Type: application/json');
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $curl_request = curl_exec($ch);
        
        if ($curl_request) {

            $result = json_decode($curl_request, true);

            //Passing Data to Db..............................

            $result['status'];
            $data = $result['data'];
           
            $transaction = new Transaction;

            $transaction->account_bank = $request->account_bank;
            $transaction->account_number = $request->account_number;
            $transaction->amount = $request->amount;
            $transaction->narration = $request->narration;
            $transaction->currency = $request->currency;
            $transaction->reference = $request->reference;
            $transaction->save();
            // return response()->json(Array("message"=>"Pament successfull completed"));
            return response()->json(Array("message"=>"Please USSD to complete the transaction"));

        }else{
            if(curl_error($ch))
            {
               dd(curl_error($ch));
            }
        }
        
        curl_close($ch);
    } 
    catch (Throwable $e) {
        report($e);

        return response()->json(Array("message"=>"An error occurred"));
    }
}

    public function validatePayment(Request $request){ // set up a function to test card payment.
        
        $postdata = array(
            "PBFPubKey"=> $request->PBFPubKey,
            "transaction_reference"=> $request->transaction_reference, 
            "ussd"=> $request->ussd
        );
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, "https://api.ravepay.co/flwv3-pug/getpaidx/api/validatecharge");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata)); //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 200);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        
        
        $headers = array('Content-Type: application/json');
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $request = curl_exec($ch);
        
        if ($request) {
            $result = json_decode($request, true);
            if($result['status'] == "success"){

                $customer_details = $result['data']['tx']['customer'];
                $email =  $customer_details['email'];
                Transaction::where(['email'=>$email])->update(["status"=>"success"]);
                return response()->json(Array("message"=>"Pament successfull completed"));

                //update the table
            }else{
                return response()->json(Array("message"=>"AN error occure"));
            }
           
        }else{
            if(curl_error($ch))
            {
               dd(curl_error($ch));
            }
        }
        
        curl_close($ch);
    }

// Getting List of transaction for Login User
    public function Transactions(){

        return Transaction::whereUser_id(Auth::user()->id);

    }
// Searching Users Transfer Using email as Parameter
    public function search($fullname){
        $transaction = Transaction::find($fullname);
        if(is_null($fullname)){
            return response()->json('Record not found!', 404);
        }
        return response()->json('', 200);
    }
}
