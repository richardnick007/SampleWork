<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable =[
        'bank_code','account_number','amount','full_name','currency','debit_currency','narration','fee'.'status','requires_approval','is_approved','bank_name',
    ];

}
