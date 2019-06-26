@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a href="/imprest" class="btn btn-warning btn-xs">Back</a> Imprest
                    </div>
                 </div>
                 <div class="panel panel-body">
                 	<div class="row">
                 		<div class="col-md-6">
                 			<div class="form-group">
                 			<label>Applicant Name</label><br/>
                 			<input type="text" value="{{$imprest->applicant->name}}" class="form-control" readonly="true">
							</div>
							<div class="form-group">
                 			<label>Application Amount</label><br/>
                 			<input type="text" value="{{$imprest->advance_amount}}" class="form-control" readonly="true">
							</div>
                 		</div>
                 		<div class="col-md-6">
                 			<div class="form-group">
                 			<label>Application Date</label><br/>
                 			<input type="text" value="{{$imprest->created_at}}" class="form-control" readonly="true">
							</div> <br/>
							<div class="form-group">
                 			<label>Applicantion Description</label><br/>
                 			<textarea class="form-control" readonly="true">{{$imprest->nature_of_duty}}</textarea>
                 			</div>
                 		</div>
                 	</div>
                 	<div class="row">
						<div class="col-md-12">
							<table class="table table-stripped">
								<thead>
								 <th>Description</th>
                                 <th>Amount</th>
                                 <th>Attachement</th>
                                 <th>Action</th>
                                </thead>
                                 <tbody>
                                @foreach($imprest->surrenderlines as $lines)
                                   <tr>
                                     <td> 
                                      <p>{{$lines->description}}</p>
                                      </td>
                                     <td>
                                         <input type="number" class="form-control" name="amount" value ="{{$lines->amount}}" readonly> 
                                     </td>
                                     <td>

                                        @if($lines->avatar != null)
											<a href="{{ url('images/imprest/'.$lines->avatar) }}"> download </a>
                                        @else
                                        <label>No Attachment</label>
                                		@endif
                                     </td>
                                     <td>
                                     	@if( ($lines->status ==App\SurrenderAttachment::HOD_CANCELLED) || ($lines->status ==App\SurrenderAttachment::FINAL_CANCELLED))
											<label class="label label-info"> cancelled</label>
                                     	@else
											<a href="{{ url('makesurrender/declineItem',['id'=>$lines->id,'imprest_id'=>$imprest->id])}}" class="btn btn-sm btn-danger">Decline</a>
                                     	@endif
                                     </td>
                                   </tr>
                                  @endforeach
                                 </tbody>
                               </table>
						</div>
                 	</div>
                 	<div class="row">
                 		<div class="col-md-6 col-md-offset-3">
							<a class="btn btn-sm btn-success" href="{{ url('makesurrender/approve/'.$imprest->id) }}"> Approve Request</a>
							<a class="btn btn-sm btn-warning" href="{{ url('makesurrender/decline/'.$imprest->id) }}"> Cancle Request</a>
                 		</div>
                 	</div>
                 </div>
            </div>
        </div>
  @endsection
