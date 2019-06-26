<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('index');
//});
Auth::routes();
Route::get('logout',function(){
    Auth::logout();
    return redirect()->route('home');
});
Route::group(['middleware' => 'auth'], function () {

    Route::get('makesurrender/decline/{id}','ImprestSurrenderController@declineImprest');
    Route::get('makesurrender/approve/{id}','ImprestSurrenderController@approveImprest');
    Route::get('makesurrender/declineItem/{id}/{imprest_id}','ImprestSurrenderController@declineItem');
    Route::get('print/{id}','CreateImprestController@printImprest');
    Route::resource('makesurrender','ImprestSurrenderController');
    Route::get('imprest/unprocessed', 'ImprestController@unprocessed')->name('imprest.unprocessed');
    Route::get('imprest/myunprocessed', 'ImprestController@myunprocessed')->name('imprest.myunprocessed');
    Route::get('imprest/processed', 'ImprestController@processed')->name('imprest.processed');
    Route::get('imprest/surrendered', 'ImprestController@surrendered')->name('imprest.surrendered');
    Route::get('imprest/closed', 'ImprestController@closed')->name('imprest.closed');
    Route::get('imprest/amount/{id}', 'ImprestController@cash_amount')->name('imprest.amount');
    Route::get('imprest/cash-form', 'ImprestController@cashForm')->name('imprest.cash-form');
    Route::get('imprest/reason-form/{id}/{rq}', 'CreateImprestController@Reason')->name('imprest.reason-form');
    Route::post('ImprestChnage', 'CreateImprestController@ImprestChnage')->name('imp-changed');

    Route::post('imprest/update-money', 'ImprestController@updateMoney')->name('imprest.update-money');
    Route::get('imprest/print/{id}', 'ImprestController@printImprest')->name('imprest.print');
    Route::get('pettycash/reject/{id}','PettyCashController@rejectPettyCash');

    Route::post('updateImprest','CreateImprestController@update')->name('updateImprest');
    Route::resource('imprest', 'CreateImprestController');
    Route::resource('surrender', 'SurrenderImprestController');
    Route::resource('role', 'RoleController');
    Route::resource('user', 'UsersController');
    Route::resource('department', 'DepartmentController');
    Route::resource('apimprest','ApproveImprest');
    Route::resource('accountusers','AccountUsersController');
    Route::resource('useradmin','UserAdminController');
    Route::resource('pettycash','PettyCashController');
    Route::resource('accountsettings','AccountSettingController');
    Route::get('accountCreate','AccountUsersController@create');
    Route::get('user/import', 'UsersController@import');
    Route::get('importHR', 'UsersController@importHR');
    Route::get('importdepartments','DepartmentController@importDepartment');
    Route::get('home', function(){
      return redirect()->route('home');
    });
    Route::get('/', 'CreateImprestController@index')->name('home');
    Route::get('surrenderimprestData', 'SurrenderImprestController@surrenderimprestData');
    Route::resource('limit','LimitController');
});
