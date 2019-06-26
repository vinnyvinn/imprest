<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Department;
use App\Imprest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        $departments = Department::all();

        return view ('department.index',[
          'users' => $users,
          'departments' => $departments
        ]);

    }

    public function importDepartment(){
        $dep= new Department();
        $dep->importDepartments();

        return redirect()->back();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = User::where('role_id', '!=' ,0)->where('role_id', '!=' ,2)->get();
        return view ('department.create',[
          'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $data = $request->all();

       User::where('id', $request->user_id)->update(['role_id' => 2]);

        Department::create($data);
        
        flash('You successfully created a department ', 'success');

        return redirect()->route('department.index');
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
        $users = User::all();
        $department = Department::findOrFail($id);

        return view ('department.edit',[
          'users' => $users,
          'department' => $department
        ]);
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
        $data = $request->all();

        $department = Department::findOrFail($id);
        $oldHod = $department->user_id;
        $department->update($data);
        $user=$request->get('user_id');
        $dep=$department->dep_code;
        $update=DB::connection('sqlsrv')->update("UPDATE users SET role_id=2 , department_id='$dep', permissions ='[2]' WHERE id='$user'"); 

        if($oldHod){
            Imprest::where('officer_id',$oldHod)->update(['officer_id' => $user]);
            }

        flash('You have updated the department', 'success');
        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        flash('Department deleted successfully', 'success');
        return redirect()->route('department.index');
    }
}
