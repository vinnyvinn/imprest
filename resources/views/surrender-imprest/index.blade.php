@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="pull-right">
                            <a href="surrender/create" class="btn btn-success btn-xs">Surrender Imprest</a>
                        </div>
                        Surrendered Imprests
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Imprest Number</th>
                                <th>Name Of Applicant</th>
                                <th>Surrender Imprest Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($surrenderImprests as $surrenderImprest)
                                <tr>
                                    <td>{{ $surrenderImprest->imprest_number }}</td>
                                    <td>{{ $surrenderImprest->Name}}</td>
                                    <td>{{ (\Carbon\Carbon::parse($surrenderImprest->created_at)->format('d-m-Y')) }}</td>
                                    <td><a href="#" class="btn btn-primary btn-xs">View</a></td>
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