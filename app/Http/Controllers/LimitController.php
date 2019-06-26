<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImprestLimit;
class LimitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
         $limits=ImprestLimit::get();
        return view('limit.index',['limits'=>$limits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $limits=ImprestLimit::first();
        return view('limit.create',['limits'=>$limits]);
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
        $update=ImprestLimit::findorfail($id);
        $update->update(['imprest_limit'=>$request->imprest_limit,'description'=>$request->description]);

        if($update){
            flash('Limit Updated successfuly','success');
            return redirect()->route('limit.index');
        }
          flash('Oops An error occured','danger');
            return redirect()->route('limit.index');
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
