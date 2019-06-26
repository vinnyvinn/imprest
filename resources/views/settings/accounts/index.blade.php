@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<b>Sage Accounts Settings</b>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered datatables">
					<thead>
						<th>#</th>
						<th>Name</th>
						<th>Sage ID</th>
						<th>Description</th>
						<th>Action</th>
					</thead>
					<tbody>
					@php($count=1)
					@foreach($accounts as $account)
							<tr>
								<td>{{ $count++ }}</td>
								<td>{{ $account->name }}</td>
								<td>{{ $account->iBatchesID }}</td>
								<td>{{ $account->description }}</td>
								<td>
								<a href="{{ url('accountsettings',['id'=>$account->id]) }}" class="btn btn-success btn-sm"> Edit</a>
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