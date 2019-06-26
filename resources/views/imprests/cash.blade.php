@extends('layouts.app')
@section('content')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">  </script>
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
                        <a href="/cash" class="btn btn-warning btn-xs">Back</a> Imprest
                    </div>

                    <form action="{{route('imprest.update-money')}}" method="post" role="form" id="submit">
                        {{ csrf_field() }}

                        <div class="panel-body">
                            <div class="tabbable-custom nav-justified">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#applicant_details" data-toggle="tab"> Imprest
                                            Details</a>
                                    </li>

                                </ul>
                            </div>
                            <br>
                            <div class="tab-content">

                                <div class="tab-pane active" id="applicant_details">
                                    <div class="row">
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label for="imprest_number">Imprest Number</label>

                                                    <select name="imprest_number" id="imprest_no" class="form-control">
                                                        <option value="">Choose Imprest No</option>
                                                            @foreach($imprests as $imprest)
                                                                <option value="{{$imprest->id}}"> {{$imprest->imprest_number}}</option>
                                                            @endforeach
                                                      </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">

                                                <label for="cash_amount">Amount</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                                <input type="number" class="form-control" id="cash_amount" name="return_cash"  placeholder="0:00" required>
                                            </div>
                                        </div>

                                    </div>



                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <button type="toPayments" class="btn btn-success" id="btn-request">Return Cash</button>
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

    {{--<script type="text/javascript">--}}
       {{--$(document).ready(function () {--}}
           {{--{--}}
               {{--$('#cash_amount,#imprest_no').change(function () {--}}
                   {{--var id = $('#imprest_no').val();--}}
                   {{--var url = '{{url('imprest/amount')}}'--}}

                   {{--//console.log(id);--}}
                           {{--$.ajax({--}}
                       {{--type: 'get',--}}
                       {{--url: url + '/' + id,--}}
                        {{--success: function (response) {--}}
                           {{--// $( '#email_status' ).html(response);--}}
                            {{--$('#cash_amount').change(function () {--}}
                                {{--var amount = $('#cash_amount').val();--}}

                                {{--console.log(amount)--}}


                                {{--//if(amount>"OK")--}}
                                {{--// {--}}
                                {{--//     return true;--}}
                                {{--// }--}}
                                {{--console.log(response)--}}
                            {{--})--}}
                       {{--}--}}
                   {{--})--}}
               {{--})--}}
           {{--}--}}
       {{--})--}}

    {{--</script>--}}

@endsection
