<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $fillable = [
        'name', 'desc', 'user_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public  function importDepartments(){
    	$existing=Department::get(['dep_code'])->toArray();
    	$flattenned=array_flatten($existing);
    	$data=collect(DB::connection('hr')->select('SELECT * FROM tblsubDepartment')
    	)->map(function($departments) use ($flattenned){
    		if(!in_array($departments->SubDepartment_Id,$flattenned)){
    			return $departments;
    		}
    	});
    	foreach ($data as $key => $value) {
    		if(!isset($value)){
    			unset($data[$key]);
    		}
    	}
    	foreach($data as $d_data){
	    	$newDep=new Department();
	    	$newDep->name=$d_data->SubDepartment_Name;
	    	$newDep->dep_code=$d_data->SubDepartment_Id;
	    	$newDep->desc=$d_data->SubDepartment_Name;
	    	$newDep->save();
    	}
    	return true;
    }

  }
