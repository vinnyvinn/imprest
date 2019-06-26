<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Imprest;
use App\Department;
class HrApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $this->validate($request,[
                'amount'=>'required',
                'emp_no'=>'required',
                'description'=>'required'
                ]);

         $dep=User::where('emp_payroll_no',$request->emp_no)->first();
         if(count($dep)<1){
            return response()->json(['message'=>'Employee not found, Advice for an import of employees from inprest first',404]);
         }elseif($dep->sage_id == null){
            return response()->json(['message'=>'Link Staff to Sage, Notify Accounts to do this.',404]);

         }

        $imprestCount = 1;
        if (is_file(public_path('storage/imprestCount'))) {
            $imprestCount = file_get_contents(public_path('storage/imprestCount'));
        }

        $imprestNumber = date('Y/m/d') . '/' . $imprestCount;

        $columns = [
            'DCLink', 'Account', 'Name', env('DEPARTMENT_UDF', 'Physical1'),
            env('DESIGNATION_UDF', 'Physical2'), env('PERSONAL_NUMBER_UDF', 'Physical3')
        ];

        $requiredSettings = [
            'department'      => env('DEPARTMENT_UDF', 'Physical1'),
            'designation'     => env('DESIGNATION_UDF', 'Physical2'),
            'personal_number' => env('PERSONAL_NUMBER_UDF', 'Physical3'),
        ];

        $num = Imprest::count();

        $imprestnum = "IMP".''.$num;

        $officer_id=Department::where('dep_code',$dep->department_id)->first()->user_id;

        $imp = new Imprest();
        $imp->advance_amount=$request['amount'];
        $imp->officer_id=$officer_id;
        $imp->status=Imprest::STATUS_APPROVED;
        $imp->applicant_id=$dep->sage_id;
        $imp->requester_id=$dep->sage_id;
        $imp->nature_of_duty=$request->description;
        $imp->imprest_number=$imprestnum;

        $imp->save();

        if (is_file(public_path('storage/imprestCount'))) {
            $imprestCount = intval(file_get_contents(public_path('storage/imprestCount')));
            $imprestCount += 1;
            file_put_contents(public_path('storage/imprestCount'), $imprestCount);
            return redirect()->route('imprest.index');
        }else if (! is_dir(public_path('storage'))) {
            mkdir(public_path('storage'));
        }
        file_put_contents(public_path('storage/imprestCount'), 2);
        

        return response()->json(['message'=>'Imprest Created successfully','imprestno'=>$imprestnum]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
