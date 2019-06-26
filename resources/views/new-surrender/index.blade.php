@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            @if(session('error'))
              <div class="alert alert-danger">
                {{session('error')}}
              </div>
            @endif
            @if(session('warning'))
              <div class="alert alert-warning">
                {{session('warning')}}
              </div>
            @endif
          </div>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a href="/imprest" class="btn btn-warning btn-xs">Back</a> Imprest
                    </div>
                    <form action="{{ url('makesurrender')}}" method="post" role="form" class="dropzone" id="my-awesome-dropzone" enctype="multipart/form-data">
                      {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="tabbable-custom nav-justified">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#applicant_details" data-toggle="tab">Imprest Details
                                        Details</a>
                                    </li>

                                </ul>
                            </div>
                            <br>
                          <div class="tab-content">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Select Imprest</label>
                                  <select class="form-control" name="id" required="true">
                                      <option></option>
                                      @foreach($imprests as $imprest)
                                        <option value="{{$imprest->id}}"> {{$imprest->imprest_number.' - '.$imprest->Description.' -  ('.$imprest->advance_amount.')' }}</option>
                                      @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                             <div class="col-md-12">
                               <table class="table table-striped" id="surrender">
                                <thead>
                                   <th> <button type="button" class="btn btn-sm  addrow"> + </button> <button type="button" class="btn btn-sm removerow"> - </button> </th>
                                   <th>Description</th>
                                   <th>Amount</th>
                                   <th>Attachement</th>
                                </thead>
                                 <tbody>
                                   <tr>
                                    <td>
                                      <input type="checkbox" class="form-control" name="checkbox"> 
                                    </td>
                                     <td> 
                                      <textarea name="description[1][]" class="form-control" required></textarea>
                                      </td>
                                     <td>
                                         <input type="number" class="form-control" name="amount[1][]" required> 
                                     </td>
                                     <td>
                                        <input type="file" name="file[1][]"> 
                                     </td>
                                   </tr>
                                 </tbody>
                               </table>
                             </div>
                            </div>
                            <div class="tab-pane active" id="applicant_details">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <button type="toPayments" class="btn btn-success" onclick="yesOrN()">Surrender</button>
                                        </div>
                                    </div>
                            </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
  <script type="text/javascript">
    
    var index = 2;
    $('.addrow').click(function(){

      var htmlrow='<tr>'+
                    '<td>'+
                      '<input type="checkbox" class="form-control" name="checkbox">'+ 
                    '</td>'+
                     '<td>'+
                      '<textarea name="description['+index+'][]" class="form-control" required></textarea>'+
                      '</td>'+
                      '<td>'+
                         '<input type="number" class="form-control" name="amount['+index+'][]" required>'+
                     '</td>'+
                     '<td>'+
                       '<input type="file" name="file['+index+'][]">'+ 
                     '</td>'+
                   '</tr>';
            index ++;
      $('#surrender tr:last').after(htmlrow);
    });

    $('.removerow').click(function(){
        $('input:checkbox:checked').parents("tr").remove();
    });
function yesOrN() {

    if('');
}
  </script>

@endsection
