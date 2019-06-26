@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">

          @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                     @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                
                </ul>
            </div>
          @endif
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a href="/imprest" class="btn btn-warning btn-xs">Back</a> Imprest
                    </div>

                    <form action="{{route('imprest.store')}}" method="post" role="form" id="submit">
                      {{ csrf_field() }}
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
                                    <div class="col-sm-4">

                                    <div class="form-group">
                                      <label for="imprest_number">Imprest Number</label>
                                      <input type="text" class="form-control" id="imprest_number" name="imprest_number"  value="{{$imprestnum}}" readonly>
                                    </div>
                                  </div>

                                 <div class="col-sm-4">
                                    <div class="form-group">

                                                <label for="advance_amount">Advance Amount</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                                <input type="number" class="form-control advance_amount" id="advance_amount" name="advance_amount" onchange="checkAmount(this)" placeholder="0:00" required>
                                    </div>
                                </div>
                             <div class="col-sm-4">
                                    <div class="form-group">
                                                <label for="advance_amount">Currency</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                                <select class="form-control" name="currency" required="true">
                                                <option value="0"> KSH</option>
                                                  @foreach($currencies as $currency)
                                                    <option value="{{$currency->CurrencyLink}}"> {{$currency->CurrencyCode}}</option>
                                                  @endforeach
                                                </select>
                                    </div>
                                </div>
                             </div>
                                <div class="row">
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="advance_amount">Select Project</label>
                                          <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                          <select class="form-control" name="project_id" required="true">
                                              @foreach($projects as $project)
                                              <option value="{{$project->ProjectLink}}"> {{ $project->ProjectName}}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="advance_amount">Location</label>
                                            <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                            <input type="text" class="form-control" name="location">
                                        </div>
                                    </div>
                                      <div class="col-md-3">
                                          <div id="payment" class="form-group" style="display: none;">
                                              <label for="imprest_type">Payment Type</label><br/>
                                              <select  class="form-<br/> select2" name="imprest_type" id="imprest_type" required="true">
                                                  <option disabled>--Select payment type--</option>
                                                  <option value="1">Cash</option>
                                                  <option value="0">Cheque</option>
                                              </select>
                                          </div>
                                      </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nature_of_duty"> petty cash reason</label>
                                                <textarea class="form-control" cols="50" id="nature_of_duty" name="nature_of_duty" required="true"></textarea>
                                            </div>
                                         </div>
                                     </div>

                                    <div class="row">
                                      <div class="col-md-6">
                                        @if(Auth::user()->role_id == 0)
                                          <label>Select Approving Officer</label>
                                          <select class="form-control" name="officer_id">
                                            <option></option>
                                            @foreach($users as $user)
                                              <option value="{{$user->id}}"> 
                                                {{ $user->name }}
                                              </option>
                                            @endforeach
                                          </select>
                                        @endif
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <button type="toPayments" class="btn btn-success" id="btn-request">Request</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script type="text/javascript">
  $('#btn-request').click(function(e){
          $('#btn-request').prop("disabled",true);
          $('#submit').submit();
  });

</script>

@endsection
