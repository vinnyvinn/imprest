<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
   
   protected $table='Currency';


   public function conversion(){

   	return $this->hasMany('App\CurrencyHistory','iCurrencyID','iCurrencyID');
   }
}
