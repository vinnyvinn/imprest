<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImprestLine extends Model
{
    protected $fillable = [
        'imprest_id', 'account_id', 'amount'
    ];
}
