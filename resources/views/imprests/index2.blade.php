@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        {{ $title }} Imprests.
                        @if(hasPermission(App\Role::PERM_PROCESS_IMPREST))
                            <div class="pull-right">
                                @if($title == 'Surrendered')
                                    <a href="{{ url('makesurrender')}}" class="btn btn-xs btn-success">Make Surrender</a>
                                @else
                                    <a href="/imprest/create" class="btn btn-xs btn-success">New Imprest</a>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped table-hover datatables">
                            <thead>
                            <tr>
                                <th>Imprest Number</th>
                                <th>Name Of Applicant</th>
                                @if(Auth::user()->role_id == App\User::SYSTEM_ADMIN_ROLE)
                                    <th>Imprest Level</th>
                                @endif
                                <th>Imprest Date</th>
                                <th>Description</th>
                                <th>Project</th>
                                <th>Advance Amount</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($imprests as $imprest)
                                <tr>
                                    <td><a href="{{ route('imprest.show', $imprest->id) }}">{{ $imprest->imprest_number }}</a></td>
                                    <td>{{ $imprest->Description}}</td>

                                    @if(Auth::user()->role_id == App\User::SYSTEM_ADMIN_ROLE)
                                        <td>
                                            @if($imprest->status == App\Imprest::STATUS_UNPROCESSED)
                                                <label class="label label-success"> HOD level
                                                </label>
                                                {{$imprest->officer->name}}
                                            @elseif($imprest->status == App\Imprest::STATUS_APPROVED && $imprest->advance_amount < 5000)
                                                <label class="label label-success">
                                                    Imprest Admin level
                                                </label>
                                            @elseif($imprest->status == App\Imprest::STATUS_APPROVED && $imprest->advance_amount >= 5000)
                                                <label class="label label-success">
                                                    Finance Level
                                                </label>
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $imprest->created_at->format('d F Y') }}</td>
                                    <td>{{ $imprest->nature_of_duty}}</td>
                                    <td class="text-right">{{ $imprest->ProjectName }}</td>
                                    <td class="text-right">
                                        @if($imprest->money == null)
                                            KSH
                                            {{ number_format($imprest->advance_amount, 2) }} /=
                                        @else
                                            {{$imprest->money->denomination->CurrencyCode}}
                                            {{ $imprest->advance_amount }}
                                        @endif
                                    </td>
                                    <td>
                                    <!-- <a target="_blank" href="{{ route('imprest.print', $imprest->id) }}" class="btn btn-success btn-xs">Print</a> -->
                                        @if($imprest->status == App\Imprest::STATUS_UNPROCESSED && $imprest->applicant_id == Auth::user()->sage_id )
                                            <label class="label label-success"> Pending Approval</label>
                                        @elseif($imprest->status == App\Imprest::STATUS_CANCELLED)
                                            <label class="label label-warning"> DENIED</label>
                                        @elseif($imprest->status == 0 && Auth::user()->role_id==2 && $imprest->applicant_id != Auth::user()->sage_id)

                                            <a href="{{ route('imprest.edit', $imprest->id) }}" class="btn btn-success btn-xs">Action</a>
                                        @elseif($imprest->status == 2 && Auth::user()->role_id==3 && $imprest->applicant_id != Auth::user()->sage_id )

                                            <a href="{{ route('imprest.edit', $imprest->id) }}" class="btn btn-success btn-xs">Action</a>

                                        @elseif( Auth::user()->role_id !=1 && $imprest->status == 2 && (hasPermission(App\User::PERM_EDIT_IMPREST) || hasPermission(App\User::PERM_FINALIZE_IMPREST)) && $imprest->applicant_id != Auth::user()->sage_id)

                                            @if($imprest->status == App\Imprest::STATUS_APPROVED && Auth::user()->role_id == 2 )
                                                <label class="label label-success">Approved</label>
                                            @elseif($imprest->status == App\Imprest::STATUS_CANCELLED && Auth::user()->role_id == 2 )
                                                <label class="label label-danger">Cancelled</label>

                                            @elseif(!$imprest->currency==1)
                                                <a href="{{ route('imprest.edit', $imprest->id) }}" class="btn btn-success btn-xs">Action</a>
                                            @endif

                                        @elseif($imprest->status == 1 && (hasPermission(App\User::PERM_EDIT_SURRENDER_IMPREST) || hasPermission(App\User::PERM_FINALIZE_SURRENDER_IMPREST)) && $imprest->applicant_id != Auth::user()->sage_id)
                                            <a href="{{ route('surrender.edit', $imprest->id) }}" class="btn btn-success btn-xs">Action</a>
                                        @elseif($imprest->status == App\Imprest::STATUS_APPROVED && Auth::user()->role_id ==1)
                                            <label class="label label-success"> Admin pending</label>
                                        @endif
                                        @if($imprest->status == App\Imprest::STATUS_ISSUED )

                                            <label class="label label-success"> issued</label>

                                        @endif

                                        @if($imprest->applicant_id != Auth::user()->sage_id && (($imprest->status == App\Imprest::USER_INITIATED_SURRENDER ) || ($imprest->status == App\Imprest::HOD_APPROVED_SURRENDER )))
                                            <a href="{{ url('makesurrender/'.$imprest->id) }}" class="btn-sm btn-success">Action</a>
                                        @elseif($imprest->applicant_id != Auth::user()->sage_id && (($imprest->status == App\Imprest::USER_INITIATED_SURRENDER)))
                                            <label class="label label-success">Pending Approval</label>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                @if(Auth::user()->role_id=="never show" && $title =='Unprocessed')
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Running Balance
                        </div>
                        <div class="panel-body">
                            @php($balance=0)
                            @foreach($runinngBalances as $runningBalance)
                                @if($runningBalance->transaction_type == App\PettyCash::POSITIVE)
                                    @php($balance +=$runningBalance->amount)
                                @elseif($runningBalance->transaction_type == App\PettyCash::NEGATE)
                                    @php($balance -=$runningBalance->amount)
                                @endif
                            @endforeach
                            {{number_format($balance)}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
@endsection
