@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
<!--             <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Accounts                       
                    </div>
                    <div class="panel-body">
                    <form method="POST" action="{{--url('/accountusers')--}}">
                        {{csrf_field()}}
                        <div class="row form-group">
                            <div class="col-md-5 ">
                                <label>First Name</label>
                                <input type="text" name="fname" class="form-control" required>
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <label>Last Name</label>
                                <input type="text" name="lname" class="form-control" required>
                            </div>
                        </div>
                         <div class="form-group">
                                <label>Employee number</label>
                                <input type="text" name="emp_payroll_no" class="form-control" required>
                        </div>
                        <div class="form-group">
                                <label>Emails</label>
                                <input type="email" name="email" class="form-control" required>
                        </div>
                         <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit"> add</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div> -->
     
        </div>
    </div>
    @endsection
