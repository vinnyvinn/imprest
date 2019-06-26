@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<b>Imprest Limit</b>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered datatables">
					<thead>
						<th>Number of imprests</th>
						<th>Description</th>
						<th>Description</th>
					</thead>
					<tbody>
						@foreach($limits as $limit)
							<tr>
								<td>{{ $limit->imprest_limit }}</td>
								<td>{{ $limit->description }}</td> 
								<td><a href="{{url('limit/create')}}" class="btn btn-success btn-sm"> Edit  </a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection