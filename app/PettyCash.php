<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    const PENDING= 0;
    const REJECTED= 1;
    const POSITIVE= 2;
    const NEGATE= 3;
   protected $connection="sqlsrv";
   protected $fillable=['reference','batch_id','transaction_type','account','description','amount','approved_at','currency_type','payment_type','project_id'];
}
