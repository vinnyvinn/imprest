@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3">
                        Users
                        </div>
                        <div class="col-md-3">
                         <a href="{{ url('importHR') }}" class="btn btn-success btn-xs pull-right">Import from HR</a>
                        </div>
                        <div class="col-md-4">

                      <!--   <a href="{{-- route('user.create') --}}" class="btn btn-success btn-xs pull-right">Import from SAGE</a> -->
                        </div>
                    </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped table-hover datatables">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Sage ID</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr >
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td>
                                  @foreach($departments as $department)

                                  @if($department->id == $user->department_id)
                                  {{ $department->name }}
                                  @endif
                                    @endforeach
                                </td>

                                <td>{{ $user->sage_id }}</td>

                                @if(hasPermission(App\User::PERM_EDIR_USER))
                                    <td><a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-xs">Edit</a>
                                @endif
                                @if(hasPermission(App\User::PERM_DELETE_USER))
                                    <a href="{{ route('user.destroy', $user->id) }}" class="btn btn-danger btn-xs" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this user?" data-token="{{ csrf_token() }}">Delete</a>
                                @endif
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
  
        </div>
    </div>
    @endsection
