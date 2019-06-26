<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyHistory extends Model
{
        protected $table = 'CurrencyHist';


   public function denomination(){
   	return $this->belongsTo('App\Currency','iCurrencyID','CurrencyLink');
   }
}
