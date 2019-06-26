@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-primary">
		<div class="panel-heading">
			<b>Add to Petty Cash</b>
			<a href="{{ url('pettycash') }}" class="btn btn-sm btn-success pull-right"> Back </a>
		</div>
		<div class="panel-body">
		<form method="POST" action="{{url('pettycash')}}">
		{{csrf_field()}}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label> Account</label>
					<select class="form-control select2" name="account" required="true">
						<option value="">--select account-- </option>
						@foreach($accounts as $account)
							<option value="{{ $account->AccountLink }}"> {{ $account->Description }} </option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label>Description</label>
					<textarea class="form-control" rows="4" required="true" name="description"></textarea>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label> Reference</label>	
					<input type="text" name="reference" class="form-control" required="true">	
				</div>	
				<div class="form-group">
					<label>Amount</label>
					<input type="number" step="any" min="1" name="amount" class="form-control" required="true">
				</div>
			</div>
			<div class="col-md-4">
			<div class="form-group">
				<label>Currency</label>
				<select class="form-control" name="currency_type" required="true">
					<option value="KSH">KSH</option>
					<option value="USD">USD</option>

				</select>
			</div>

			<div class="form-group">
				<label> Payment Type</label>
				<select class="form-control payment_type" name="payment_type" required="true">
					<
					@foreach($payments as $pay)
						<option value="{{ $pay->iVoucherTypeID }}"> {{ $pay->cVoucherName }} </option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label> Project</label>
				<select class="form-control project-p" name="project_id" required="true">

					@foreach($projects as $proj)
						<option value="{{ $proj->ProjectLink }}"> {{ $proj->ProjectName }} </option>
					@endforeach
				</select>
			</div>
		</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<button class="btn btn-sm btn-success btn-block"> Add</button>
			</div>
		</div>

		</form>
		</div>
	</div>
</div>
@endsection
