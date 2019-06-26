@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                  @if(session('placed'))
                    <div class="panel-heading">
                        <a href="/imprest" class="btn btn-warning btn-xs">Back</a> Imprest 
                    </div>
                  @else
                    <form action="{{route('updateImprest')}}" method="POST" role="form">
                      {{ csrf_field() }}
      <input type="hidden" name="imprest_number" value="{{$imprest->imprest_number}}">
      <input type="hidden" name="id" value="{{$imprest->id}}">
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
                              <div class="tab-pane active" id="applicant_details">
                                <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                          <label for="imprest_number">Imprest Number</label>
                                        <input type="text" class="form-control" id="imprest_number" name="imprest_number"  value="{{$imprest->imprest_number}}" readonly>
                                      </div>
                                    </div>
                                     <div class="col-md-4">
                                        <label for="advance_amount">Advance Amount in ( {{$imprest->money == null ? "Ksh" : $imprest->money->denomination->CurrencyCode }} ) </label>
                                        <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>

                                        @if($imprest->money == null)
                                  <input type="number" class="form-control advance_amount" id="advance_amount"
                                               name="advance_amount" onchange="checkAmount(this)" value="{{$imprest->advance_amount}}" placeholder="0:00" required >
                                        @else
                                        @php( $amount = $imprest->advance_amount)
                                  <input type="number" class="form-control advance_amount" id="advance_amount"
                                               name="advance_amount" onchange="checkAmount(this)" value="{{$amount}}" placeholder="0:00" required>

                                        @endif
                                        
                                    </div>
                                    <div class="col-md-4">
                                        <label for="advance_amount">Project </label>
                                        <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                        <input type="text" class="form-control advance_amount" value="{{$imprest->ProjectName}}"  required readonly="true" >
                                    </div>
                               </div>
                                <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="applicant_name">Name Of Applicant</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                                  <input type="text" name="applicant" value="{{$imprest->Description}}" class="form-control" readonly="true">
                                          
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="nature_of_duty">Nature Of Duty</label>
                                                <textarea class="form-control" cols="50" id="nature_of_duty" name="nature_of_duty" required="true">{{$imprest->nature_of_duty}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-12">
                                      <div class="col-md-3">
                                          <a href="{{ url('print/'.$imprest->id)}}" class="btn btn-sm btn-info">print</a>
                                      </div>
                                        <div class="col-md-8">
                                          <div class="pull-right">
                                            <button  class="btn btn-success amount" type="submit">Approve</button>
                                            <button  class="btn btn-danger"  value="decline" name="decline">Decline</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                 </form>

                  
<div class="modal fade" id="favoritesModal"
     tabindex="-1" role="dialog"
     aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"
          data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"
        id="favoritesModalLabel">Imprest Approval</h4>
    <form method="POST" action="{{route('updateImprest')}}">
        {{csrf_field()}}
        <input type="hidden" name="imprest_number" value="{{$imprest->imprest_number}}">
        <input type="hidden" name="id" value="{{$imprest->id}}">
        <input type="hidden" name="requester_id" value="{{$imprest->requester_id}}">
        <input type="text" class="adv_amount" name="advance_amount" value="{{$imprest->advance_amount}}" >
      </div>
      <div class="modal-body">
            <p>
            Please confirm you would like to approve
            <b><span id="fav-title">{{$imprest->imprest_number}}</span></b>
            worth {{$imprest->advance_amount}}
            </p>
          </div>
          <div class="modal-footer">
            <button type="button"
               class="btn btn-default"
               data-dismiss="modal">Close</button>
            <span class="pull-right"> &nbsp;&nbsp;
              <button type="submit" name="approve" class="btn btn-success">
                Approve
              </button>
            </span>
      </div>
    </form>
    </div>
  </div>
</div>
<div class="modal fade" id="imprestdeclineModal"
     tabindex="-1" role="dialog"
     aria-labelledby="imprestdecline">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"
          data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"
        id="favoritesModalLabel">Imprest Declination</h4>
      </div>
      <div class="modal-body">
        <p>
        Please confirm you would like to decline
        <b><span id="fav-title">{{$imprest->imprest_number}}</span></b>
        worth <span class="showAmount">{{$imprest->advance_amount}}</span> and specify the reason below
        </p>
        <form>
          <div class="form-group">
            <input class="form-control" name="reason" />
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button"
           class="btn btn-default"
           data-dismiss="modal">Close</button>
        <span class="pull-right">
          <button type="button" class="btn btn-danger">
            Decline
          </button>
        </span>
      </div>
    </div>
  </div>
</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
@endsection

