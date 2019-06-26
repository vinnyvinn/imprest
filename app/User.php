<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\MasterAccount;
use App\SubAccountCreator;

class User extends Authenticatable
{
    use Notifiable;

    const PERM_PROCESS_IMPREST = 0;
    const PERM_EDIT_IMPREST = 1;
    const PERM_FINALIZE_IMPREST =2;
    const PERM_PROCESS_SURRENDER_IMPREST = 3;
    const PERM_EDIT_SURRENDER_IMPREST = 4;
    const PERM_FINALIZE_SURRENDER_IMPREST = 5;
    const PERM_VIEW_USER = 6;
    const PERM_EDIR_USER = 7;
    const PERM_DELETE_USER = 8;
    const PERM_VIEW_DEPARTMENT = 9;
    const PERM_EDIT_DEPARTMENT = 10;
    const PERM_DELETE_DEPARTMENT = 11;

    // reserved system admin role after changes
    const SYSTEM_ADMIN_ROLE=1000;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'fname', 'lname', 'email', 'department_id','role_id', 'sage_id','password', 'permissions','emp_payroll_no','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
       return $this->belongsTo(User::class);
    }
    public function department()
      {
        return  $this->belongsTo('App\Department','dep_code','department_id');

    }
    public function importFromHR(){

        $existing = User::get(['email'])->toArray();

        $flattenned = array_filter(array_flatten($existing));

        $columns = ['Emp_Name','Emp_First_Name','Emp_Payroll_No','Emp_Middle_Name','Emp_SubDepartment_Id','Emp_WorkEmail'];

        DB::connection('hr')
            ->table('tblEmployee')
            ->join('tblEmployee_Contact', 'tblEmployee_Contact.Emp_id', '=', 'tblEmployee.Emp_id')
            ->join('tblEmployeeCustomDetail', 'tblEmployeeCustomDetail.Emp_id', '=', 'tblEmployee.Emp_id')
            ->where('Is_Active',1)
            ->select($columns)
            ->chunk(100, function ($employees) use ($flattenned) {
                $employees = $this->filterEmployees($employees, $flattenned);
                $this->importEmployees($employees);
            });
    }

    protected function filterEmployees($employees, $existing)
    {
        return $employees->reject(function($employee) use ($existing){

            if(!in_array($employee->Emp_WorkEmail, $existing)){
                return false;
            }
            return true;

        });
    }

    protected function importEmployees($employees)
    {
        foreach($employees as $employee){
//          $userID=DB::connection('sqlsrv')->select("SELECT AccountLink FROM Accounts  WHERE ucGLHRNO='$employee->Emp_Payroll_No'");
            $userID=DB::connection('sqlsrv')->select("SELECT AccountLink FROM Accounts");
          if(count($userID)>0){ //only import employees who are created as clients in sage(sorry for commenting here)
             User::insert([
                'name' => ucwords(strtolower($employee->Emp_Name)),
                'fname' => ucwords(strtolower($employee->Emp_First_Name)),
                'lname' => ucwords(strtolower($employee->Emp_Middle_Name)),
                'email' => $employee->Emp_WorkEmail,
                'emp_payroll_no' => $employee->Emp_Payroll_No,
                'department_id' => $employee->Emp_SubDepartment_Id,
                'permissions' => '[0,1]',
                'sage_id' => 19,
                'role_id' => 1,
                'password' => bcrypt("123456"),
                ]);
            }else{
           //$accountId = MasterAccount::master($employee->Emp_Payroll_No,$employee->Emp_Name);
           //$sagelink = SubAccountCreator::makeSubAccount($employee->Emp_Payroll_No,$accountId,$employee->Emp_Name);
            User::insert([
            'name' => ucwords(strtolower($employee->Emp_Name)),
            'fname' => ucwords(strtolower($employee->Emp_First_Name)),
            'lname' => ucwords(strtolower($employee->Emp_Middle_Name)),
            'email' => $employee->Emp_WorkEmail,
            'emp_payroll_no' => $employee->Emp_Payroll_No,
            'department_id' => $employee->Emp_SubDepartment_Id,
            'permissions' => '[0,1]',
            'sage_id' => 19,
            'role_id' => 1,
            'password' => bcrypt("123456"),
            ]);
            }
        }
    }
}
