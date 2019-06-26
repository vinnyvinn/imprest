@extends('layouts.app')
@section('content')
    <div class="container">`
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Edit User
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('user.update', $user->id) }}" method="post" role="form">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                       value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label for="name">Sage ID</label>
                                <input type="text" class="form-control" id="sageid" name="sage_id"
                                       value="{{ $user->sage_id }}" required="true">
                            </div>
                            <div class="form-group">
                                <label for="department_id">Department</label>
                                <select class="form-control select2" name="department_id">
                                    @if($user->user_id == null)
                                     <option value="" selected disabled>Please select a department</option>
                                     @endif
                                  @foreach($departments as $department)
                                  <option value="{{$department->id}}" {{$user->department_id == $department->id ? 'selected' : ''}}>{{$department->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="name">Re-enter Password</label>
                                <input type="password" class="form-control" id="reenterPassword" name="reenterPassword">
                            </div>
                            <h5>Permissions</h5>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" name="0"{{ in_array(0, $user->permissions) ? ' checked' : '' }}>
                                            Process Imprest
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" name="1"{{ in_array(1, $user->permissions) ? ' checked' : '' }}>
                                            Edit Imprest
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" name="2"{{ in_array(2, $user->permissions) ? ' checked' : '' }}>
                                            Finalize Imprest
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" name="3"{{ in_array(3, $user->permissions) ? ' checked' : '' }}>
                                            Process Surrender
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" name="4"{{ in_array(4, $user->permissions) ? ' checked' : '' }}>
                                            Edit Surrender
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" name="5"{{ in_array(5, $user->permissions) ? ' checked' : '' }}>
                                            Finalize Surrender
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" name="6"{{ in_array(6, $user->permissions) ? ' checked' : '' }}>
                                            View Users
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" name="7"{{ in_array(7, $user->permissions) ? ' checked' : '' }}>
                                            Edit Users
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" name="8"{{ in_array(8, $user->permissions) ? ' checked' : '' }}>
                                            Delete Users
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Save">
                                <a href="{{ route('user.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
