<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubAccountCreator extends Model
{
    

	protected $table = 'Accounts';

	public $timestamps = false;

    protected $fillable =[
    	'Master_Sub_Account',////410000/410009/hrno
    	'AccountLevel', //0
    	'ActiveAccount',//1
    	'Account', //410000/410009/hrno
    	'iAccountType',//2
    	'SubAccOfLink',//emptystring
 		'iGLSegment0ID',//147
 		'iGLSegment1ID', //316
 		'iGLSegment2ID', //master segment number
 		'iGLSegment3ID', //0
 		'iGLSegment4ID', //0
 		'iGLSegment5ID', //0
 		'iGLSegment6ID',//0
 		'iGLSegment7ID',//0
 		'iGLSegment8ID',//0
 		'iGLSegment9ID',//0
    	'ucGLHRNO' //hrno

    	 ];

    public static function makeSubAccount($hrno,$segment_no,$fullnames)
    {
    	$masternumber = '410000/410009/'.$hrno;

    	return self::create([
    	'Master_Sub_Account'=>$masternumber,
    	'AccountLevel'=> 0,
    	'ActiveAccount' => 1,
        'Description' => 'Others/Other Advances/'.$fullnames,
    	'Account' => $masternumber,
    	'iAccountType' => 2,
    	'SubAccOfLink' => '',//emptystring
 		'iGLSegment0ID' => 147,//147
 		'iGLSegment1ID' => 316 , //316
 		'iGLSegment2ID' => $segment_no, //master segment number
 		'iGLSegment3ID' => 0, //0
 		'iGLSegment4ID' => 0, //0
 		'iGLSegment5ID' => 0, //0
 		'iGLSegment6ID' => 0,//0
 		'iGLSegment7ID' => 0,//0
 		'iGLSegment8ID' => 0,//0
 		'iGLSegment9ID' => 0,//0
    	'ucGLHRNO'  => $hrno//hrno
    	]);
    }
}
