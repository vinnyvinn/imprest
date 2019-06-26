@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class=" panel-heading">
                    <div class="row">
                    <div class="col-md-3">
                        Departments
                    </div>
                        <div class="col-md-3">
                            <a href="{{url('importdepartments')}}" class="btn btn-success btn-sm btn-center"> Import From HR </a>
                        </div>
                        <div class="col-md-3">
                      <!--   <a href="{{-- url('department/create') --}}" class="btn btn-success btn-xs pull-right">Create Department</a> -->
                        </div>
                    </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped table-hover datatables">
                            <thead>
                                <th>Name</th>
                                <th>dec</th>
                                <th>HOD</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                            @foreach($departments as $department)
                            <tr >
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->desc }}</td>
                                @foreach($users as $user)
                                @if($user->id == $department->user_id)
                                <td>{{$user->name}}</td>
                                @endif
                                @endforeach
                                <td>
                                @if(hasPermission(App\User::PERM_EDIR_USER))
                                    <td><a href="{{ route('department.edit', $department->id) }}" class="btn btn-primary btn-xs">Edit</a>
                                @endif
                                @if(hasPermission(App\User::PERM_DELETE_USER))
                                    <a href="{{ route('department.destroy', $department->id) }}" class="btn btn-danger btn-xs" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this user?" data-token="{{ csrf_token() }}">Delete</a>
                                @endif
                                </td>
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
