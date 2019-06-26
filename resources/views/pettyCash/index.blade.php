@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<b>Petty Cash</b>
				@if(Auth::user()->role_id ==3)
				<a href="{{ route('pettycash.create') }}" class="btn btn-sm btn-success pull-right"> Reimbursement </a>
				@endif
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered datatables">
					<thead>
						<th>Date Created</th>
						<th>Action Date</th>
						<th>Description</th>
						<th>Refrence</th>
						<th>Amount</th>
						<th>Status</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($petty as $cash)
							<tr>
								<td>{{ date('Y-M-d',strtotime($cash->created_at)) }}</td>
								<td>{{ date('Y-M-d',strtotime($cash->updated_at)) }}</td>
								<td>{{ $cash->description }}</td>
								<td>{{ $cash->reference }}</td>
								<td>{{ $cash->amount }}</td>
								<td> 
									@if($cash->transaction_type == App\PettyCash::PENDING)
									 <label class="label label-info"> Pending Approval </label>
									@elseif($cash->transaction_type == App\PettyCash::REJECTED)
									 <label class="label label-danger"> REJECTED </label>
									@elseif($cash->transaction_type == App\PettyCash::POSITIVE)
									 <label class="label label-warning"> Approved </label>
									@endif
								</td>
								<td>
								@if(Auth::user()->role_id ==0)
									@if($cash->transaction_type == App\PettyCashRepo::PENDING)
									<a href="{{ url('pettycash',['id'=>$cash->id])}}" class="btn btn-success btn-sm">Accept</a>
									<a href="{{ url('pettycash/reject',['id'=>$cash->id])}}" class="btn btn-danger btn-sm">Reject</a>
									@endif
								@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
