@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<b>Account Mapping</b>
			</div>
			<div class="panel panel-body">
				<form method="POST" action="{{ url('accountsettings') }}">
					<input type="hidden" name="id" value="{{ $imprestAccount->id }}">
					{{ csrf_field() }}
					<div class="form-group">
						<label> Imprest Account</label>
						<input type="text" name="account_name" class="form-control" value="{{ $imprestAccount->name}}" readonly="true">
					</div>
					<div class="form-group">
						<label> Mapping Account</label>
						<select class="form-control"  name="account">
							@foreach($accounts as $account)
								@if($imprestAccount->iBatchesID == $account->idBatches)
								<option value="{{ $account->idBatches }},{{ $account->cBatchDesc }}" selected>{{ $account->cBatchDesc }}</option>
								@else
								<option value="{{ $account->idBatches }},{{ $account->cBatchDesc }} ">{{ $account->cBatchDesc }}</option>
								@endif
							@endforeach
						</select>
					</div>
					<div class="from-group">
						<button type="submit" class="btn btn-sm btn-success"> update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection