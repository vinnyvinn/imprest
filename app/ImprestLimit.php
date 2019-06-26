<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImprestLimit extends Model
{
   protected  $connection="sqlsrv";
   protected $fillable=['imprest_limit','description'];
}
