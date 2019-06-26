@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a href="role" class="btn btn-warning btn-xs">Back</a> Create User Groups
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="user_group">User Group</label>
                            <input type="text" class="form-control" id="user_group" name="user_group">
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">view</label>
                                    <input type="checkbox" id="" name="" value="none">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Edit</label>
                                    <input type="checkbox" id="" name="" value="All">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Create</label>
                                    <input type="checkbox" id="" name="" value="None">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Finalize</label>
                                    <input type="checkbox" id="" name="" value="None">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Process</label>
                                    <input type="checkbox" id="" name="" value="None">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">view</label>
                                    <input type="checkbox" id="" name="" value="none">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Edit</label>
                                    <input type="checkbox" id="" name="" value="All">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Create</label>
                                    <input type="checkbox" id="" name="" value="None">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Finalize</label>
                                    <input type="checkbox" id="" name="" value="None">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Process</label>
                                    <input type="checkbox" id="" name="" value="None">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection