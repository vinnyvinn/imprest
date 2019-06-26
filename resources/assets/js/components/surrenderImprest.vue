<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a href="/surrender" class="btn btn-warning btn-xs">Back</a> Surrender Imprest
                    </div>
                    <form action="/surrender" method="post" role="form">
                        <input type="hidden" name="_token" :value="token">
                        <div class="panel-body">
                            <br>
                            <div class="tabbable-custom nav-justified">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#imprest_details" data-toggle="tab"> Imprest Details</a>
                                    </li>
                                    <li><a href="#expense_details" data-toggle="tab"> Expense Details</a></li>
                                    <li><a href="#payment_details" data-toggle="tab"> Payment Details</a></li>
                                </ul>
                            </div>
                            <br>
                            <div class="tab-content">
                                <div class="tab-pane active" id="imprest_details">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="imprest_number">Imprest Number</label>
                                                <span class="glyphicon glyphicon-asterisk icon-required"></span>
                                                <select class="form-control " id="imprest_number" v-model="selected_imprest">
                                                    <option disabled>--Select Imprest Number--</option>
                                                    <option v-for="imprest in imprests" :value="imprest.imprest_number">{{ imprest.imprest_number}}   -  {{imprest.Name}}</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="applicant_name">Name of Applicant</label>
                                                <input type="text" class="form-control" id="applicant_name"
                                                       name="applicant_id" v-model="imprestData.Name" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label for="document_number">Document Number</label>
                                                <input type="text" class="form-control" id="document_number"
                                                       name="document_number" v-model="imprestData.document_number" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="designation">Designation</label>
                                                <input type="text" class="form-control" id="designation"
                                                       name="designation" v-model="imprestData.designation" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="imprest_date">Imprest Date</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="imprest_date"
                                                           name="imprest_date" v-model="imprestData.imprest_date" readonly>
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="account_number">Account/Vote Number</label>
                                                <input type="text" class="form-control" id="account_number" name="account_id" v-model="imprestData.account_id" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="department">Department</label>
                                                <input type="text" class="form-control" id="department"
                                                       name="department" v-model="imprestData.department" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="due_date">Due Date</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="due_date"
                                                           name="due_date" v-model="imprestData.due_date" readonly>
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="advance_amount">Advance Amount</label>
                                                <input type="text" class="form-control text-right" id="advance_amount"
                                                       name="advance_amount" :value="parseFloat(imprestData.advance_amount).toLocaleString()" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="personal_number">Personal Number</label>
                                                <input type="text" class="form-control" id="personal_number"
                                                       name="personal_number" v-model="imprestData.personal_number" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="project_name">Project Name</label>
                                                <input type="text" class="form-control" id="project_name"
                                                       name="project_id" v-model="imprestData.ProjectCode" readonly>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <a @click="toExpense" class="btn btn-success">Next</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="expense_details">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-2">
                                            <div class="form-group">
                                                <label for="vote_number">Account/Vote Number</label>
                                                <select class="form-control " id="vote_number"
                                                        v-model="selectedAccount">
                                                    <option disabled>--Select Account Number--</option>
                                                    <option v-for="account in accounts"
                                                            :value="account.AccountLink">
                                                        {{ account.Account}} - {{ account.Description }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="expense_amount">Expense Amount</label>
                                                <input type="number" class="form-control" id="expense_amount"
                                                       name="expense_amount" v-model="expense" min="1" v-on:keyup="checkImprest()">
                                            </div>
                                            <div class="form-group">
                                                <label for="reference">Reference/receipt</label>
                                                <input type="number" class="form-control" id="reference_amount"
                                                       name="reference" v-model="reference" min="1" v-on:keyup="checkImprest()">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <br>
                                            <br>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" id="add_to_grid"
                                                        name="add_to_grid" @click="addToGrid"
                                                        v-show="accounted !== undefined" :disabled="disable">Add To Grid
                                                </button>
                                            </div>
                                        </div>
                                            <!--<div class="form-group">-->
                                                <!--<br>-->
                                                <!--<label>-->
                                                    <!--<input type="checkbox" id="excess_payment" name="excess_payment"-->
                                                           <!--v-model="selected_payment">-->
                                                    <!--Excess Payment-->
                                                <!--</label>-->
                                            <!--</div>-->
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <table class="table table-responsive table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Account/Vote Number</th>
                                                    <th>Expense Amount</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="expense in accounted">
                                                    <td>{{ expense.account }}</td>
                                                    <td>{{ expense.amount}}</td>
                                                    <td><a href="#" class="btn btn-danger btn-xs" @click.prevent="removeExpense(expense)">DELETE</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <a @click="toImprest" class="btn btn-warning">Previous</a>
                                                <a @click="toPayments" class="btn btn-success">Next</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="payment_details">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="amount_paid">Total Amount Paid </label>
                                                <input type="text" class="form-control text-right" id="amount_paid"
                                                       name="amount_paid" :value="parseFloat(imprestData.advance_amount).toLocaleString()" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="amount_calculated">Amount Calculated</label>
                                                <input type="text" class="form-control text-right" id="amount_calculated"
                                                       name="amount_calculated" readonly :value="parseFloat(totalCalculated).toLocaleString()">
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="balance_amount">Balance</label>
                                                <input type="text" class="form-control text-right" id="balance_amount"
                                                       name="balance_amount" readonly :value="balanceAmount.toLocaleString()">
                                            </div>
                                            <div class="form-group">
                                                <label for="excess_amount">Excess Amount</label>
                                                <input type="text" class="form-control text-right" id="excess_amount"
                                                       name="excess_amount" readonly :value="excessAmount.toLocaleString()">
                                            </div>
                                        </div>
    <div class="hide">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="cheque_number">Pay Check Number</label>
                                                <input type="number" class="form-control" id="cheque_number"
                                                       name="cheque_number">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="cheque_date">Pay Check Date</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="cheque_date"
                                                           name="cheque_date">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="cheque_amount">Pay Cheque Amount</label>
                                                <input type="number" class="form-control" id="cheque_amount"
                                                       name="cheque_amount">
                                            </div>
                                        </div>
    </div> <!--end hide -->
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="remark">Remarks</label>
                                                <textarea class="form-control" cols="50" id="remark" name="remark"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="action" :value="action">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <a @click="toExpense" class="btn btn-warning">Previous</a>
                                              <!--   <input type="submit" class="btn btn-success" value="Process Surrender"> -->
                                                <input type="submit" class="btn btn-info" @click="action == 'finalize'" value="Finalize Surrender">
                                                <input type="submit" class="btn btn-danger" value="Cancel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="summary" :value="JSON.stringify(imprestData)">
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        mounted() {
            this.loadData();
        },
        data: function () {
            return {
                action: 'save',
                selectedAccount: 1,
                expense: 1,
                reference : "",
                selected_payment: false,
                accounts:[],
                imprests: [],
                selected_imprest: 0,
                accounted: []
            }
        },

        methods: {
            loadData(){
                fetch('/surrenderimprestData', {
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                }).then(response => {
                    this.accounts = response.accounts;
                    console.log(response.imprests);
                    this.imprests = response.imprests;
                });
            },
            toExpense: function () {
                $('.nav-tabs a[href="#expense_details"]').tab('show');
            },
            toImprest: function () {
                $('.nav-tabs a[href="#imprest_details"]').tab('show');
            },
            toPayments: function () {
                $('.nav-tabs a[href="#payment_details"]').tab('show');
            },

            addToGrid: function () {
                let balance=this.balanceAmount;

                let account = this.accounts.filter(account => {
                    if (account.AccountLink == this.selectedAccount) return true;
                })[0];

                this.accounted.push({
                    accountId: this.selectedAccount,
                    account: account.Account + ' - ' + account.Description ,
                    amount: this.expense,
                });

                this.imprestData.accounted = this.accounted;

                this.expense = 1;
            },

            removeExpense: function (expense) {
                this.accounted.splice(this.accounted.indexOf(expense), 1);
                this.imprestData.accounted = this.accounted;
            },
            checkImprest: function(){
                let calculated=+this.totalCalculated;
                var value=+this.expense ;
                let amount=parseFloat(calculated)+parseFloat(value);
                let impAmount= parseFloat(this.imprestData.advance_amount);

                if(impAmount >= amount) {

             console.log(" imprest_advance_amount "+impAmount+"  excessAmount "+ amount);

                  this.disable=false;
                }else{
                    this.disable=true;
                }
              
            }
        },

        computed: {
            token() {
                return window.Laravel.csrfToken;
            },
            balanceAmount() {
                let balance = parseFloat(this.totalCalculated) - parseFloat(this.imprestData.advance_amount);
                if (balance < 0) return 0;

                return balance;
            },

            excessAmount() {
                let balance = parseFloat(this.imprestData.advance_amount) - parseFloat(this.totalCalculated);
                if (balance < 0) return 0;

                return balance;
            },

            totalCalculated() {
                let  total = 0;

                this.accounted.forEach(function (value) {
                    total += parseFloat(value.amount);
                });

                return total;
            },

            imprestData: function() {
                var imp = this.imprests.filter((imprest) => {
                    console.log(imp);
                    return imprest.imprest_number == this.selected_imprest;
                })[0];

                if (! imp) {
                    return {
                        advance_amount: 0,
                        accounted: []
                    };
                }
                imp.imprest_date = new Date(imp.created_at).toLocaleDateString();
                imp.accounted = [];
                return imp;
            }
        }
    }
</script>