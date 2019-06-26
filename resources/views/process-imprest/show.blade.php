@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                            <a href="/imprest" class="btn btn-warning btn-xs">Back</a> Imprest
                    </div>
                    {{--{{dd($imprest)}}--}}
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12"><h4>STATUS: {{ $imprest->status == 0 ? 'UNPROCESSED' : ($imprest->status == 1 ? 'PROCESSED' : ($imprest->status == 2 ? 'SURRENDERED' : 'CLOSED')) }}</h4></div>
                        </div>
                        <div class="row">
                            <br>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="document_number">Imprest Date</label>
                                    <div>{{ $imprest->created_at->format('d F Y') }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group required">
                                    <label for="imprest_number">Imprest Number</label>
                                    <div>{{ $imprest->imprest_number }}</div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="border-bottom: 1px solid #e5e5e5"></div>
                        </div>
                        <div class="row">
                            <br>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="applicant_name">Name Of Applicant</label>
                                    <div>{{ $imprest->Description}}</div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="border-bottom: 1px solid #e5e5e5"></div>
                        </div>
                        <div class="row">
                            <br>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="personal_number">Personal Number</label>
                                    <div>{{ $imprest->emp_payroll_no }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="department">Department</label>
                                    <div>{{ $imprest->name }}</div>
                                </div>
                            </div>
                               <div class="col-md-4">
                                <div class="form-group">
                                    <label for="project_id">Project</label>
                                    <div>{{ $imprest->ProjectCode }}</div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="border-bottom: 1px solid #e5e5e5"></div>
                        </div>
                        <div class="row">
                            <br>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nature_of_duty">Nature Of Duty</label>
                                    <div>{{ $imprest->nature_of_duty }}</div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="border-bottom: 1px solid #e5e5e5"></div>
                        </div>
<!--                         <div class="row">
                            <br>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="proposed_itinerary" pattern="([a-zA-Z]+$)">Proposed
                                        Itinerary</label>
                                    <div>{{-- $imprest->proposed_itinerary --}}</div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="border-bottom: 1px solid #e5e5e5"></div>
                        </div> -->
                        <div class="row">
                            <br>
                            <div class="col-sm-4">
                                <label for="advance_amount">Advance Amount</label>
                                <div>{{ number_format($imprest->advance_amount, 2) }}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="date_of_issue">Date Of Issue</label>
                                    <div>{{ Carbon\Carbon::parse($imprest->date_of_issue)->format('d F Y') }}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <div>{{ $imprest->location}}</div>
                                </div>
                            </div>
   <!--                          <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="number_of_days">Number Of Days</label>
                                    <div>{{-- $imprest->number_of_days --}}</div>
                                </div>
                            </div -->>
                            <div class="col-sm-12" style="border-bottom: 1px solid #e5e5e5"></div>
                        </div>
                        <div class="row">
                            <br>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <!-- <label for="officer_in_charge">Officer In Charge</label> -->
                                    <div>{{-- $imprest->cAgentName --}}</div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="border-bottom: 1px solid #e5e5e5"></div>
                        </div>
<!--                         <div class="row">
                            <br>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="cheque_number">Pay Cheque Number</label>
                                    <div>{{-- $imprest->cheque_number --}}</div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="voucher_number">Department Voucher Number</label>
                                    <div>{{ $imprest->voucher_number }}</div>
                                </div>
                            </div>
                        </div> -->
 <!--                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="cheque_date">Pay Cheque Date</label>
                                    <div>{{-- Carbon\Carbon::parse($imprest->cheque_date)->format('d F Y') --}}</div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="station_name">Station Name</label>
                                    <div>{{-- $imprest->station_name --}}</div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="border-bottom: 1px solid #e5e5e5"></div>
                        </div> -->
                        <div class="row">
                            <br>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label for="remark">Remarks</label>
                                    <div>{{ $imprest->remark }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="pull-right">
                                <a href="{{ URL::previous() }}" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    toApplicant: function () {
        $('.nav-tabs a[href="#applicant_details"]').tab('show');
    }
    toPayments: function () {
        $('.nav-tabs a[href="#payment_details"]').tab('show');
    }

</script>
