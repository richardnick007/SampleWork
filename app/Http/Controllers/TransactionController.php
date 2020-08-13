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
    $this->flutterwaveRepository->transfer($request);
    }
    public function getTransaction(){
        $this->flutterwaveRepository->transactions();
    }
    public function search($name){
        $this->flutterwaveRepository->search($name);
    }
}
