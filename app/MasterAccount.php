<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterAccount extends Model
{
    

    protected $table = '_etblGLSegment';

    protected $connection = 'sqlsrv';

    protected $fillable=['iSegmentNo','cCode','cDescription','imSCOAAccountID','_etblGLSegment_iBranchID'];

    public $timestamps = false;
    
    public static function master($hrno,$fullnames)
    {

    		return 	self::create(
    				[
    					'iSegmentNo'=> 3,
    					'cCode' => $hrno,
    					'cDescription' => $fullnames,
    					'imSCOAAccountID' => 0,
    					'_etblGLSegment_iBranchID' => 0
    				]
    			)->id;

    }
}
