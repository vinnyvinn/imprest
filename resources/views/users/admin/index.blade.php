@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                       Accounts Admin
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                @if($user->role_id==0)
                            <tr >
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                @if(hasPermission(App\User::PERM_DELETE_USER))
                                    <a href="{{ route('useradmin.destroy', $user->id) }}" class="btn btn-danger btn-xs" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this user?" data-token="{{ csrf_token() }}">Delete</a>
                                @endif
                                </td>
                            </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <form method="post" action="{{ url('/useradmin')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Account User</label>
                        <select class="form-control select2" name="account_user">
                            <option value=""> -- select user --</option>
                        @foreach($users as $user)
                            <option value="{{  $user->id }}">{{ $user->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-success btn-block"> Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection