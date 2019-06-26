@extends('layouts.app')
@section('content')
    <div class="container">`
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Create Department
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('department.store')}}" method="post" role="form">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Description</label>
                                <input type="text" class="form-control" id="desc" name="desc">
                            </div>
                            <div class="form-group">
                                <label for="user_id">H.O.D</label>
                                <select name="user_id" class="form-control">
                                  @if($users == null)
                                   <option value="" selected disabled>Please select a department</option>
                                   @endif
                                  @foreach($users as $user)
                                  <option value="{{$user->id}}" >{{$user->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Create</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
      @endsection
