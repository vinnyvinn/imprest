<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use App\Department;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $departments = Department::all();
      $users =User::where('name','!=','admin')->get();

        return view('users.index')->with('users',$users)->withDepartments($departments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        UserRepository::import();

        flash('Successfully imported users', 'success');

        return redirect()->route('user.index');
    }

    public function importHR(){
        $usr= new User();
        $usr->importFromHR();
        return redirect()->back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $departments = Department::all();
        $user = User::findOrFail($id);
        $user->permissions = json_decode($user->permissions);

        return view('users.edit')->withUser($user)->withDepartments($departments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $permissions = array_filter(array_keys($data), function ($value) {
            return is_numeric($value);
        });

        $data['permissions'] = json_encode(array_values($permissions));
        if (trim($request->password) != "" ) {
            if ($request->password != $request->reenterPassword) {
                flash('The entered passwords do not match', 'error');

                return redirect()->back()->withErrors(
                    [
                        'message' => 'The entered passwords do not match.'
                    ]);
            }

            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user = User::findOrFail($id);
        $user->update($data);

        flash('Successfully edited user details', 'success');

        return redirect()->route('user.index');
    }

   
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        flash('Successfully deleted user', 'success');

        return redirect()->route('user.index');
    }
}
