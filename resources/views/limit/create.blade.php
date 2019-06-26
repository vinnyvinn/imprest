@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Set new Imprest Limit
			</div>
			<div class="panel-body">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<form method="POST" action="{{route('limit.update',['id'=>$limits->id])}}">
					{{method_field('PATCH')}}
					{{csrf_field()}}
						<div class="form-group">
							<label>Limit Level</label>
							<input type="number" name="imprest_limit" class="form-control" value="{{$limits->imprest_limit}}">
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea name="description" class="form-control">{{$limits->description}}</textarea>
						</div>
						<div class="form-group">
							<button class="btn btn-sm btn-success btn-block"> Update </button>
						</div>
					</form>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
@endsection