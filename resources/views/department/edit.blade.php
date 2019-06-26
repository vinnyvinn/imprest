@extends('layouts.app')
@section('content')
    <div class="container">`
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Edit Department
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('department.update', $department->id)}}" method="post" role="form">
                            {{ csrf_field() }}
                              {{ method_field('PUT') }}

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$department->name}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Description</label>
                                <input type="text" class="form-control" id="desc" name="desc" value="{{$department->desc}}">
                            </div>
                            <div class="form-group">
                                <label for="user_id">H.O.D</label>
                                <select name="user_id" class="form-control select2">
                                  @foreach($users as $user)
                                  <option value="{{$user->id}}"  {{$department->user_id == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Save</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
      @endsection
