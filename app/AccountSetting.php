<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountSetting extends Model
{
    
    const CASHBOOK=1;
    const PETTYCASH=2;
 	protected $table="account_settings";
    protected $connection="sqlsrv";
    protected $fillable=['iBatchesID','name','description'];

}
