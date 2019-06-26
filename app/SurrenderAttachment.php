<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurrenderAttachment extends Model
{
    

	const INITIATED =1;
	const HOD_APPROVED  =2;
	const FINAL_APPROVER =3;

	const HOD_CANCELLED = 4;
	const FINAL_CANCELLED =5;

	protected $fillable = ['imprest_id','description','amount','avatar','status'];


	public function imprest(){

		return $this->belongsTo(Imprest::class);
	}

}
