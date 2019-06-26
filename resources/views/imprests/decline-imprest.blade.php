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

                    <form action="{{route('imp-changed')}}" method="post" role="form">
                        {{ csrf_field() }}

                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="requester_id" value="{{$requester_id}}">
                        <div class="panel-body">
                            <div class="tabbable-custom nav-justified">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#applicant_details" data-toggle="tab"> Reason For
                                            Declination</a>
                                    </li>

                                </ul>
                            </div>
                            <br>
                            <div class="tab-content">

                                <div class="tab-pane active" id="applicant_details">
                                    <div class="row">
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label for="imprest_number">Message</label>

                                               <textarea name="reason" id="reason" cols="5" rows="3" class="form-control" required></textarea>
                                                </div>
                                        </div>


                                    </div>



                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-primary" id="btn-request">Submit</button>
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


@endsection
