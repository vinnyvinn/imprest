@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a href="/imprest" class="btn btn-warning btn-xs">Back</a> Imprest
                    </div>
                    <form action="{{route('imprest.update',['id'=>$imprest->id])}}" method="post" role="form">
                      {{ csrf_field() }}
                      {{method_field('PATCH')}}
                      <input type="hidden" name="requester_id" value="{{$imprest->requester_id}}">
                        <div class="panel-body">
                            <div class="tabbable-custom nav-justified">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#applicant_details" data-toggle="tab"> Applicant
                                        Details</a>
                                    </li>

                                </ul>
                            </div>
                            <br>
                            <div class="tab-content">
                                <!-- <div class="alert alert-danger">

                                </div> -->
                                <div class="tab-pane active" id="applicant_details">
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                          <label for="imprest_number">Imprest Number</label>
                                        <input type="text" class="form-control" id="imprest_number" name="imprest_number"  value="{{$imprest->imprest_number}}" readonly>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                            <label>Project </label>
                                            <select class="form-control select2" name="project">
                                                @foreach($projects as $project)

                                                <option value="{{ $project->ProjectCode}}" {{($imprest->project_id ==$project->ProjectLink)? "selected":"" }}> {{ $project->ProjectName}}  </option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <b>testing</b>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="applicant_name">Name Of Applicant</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                               <input type="hidden" class="form-control" name="applicant_id" value="{{$imprest->AccountLink}}" >
                                               <input type="hidden" name="id" value="{{ $imprest->id }}">
                                               <input type="text"  class="form-control" name="" value="{{$imprest->Description}}" readonly="true">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                                <label for="advance_amount">Advance Amount  in ( {{$imprest->money == null ? "Ksh" : $imprest->money->denomination->CurrencyCode }} ) </label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>

                                        @if($imprest->money == null)
                                            <input type="number" class="form-control advance_amount" id="advance_amount"
                                                       name="advance_amount"  value="{{$imprest->advance_amount}}" placeholder="0:00" required readonly>
                                        @else
                                            <input type="number" class="form-control advance_amount" id="advance_amount"
                                                       name="advance_amount"  value="{{$imprest->advance_amount }}" placeholder="0:00" required readonly>

                                        @endif

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="nature_of_duty">Nature Of Duties</label>
                                                <textarea class="form-control" cols="50" id="nature_of_duty" name="nature_of_duty" required="true">{{$imprest->nature_of_duty}}</textarea>
                                            </div>
                                          </div>


                                    </div>
                                    <div class="form-group"></div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="col-md-3">
                                              <a href="{{ url('print/'.$imprest->id)}}" class="btn btn-info"> Print </a>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="pull-right">
                                                <button  class="btn btn-success" type="submit" data-toggle="modal" data-target="#favoritesModal" name="approve" value="approve" >Approve</button>
                                                <button  class="btn btn-danger" name="decline" value="decline" data-toggle="modal" data-target="#imprestdeclineModal">Decline</button>
                                            </div>
                                        </div>
                                    </form>
@endsection
