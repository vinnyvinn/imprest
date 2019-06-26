<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountSetting;
use DB;
class AccountSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountSettings=AccountSetting::get();
        return view('settings.accounts.index',['accounts'=>$accountSettings]);
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
        $account=explode(',', $request->account);
        AccountSetting::where('id',$request->id)->update(['iBatchesID'=>$account[0],'description'=>$account[1]]);
        flash('Account  Mapping updated successfully','success');
        return redirect()->route('accountsettings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $accounts=DB::table('_btblCbBatches')->get(['idBatches','cBatchDesc']);
        $imprestAccount= AccountSetting::findorfail($id);
        return view('settings.accounts.edit',['imprestAccount'=>$imprestAccount,'accounts'=>$accounts]);

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
