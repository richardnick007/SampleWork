<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Paystack;
use App\User;
use App\Transaction;

class PaymentController extends Controller
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

    public function payviacard(Request $request){ // set up a function to test card payment.

        error_reporting(E_ALL);
        ini_set('display_errors',1);
        
        $data = array('PBFPubKey' => 'FLWPUBK_TEST-5e407cf07c9d5b4c930bbd7022cabca5-X',
        'cardno' => $request->cardno,
        'currency' =>  $request->currency,
        'country' =>  $request->country,
        'cvv' =>  $request->cvv,
        'amount' =>  $request->amount,
        'expiryyear' => $request->expiryyear,
        'expirymonth' =>  $request->expirymonth,
        'suggested_auth' =>$request->suggested_auth,
        'pin' => $request->pin,
        'email' => $request->email,
        'phonenumber' =>  $request->phonenumber,
    
        'txRef' => 'MXX-ASC-4578');
        
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
        
        curl_setopt($ch, CURLOPT_URL, "https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/charge");
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

            $transaction->customerId = $data['customerId'];
            $transaction->amount = $request->amount;
            $transaction->status = $data['status'];
            $transaction->currency = $request->currency;
            $transaction->email = $request->email;
            $transaction->AccountId = $data['AccountId'];
            $transaction->paymentType = $data['paymentType'];
            $transaction->transaction_reference = $data['flwRef'];
            $transaction->save();
            
            return response()->json(Array("message"=>"Please check our phone and verif to the OTP to complete the patment", "transaction_refrence"=>$data['flwRef']));

        }else{
            if(curl_error($ch))
            {
               dd(curl_error($ch));
            }
        }
        
        curl_close($ch);
    }
    
    public function validatePayment(Request $request){ // set up a function to test card payment.
        
        $postdata = array(
            "PBFPubKey"=> $request->PBFPubKey,
            "transaction_reference"=> $request->transaction_reference, 
            "otp"=> $request->otp
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
    public function getTransactions(){

        return Transaction::whereUser_id(Auth::user()->id);

    }
// Searching Users Transfer Using email as Parameter
    public function searchTransactions($email){

        return Transaction::where(['email'=>$email])->get();

    }
   
}
