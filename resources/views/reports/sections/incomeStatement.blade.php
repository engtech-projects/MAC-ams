@extends('layouts.app')

@section('content')
    <style type="text/css">
        .title-header {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4ec891;
        }

        .indent-1 {
            padding-left: 20px !important;
        }

        .indent-1-r {
            padding-right: 20px !important;
        }

        .indent-2 {
            padding-left: 40px !important;
        }

        .border-0,
        .border-0 td {
            border: 0;
        }
    </style>

    <!-- Main content -->
    <section class="content" id="app">
        <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
            <div v-if="isLoading" class="loading-overlay">
                <p>Loading... </p>
                <div class="spinner"></div>
            </div>
            <div class="row">

                <?php


                ?>

                <div class="col-md-12 title-header">
                    <h4><b>Income Statement</b></h4>
                </div>
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <div class="box">
                            <div class="form-group">
                                <label class="label-normal">From</label>
                                <div class="input-group">
                                    <input type="date" value="{{ $from }}" name="from"
                                        class="form-control form-control-sm rounded-0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="box">
                            <div class="form-group">
                                <label class="label-normal">To</label>
                                <div class="input-group">
                                    <input type="date" value="{{ $to }}" name="to"
                                        class="form-control form-control-sm rounded-0" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12">
                        <div class="box pt-4">
                            <button @click="genrateIncomeStatement()" class="btn btn-success"></button>

                            <input type="button" class="btn btn-primary " @click="closingPeriodConfirmation()"
                                value="Closing Period">
                        </div>

                    </div>

                </div>


            </div>

            <div class="row justify-content-start">
                <div class="col-md-8">
                    <table class="table table-sm border">
                        <tbody v-for="(type, category) in incomeStatement.accounts" :key="category">
                            <tr>
                                <th class="indent-1" width="50%">@{{ category.toUpperCase() }}</th>
                                <th width="25%"></th>
                                <th width="25%"></th>
                            </tr>
                            <template v-for="(data, group) in type.types">
                                <tr :key="group + '-header'" class="border-0">
                                    <td class="indent-1">@{{ capitalize(data.name) }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr v-for="(value, key) in data.accounts" :key="group + '-' + key" class="border-0">
                                    <td class="indent-2">@{{ capitalize(value.account_name) }}</td>
                                    <td class="text-right">@{{ formatNumber(value.total) }}</td>
                                    <td></td>
                                </tr>

                                <tr class="border-0" :key="group + '-spacer1'">
                                    <td colspan="3">&nbsp;</td>
                                </tr>

                                <tr style="border-style: double;" :key="group + '-total'">
                                    <td class="indent-1">Total @{{ data.name }}</td>
                                    <td></td>
                                    <td class="text-bold text-right indent-1-r">@{{ formatNumber(data.total) }}</td>
                                </tr>

                                <tr :key="group + '-spacer2'">
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                            </template>

                            <tr style="border-style: double;" :key="category + '-total'">
                                <td class="indent-1 text-bold">Total @{{ capitalize(category) }}</td>
                                <td></td>
                                <td class="text-bold text-right indent-1-r">@{{ formatNumber(type.total) }}</td>
                            </tr>

                            <tr :key="category + '-spacer'">
                                <td colspan="3">&nbsp;</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="indent-1" width="50%">@{{ incomeStatement.profit.title }}</th>
                                <th width="25%"></th>
                                <th width="25%" class="text-right indent-1-r">
                                    @{{ formatNumber(incomeStatement.profit.value) }}
                                </th>
                            </tr>
                            <tr>
                                <th class="indent-1">@{{ incomeStatement.income_tax.title }}</th>
                                <th></th>
                                <th class="text-right indent-1-r">@{{ formatNumber(incomeStatement.income_tax.value) }}</th>
                            </tr>
                            <tr>
                                <th colspan="3">&nbsp;</th>
                            </tr>
                            <tr>
                                <th class="indent-1">@{{ incomeStatement.net_income.title }}</th>
                                <th></th>
                                <th class="text-right indent-1-r">@{{ formatNumber(incomeStatement.net_income.value) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="postingPeriodConfirmation" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to close the period for year <strong>@{{ getYearFromDate(from) }}</strong>?</p>
                        <div class="form-group">
                            <label for="journalDate">Journal Date</label>
                            <input type="date" id="journalDate" name = "journalDate" class="form-control"
                                v-model="journalDate" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="closingPeriod()">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="postingPeriodConfirmation" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Confirmation Message (Only shows 'from' year) -->
                        <p>Are you sure you want to close the period for year <strong>@{{ getYearFromDate(from) }}</strong>?</p>

                        <!-- Journal Date Input -->
                        <div class="form-group">
                            <label for="journalDate">Journal Date</label>
                            <input type="date" id="journalDate" name = "journalDate" class="form-control"
                                v-model="journalDate" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="closingPeriod()">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        new Vue({
            el: '#app',
            data: {
                isLoading: false,
                incomeStatement: @json($incomeStatement),
                net_income: @json($incomeStatement['net_income']['value']),
                from: @json($from),
                to: @json($to),
                journalDate: "",
            },
            computed: {
                displayYear() {
                    if (!this.from) return '';
                    return new Date(this.from).getFullYear();
                }

            },
            methods: {
                capitalize(str) {
                    if (!str) return "";
                    return str
                        .toLowerCase()
                        .split(" ")
                        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                        .join(" ");
                },
                formatNumber(value) {
                    if (value == null || value === "") return "0.00";
                    return Number(value).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },
                genrateIncomeStatement: async function() {
                    this.isLoading = true
                    await axios.post('/reports/income-statement/generate', {
                        from: this.from,
                        to: this.to
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                        this.incomeStatement = response.data.data.incomeStatement
                    }).catch(err => {
                        toastr.error(err.response.data.message);

                    }).finally(() => {
                        this.isLoading = false;
                    });
                },
                getYearFromDate(dateString) {
                    if (!dateString) return '';
                    return new Date(dateString).getFullYear();
                },
                updateYearDisplay() {
                    this.$forceUpdate();
                },

                closingPeriodConfirmation: function() {
                    $('#postingPeriodConfirmation').modal('show');
                },
                closingPeriod: function() {
                    this.isLoading = true;
                    var data = {
                        income_statement: this.incomeStatement,
                        net_income: this.net_income,
                        from: this.from,
                        to: this.to,
                        journalDate: this.journalDate,
                    }
                    axios.post('/reports/closing-period', data, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                        $('#postingPeriodConfirmation').modal('hide');
                    }).catch(err => {
                        toastr.error(err.response.data.message);

                    }).finally(() => {
                        this.isLoading = false;
                    });
                },
            },
        })
    </script>
@endsection




@section('footer-scripts')
    @include('scripts.reports.reports')
@endsection
