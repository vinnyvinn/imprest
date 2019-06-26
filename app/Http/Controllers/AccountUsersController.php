<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class AccountUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $accounts=User::where('role_id','!=',0)->get();
        return view('users.accountUsers',['accUsers'=>$accounts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accusers= User::where('role_id',1)->get();
        return view('users.accountuserscreate',['Accusers'=>$accusers]);
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
                    'account_user'=>'required',
                    ]);

            //         'lname'=>'required',
            //         'email'=>'required',
            //         'username'=>'required',
            //         'password'=>'required|min:6|confirmed',
            //     ]);
            // User::create([
            //     'name'=>$request->username,
            //     'fname'=>$request->fname,
            //     'lname'=>$request->lname,
            //     'email'=>$request->email,
            //     'emp_payroll_no'=> $request->emp_payroll_no,
            //     'password'=>bcrypt($request->password),
            //     'role_id'  => 3,
            //     'permissions' => '[0,1,2,3,4,5]',
            // ]
            // );
            $update=User::where('id',$request->account_user)->update(['permissions'=>'[0,1,2,3,4,5]','role_id'=>3]);
        return redirect()->route('accountusers.index');
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
            User::where('id',$id)->update(['role_id'=>'1','permissions'=>'[0,1]']);

        return redirect()->route('accountusers.index');
    }
}
