<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Processed Imprests.
                        <div class="pull-right">
                            <a href="/imprest/create" class="btn btn-xs btn-success">New Imprest</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Imprest Number</th>
                                <th>Imprest Date</th>
                                <th># of Days</th>
                                <th>Name Of Applicant</th>
                                <th>Advance Amount</th>
                                <th>Project Code</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="imprest in imprests">
                                <td><a :href="'/imprest/' + imprest.id ">{{ imprest.imprest_number }}</a></td>
                                <td>{{ (new Date(imprest.created_at)).toDateString() }}</td>
                                <td class="text-right">{{ imprest.number_of_days}}</td>
                                <td>{{ imprest.Name}}</td>
                                <td class="text-right">{{ parseFloat(imprest.advance_amount).toLocaleString() }}</td>
                                <td>{{ imprest.ProjectCode}}</td>
                                <td>
                                    <a :href="'/imprest/' + imprest.id + '/edit'" class="btn btn-success btn-xs">Modify</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.pullImprest();
        },
        data() {
            return {
                imprests: []
            }
        },
        methods: {
            pullImprest() {
                fetch ('/imprest', {
                    headers: {
                        'Accept': 'application/json'
                    }
                }).then((response) => {
                    if (response.ok) {
                        return response.json();
                    }

                    throw new Error('Sorry, try again.');
                }).then(response => {
                    this.imprests = response;
                    console.log(this.imprests);

                });
            }
        }
    }
</script>