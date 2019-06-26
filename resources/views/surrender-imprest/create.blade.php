@extends('layouts.app')
@section('content')
    <div class="container">
        <surrender-imprest></surrender-imprest>
    </div>
@endsection
@section('scripts')
    <script>
        $('#cheque_date').datepicker({
            autoclose:true,
            format: 'd-MM-yyyy'
        });
    </script>
    @endsection