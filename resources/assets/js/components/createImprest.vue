<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a href="/imprest" class="btn btn-warning btn-xs">Back</a> Imprest
                    </div>

                    <form action="/imprest" method="post" role="form">
                        <div class="panel-body">
                            <div class="tabbable-custom nav-justified">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#applicant_details" data-toggle="tab"> Applicant
                                        Details</a>
                                    </li>
                                    <li><a href="#payment_details" data-toggle="tab"> Payment Details</a></li>
                                </ul>
                            </div>
                            <br>
                            <div class="tab-content">
                                <div class="alert alert-danger" v-for="error in errors">
                                    {{ error }}
                                </div>
                                <div class="tab-pane active" id="applicant_details">
                                    <input type="hidden" class="form-control" id="imprest_number" name="imprest_number" v-model="olddata.imprest_number" readonly>
                                    <div class="row">

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="document_number">Document Number</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                                <input type="text" class="form-control" id="document_number" name="document_number" min="0" v-model="olddata.document_number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="applicant_name">Name Of Applicant</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                                <select class="form-control" name="applicant_id" id="applicant_name" v-model="olddata.applicant_id" @change="updateFields">
                                                    <option disabled>--Select Applicant--</option>
                                                    <option v-for="applicant in applicants" :value="applicant.DCLink">{{ applicant.Name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="personal_number">Personal Number</label>
                                                <input type="text" class="form-control" id="personal_number"
                                                       name="personal_number" :value="personalNumber" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="designation">Designation</label>
                                                <input type="text" class="form-control" id="designation"
                                                       name="designation" :value="designation" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="department">Department</label>
                                                <input type="text" class="form-control" id="department"
                                                       name="department" :value="department" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="project_id">Project Code</label>
                                                <select class="form-control" id="project_id" name="project_id" v-model="olddata.project_code">
                                                    <option v-for="project in projects" :value="project.ProjectLink">{{ project.ProjectCode }} - {{ project.ProjectName }}</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="account_number">Account/Vote Number</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                                <select name="account_number" id="account_number" class="form-control" v-model="olddata.account_number" required>
                                                    <option disabled>--Select Account Number--</option>
                                                    <option v-for="account in accounts" :value="account.AccountLink">{{ account.Account }} - {{ account.Description }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label for="advance_amount">Advance Amount</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                                <input type="number" class="form-control" id="advance_amount"
                                                       name="advance_amount" placeholder="0:00" v-model="olddata.advance_amount" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10 ">
                                            <div class="form-group">
                                                <label for="nature_of_duty">Nature Of Duty</label>
                                                <textarea class="form-control" cols="50" id="nature_of_duty" name="nature_of_duty" v-model="olddata.nature_of_duty"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="proposed_itinerary">Proposed Itinerary</label>
                                                <textarea class="form-control" cols="50" id="proposed_itinerary" name="proposed_itinerary" v-model="proposed_itinerary"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="number_of_days">Number Of Days</label>
                                                <input type="number" class="form-control" id="number_of_days" name="number_of_days" min="0" v-model="olddata.number_of_days">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="date_of_issue">Date Of Issue</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker" id="date_of_issue"
                                                           name="date_of_issue" v-model="olddata.date_of_issue" required>
                                                    <span class="input-group-addon">
                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="date_of_issue">Due Date</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required" color='red' aria-hidden="true"></span>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker" id="due_date"
                                                           name="due_date" v-model="olddata.due_date" required>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="officer_in_charge">Officer In Charge</label>
                                                <select name="officer_in_charge" id="officer_in_charge"
                                                        class="form-control" v-model="olddata.officer_in_charge">
                                                    <option disabled>--Select Officer--</option>
                                                    <option v-for="officer in officers" :value="officer.idAgents">{{ officer.cAgentName }} - {{ officer.cFirstName}} {{ officer.cLastName }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <a @click="toPayments" class="btn btn-success">Next</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="payment_details">
                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label for="cheque_number">Pay Cheque Number</label>
                                                <input type="text" class="form-control" id="cheque_number"
                                                       name="cheque_number" v-model="olddata.cheque_number">
                                            </div>
                                            <div class="form-group">
                                                <label for="cheque_date">Pay Cheque Date</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker" id="cheque_date" name="cheque_date" v-model="olddata.cheque_date">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar">
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-sm-4">-->
                                            <!--<div class="form-group">-->
                                                <!--<label for="C.B_Number">C.B Vr Number</label>-->
                                                <!--<input type="text" class="form-control" id="C.B_Number"-->
                                                       <!--name="CB_Number" v-model="olddata.CB_Number">-->
                                            <!--</div>-->
                                            <!--<div class="form-group">-->
                                                <!--<label for="CB_date">C.B V.r Date</label>-->
                                                <!--<div class="input-group">-->
                                                    <!--<input type="text" class="form-control datepicker" id="CB_date" name="CB_date" v-model="olddata.CB_date">-->
                                                    <!--<span class="input-group-addon">-->
                                                        <!--<span class="glyphicon glyphicon-calendar"></span>-->
                                                    <!--</span>-->
                                                <!--</div>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="voucher_number">Department Voucher Number</label>
                                                <input type="text" class="form-control" id="voucher_number"
                                                       name="voucher_number" v-model="olddata.voucher_number">
                                            </div>
                                            <div class="form-group">
                                                <label for="station_name">Station Name</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required"></span>
                                                <input type="text" class="form-control" id="station_name" name="station_name" value="HQs" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label for="remark">Remarks</label>
                                                <textarea class="form-control" cols="50" id="remark" name="remark" v-model="olddata.remark"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="_token" v-model="csrf_token">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <a @click="toApplicant" class="btn btn-warning">Previous</a>
                                            <input type="submit" class="btn btn-success" value="Save">
                                            <a href="/" class="btn btn-danger">Cancel</a>
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
</template>

<script>
    export default {
        mounted: function () {
            this.loadData();
            $('.datepicker').datepicker({
                autoclose:true,
                format: 'd-m-yyyy'
            });
        },
        data:function(){
            return {
                csrf_token: Laravel.csrfToken,
                applicants: [],
                accounts: [],
                officers: [],
                projects: [],
                settings: {},
                personalNumber: '',
                department: '',
                designation: ''
            }

        },

        props: {
            olddata: {
                type: Object,
                default: function() {
                    return {
                        station_name: 'HQs'
                    };
                }
            },

            errors: {
                type: Array,
                default: function() {
                    return [];
                }
            }
        },

        methods: {
            updateFields() {
                var applicant = this.getApplicant();

                this.personalNumber = applicant[this.settings.personal_number];
                this.department = applicant[this.settings.department];
                this.designation = applicant[this.settings.designation];

            },
            getApplicant() {
                if (! this.olddata.applicant_id) return {};

                return this.applicants.filter((applicant) => {
                    return applicant.DCLink == this.olddata.applicant_id;
                })[0];
            },

            loadData() {
                fetch('/imprest/create', {
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        return response.json();
                    }

                    throw new Error('Sorry, try again.');
                }).then(response => {
                    this.applicants = response.applicants;
                    this.accounts = response.accounts;
                    this.officers = response.officers;
                    this.projects = response.projects;
                    this.settings = response.settings;
                    this.olddata.imprest_number = response.imprestNumber;
                });
            },
            toApplicant: function () {
                $('.nav-tabs a[href="#applicant_details"]').tab('show');
            },
            toPayments: function () {
                $('.nav-tabs a[href="#payment_details"]').tab('show');
            }
        }
    }
</script>