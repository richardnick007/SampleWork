<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';


    protected $fillable =[
        'account_bank','account_number','amount','narration','currency','reference',
    ];

}
