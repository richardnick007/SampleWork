<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable =[
        'customerId','amount','status','currency','email','AccountId','paymentType','transaction_reference'
    ];

}
