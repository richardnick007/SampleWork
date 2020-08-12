<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Transaction;
use App\Repositories\Interfaces\FlutterwaveInterface;
use App\Repositories\FlutterwaveRepository;

class TransactionController extends Controller
{
    private $flutterwaveRepository;

    public function __construct(FlutterwaveInterface $FlutterwaveRepository){
        $this->flutterwaveRepository = $FlutterwaveRepository;
        
    }      
    public function transfer(Request $request){
       $transfer= $this->flutterwaveRepository->transfer($request);

       if($transfer){
            return response()->json(Array("message"=>"Transfer Successful"), 200);
       }else{
            return response()->json(Array("message"=>"Transfer Unsuccessful"), 400);
       }

    }
    public function getTransaction(){
        $this->flutterwaveRepository->Transactions();
    }
    public function search($name){
        $this->flutterwaveRepository->search($name);
    }
}
