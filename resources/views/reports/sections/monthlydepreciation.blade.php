@extends('layouts.app')

@section('content')
    <style type="text/css">
        .frm-header {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4ec891;
        }

        .search-custom {
            display: block;
            position: absolute;
            z-index: 999;
            width: 100%;
            margin: 0px !important;
            color: #3d9970 !;
            font-weight: bold;
            font-size: 14px;
        }

        .dataTables_filter {
            float: right !important;
        }

        .buttons-print,
        .buttons-html5 {
            display: none;
        }
    </style>

    <!-- Main content -->
    <section class="content" id="app">
        <?php $url = env('APP_URL'); ?>
        <h1 v-text='monthlyDepreciationReportType'></h1>
        <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
            <div class="row">
                <div class="col-md-12">
                    <form @submit.prevent="submitForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 frm-header">
                                <h4><b>Monthly Depreciation / Monthly Amortization</b></h4>
                            </div>
                            <div class="row col-md-12">

                                <div class="col-md-12 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_cat_id">Subsidiary Category</label>
                                            <div class="input-group">
                                                <div class='col-md-3'>
                                                    <div class="box">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <select name="sub_cat_id"
                                                                    class="form-control form-control-sm"
                                                                    v-model="filter.sub_cat_id" id="sub_cat_id">
                                                                    <option value="" disabled selected>-Select
                                                                        Category-</option>
                                                                    @foreach ($subsidiary_categories as $sub_category)
                                                                        <option value="{{ $sub_category->sub_cat_id }}">
                                                                            {{ $sub_category->description }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-md-3' v-if="type==''">
                                                    <div class="box">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <select name="branch_id" v-model="filter.branch_id"
                                                                    class="form-control form-control-sm" id="branch">
                                                                    <option value="" disabled selected>-Select Branch-
                                                                    </option>
                                                                    @foreach ($branches as $branch)
                                                                        <option value="{{ $branch->branch_id }}">
                                                                            {{ $branch->branch_code }} -
                                                                            {{ $branch->branch_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class='col-md-3'>
                                                    <div class="box">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="date" id="sub_month" v-model="filter.to"
                                                                    class="form-control form-control-sm rounded-0"
                                                                    name="to" id="sub_date" required>
                                                                <button class='btn btn-success'>Search</button>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-md-3">

                                                    <div class="form-group" style="margin-right:10px;flex:1;">

                                                        <div class="input-group">
                                                            <select v-model="type" name="type" id="type"
                                                                class="form-control form-control-sm rounded-0">
                                                                <option value="">Listing</option>
                                                                <option value="summary">Summary</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>

                    </form>
                </div>
                <div class="col-md-12">

                    <!-- Table -->
                    <section class="content" v-if="type==''">
                        <h1 v-text="type"> </h1>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th>No.</th>
                                            <th>Particular</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Monthly</th>
                                            <th>Amort.</th>
                                            <th>Used</th>
                                            <th>Expensed</th>
                                            <th>Unexpensed</th>
                                            <th>Due Amort</th>
                                            <th>Salvage</th>
                                            <th>Rem.</th>
                                            <th>Inv.</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <tr v-if="subsidiaryAll.length <=0">
                                                <td colspan="15">
                                                    <b>
                                                        <center>No data available in table.</center>
                                                    </b>
                                                </td>
                                            <tr>
                                            <tr v-for="(ps,i) in processSubsidiary"
                                                :class="ps[2] == 'Total' || ps[2] == 'Net Movement' ? 'text-bold' : ''">
                                                <!-- <td><h1 v-text="subsidiaryAll"></h1</td> -->
                                                <td v-for="p,i in ps" v-if="i<=12"
                                                    :class="rowStyleSubsidiaryListing(p, i, ps)"
                                                    :colspan="ps.length == 2 && i == 1 ? 8 : ''">@{{ p }}
                                                </td>

                                                <td v-if="ps[2]"> <!-- Check if journal_no exists -->
                                                    <button class="btn btn-danger btn-xs" @click='deleteSub(ps[13])'>
                                                        <i class="fa fa-trash fa-xs"></i>
                                                    </button>

                                                    <button class="btn btn-warning btn-xs" data-toggle="modal"
                                                        data-target="#createSubsidiaryModal" @click='processEdit(ps)'>
                                                        <i class="fa fa-pen fa-xs text-white"></i>
                                                    </button>
                                                </td>

                                                <td v-if="ps[0] == 'BRANCH TOTAL'">
                                                    <button class="btn btn-primary" @click="post(ps[14])">
                                                        Post
                                                    </button>
                                                    <button class="btn btn-success" data-toggle="modal"
                                                        data-target="#createSubsidiaryModal" @click="add(ps[13][0])">
                                                        Add
                                                    </button>

                                                </td>

                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </section>
                    <!-- /.Table -->

                    <!-- Table -->
                    <section class="content" v-if="type=='summary'">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table style="table-layout: fixed;" id="generalLedgerTbl" class="table">
                                        <thead>
                                            <th>Particular</th>
                                            <th>Amount</th>
                                            <th>Expensed</th>
                                        </thead>
                                        <tbody id="generalLedgerTblContainer">
                                            <tr v-if="subsidiaryAll.length < 1">
                                                <td colspan="7">
                                                    <center>No data available in table.</b>
                                                </td>
                                            </tr>
                                            <tr v-for="(ps,i) in subsidiaryMonthlyDepreciation"
                                                :class="ps[2] == 'Total' || ps[2] == 'Net Movement' ? 'text-bold' : ''">
                                                <td v-if="i<=8" v-for="p,i in ps" :class="rowStyles(ps[0])"
                                                    :colspan="ps.length == 2 && i == 1 ? 8 : ''">@{{ p }}
                                                </td>
                                                <td v-text="ps[2]"></td>

                                            </tr>

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                    </section>
                    <!-- /.Table -->
                </div>
            </div>
        </div>
        <div class="modal fade" v-show="showModal" id="createSubsidiaryModal" tabindex="-1" role="dialog"
            aria-labelledby="createSubsidiaryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"
                            v-text="isEdit ? 'Edit Subsidiary' : 'Add Subsidiary' "></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Particular Name: </label>
                                        <input type="text" v-model="subsidiary.sub_name" class="form-control"
                                            id="sub_name" required>
                                        <input v-if="isEdit" type="hidden" name="_method" value="PUT">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Inventory Number: </label>
                                        <input type="text" v-model="subsidiary.sub_code" class="form-control"
                                            id="sub_code" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">

                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Date Obtained: </label>
                                        <input type="date" v-model="subsidiary.sub_date" class="form-control"
                                            id="sub_code" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Number of Terms: </label>
                                        <input type="text" v-model="subsidiary.sub_no_depre" class="form-control"
                                            id="sub_address" required>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Amount:</label>
                                        <input type="text" v-model="subsidiary.sub_amount" class="form-control"
                                            id="sub_tel" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Monthly Amortization</label>
                                        <input type="text" disabled v-model="monthlyAmort" class="form-control"
                                            id="sub_acct_no" required>
                                    </div>

                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="message-text" class="col-form-label">Monthly Amortization</label>
                                        <input type="text" disabled v-model="amort" class="form-control"
                                            id="sub_acct_no" required>
                                    </div>

                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Salvage:</label>
                                        <input type="number" v-model="subsidiary.sub_salvage" class="form-control"
                                            id="sub_salvage" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Rate Percentage(%)::</label>
                                        <input type="text" v-model="ratePercentage" class="form-control">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button @click="processAction()" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>
    <!-- /.content -->
    <script>
        new Vue({
            el: '#app',
            data: {
                showModal: true,
                reportType: '',
                sub_month: '',
                monthlyAmortization: 0,
                rate_percentage: 0,
                type: '',
                isEdit: false,
                subId: null,
                newSub:null,
                filter: {
                    branch_id: '',
                    subsidiary_id: '',
                    sub_cat_id: '',
                    from: '',
                    to: '',

                    account_id: '',
                    type: ''
                },
                subsidiary: {
                    sub_name: '',
                    sub_code: null,
                    sub_no_amort: 0,
                    sub_amount: 0,
                    sub_no_depre: 0,
                    sub_cat_id: null,
                    sub_per_branch: null,
                    sub_salvage: 0,
                    rate_percentage: 0,
                },
                incomeExpense: {
                    income: [],
                    expense: []
                },
                subsidiaryAll: [],
                balance: 0,
                url: "{{ route('reports.post-monthly-depreciation') }}",
                search: "{{ route('reports.monthly-depreciation-report-search') }}",
            },
            computed: {
                monthlyDepreciationReportType: function() {
                    var branch = this.filter.branch_id;
                    if (this.type == '') {
                        this.filter.branch_id = branch;
                        return this.type
                    } else {
                        if (this.filter.sub_cat_id == '') {
                            alert('select subsidiary category')
                            return false;
                        } else {
                            this.filter.branch_id = '';
                            this.fetchSubAll();
                        }
                    }

                    if (this.filter.sub_cat_id == '') {
                        alert('select subsidiary category')
                        return false;
                    }

                    return this.type
                },
                monthlyAmort: function() {
                    this.monthlyAmortization = this.subsidiary.sub_amount / this.subsidiary.sub_no_depre;
                    if (this.subsidiary.sub_salvage > 0) {
                        this.ratePercentage / this.subsidiary.sub_no_depre;
                    }
                    return isNaN(this.monthlyAmortization) ? 0 : this.monthlyAmortization.toFixed(2);
                },
                amort: function() {
                    var amort = (this.subsidiary.sub_amount - this.subsidiary.rate_percentage) / this.subsidiary
                        .sub_no_depre;
                    return isNaN(amort) ? 0 : amort.toFixed(2);
                    //return isNaN(this.monthlyAmortization) ? 0 : this.monthlyAmortization.toFixed(2);
                },


                ratePercentage: function() {
                    this.subsidiary.rate_percentage = (this.subsidiary.sub_salvage / 100) * this.subsidiary
                        .sub_amount
                    return this.subsidiary.rate_percentage;
                },
                processSubsidiary: function() {
                    var data = {};
                    var rows = [];

                    if (this.subsidiaryAll) {
                        data = this.subsidiaryAll;

                    }
                    var grandTotal = {};
                    var accTotal = {};


                    for (var i in data) {
                        var branches = data[i];
                        let gTotalAmount = 0;
                        let gTotalMonthlyAmort = 0;
                        let gTotalMonthly = 0;
                        let gTotalNoDepre = 0;
                        let gTotalNoAmort = 0;
                        let gTotalAmort = 0;
                        let gTotalUsed = 0;
                        let gTotalExpensed = 0;
                        let gTotalUnexpensed = 0;
                        let gTotalDueAmort = 0;
                        let gTotalSubSalvage = 0;
                        let gTotalRem = 0;
                        let gTotalInv = 0;
                        rows.push([i]);

                        for (var j in branches) {
                            var branch = branches[j];
                            rows.push([j]);
                            var no = 0;
                            let totalAmount = 0;
                            let total_monthly_amort = 0;
                            let total_monthly = 0;
                            let total_no_depre = 0;
                            let total_no_amort = 0;
                            let total_amort = 0;
                            let total_used = 0;
                            let total_expensed = 0;
                            let total_unexpensed = 0;
                            let total_due_amort = 0;
                            let total_sub_salvage = 0;
                            let total_rem = 0;
                            let total_inv = 0;
                            let branchTotal = [];
                            var sub_ids = [];

                            for (var k in branch) {

                                var subsidiary = branch[k];
                                no += 1;
                                if (j == subsidiary.branch) {

                                    sub_ids.push(subsidiary.sub_id)
                                    rows.push([no,
                                        subsidiary.sub_code + '-' + subsidiary.sub_name,
                                        subsidiary.sub_date,
                                        this.formatCurrency(subsidiary.sub_amount),
                                        this.formatCurrency(subsidiary.monthly_amort),
                                        subsidiary.sub_no_depre,
                                        subsidiary.sub_no_amort,
                                        this.formatCurrency(subsidiary.expensed),
                                        this.formatCurrency(subsidiary.unexpensed),
                                        this.formatCurrency(subsidiary.due_amort),
                                        this.formatCurrency(subsidiary.salvage),
                                        this.formatCurrency(subsidiary.rem),
                                        subsidiary.inv,
                                        subsidiary.sub_id,
                                        subsidiary.sub_salvage,
                                        subsidiary.sub_code,
                                        subsidiary.sub_cat_id,
                                        subsidiary.sub_per_branch

                                    ]);

                                    totalAmount += parseFloat(subsidiary.sub_amount),
                                        total_monthly_amort += parseFloat(subsidiary.monthly_amort)
                                    total_no_depre += parseInt(subsidiary.sub_no_depre)
                                    total_no_amort += parseFloat(subsidiary.sub_no_amort)
                                    total_amort += parseFloat(subsidiary.total_amort)
                                    total_used += parseFloat(subsidiary.sub_no_amort)
                                    total_expensed += parseFloat(subsidiary.expensed)
                                    total_unexpensed += parseFloat(subsidiary.unexpensed)
                                    total_due_amort += parseFloat(subsidiary.due_amort)
                                    total_sub_salvage += parseFloat(subsidiary.salvage)
                                    total_rem += parseFloat(subsidiary.rem)
                                    total_inv += parseFloat(subsidiary.inv)

                                }


                            }
                            gTotalAmount+=totalAmount;
                            gTotalMonthly+=total_monthly_amort;
                            gTotalNoDepre+=total_no_depre
                            gTotalNoAmort+=total_no_amort
                            gTotalUsed+=total_used
                            gTotalExpensed+=total_expensed
                            gTotalUnexpensed+=total_unexpensed
                            gTotalDueAmort+=total_due_amort
                            gTotalSubSalvage+=total_sub_salvage
                            gTotalRem+=total_rem
                            gTotalInv+=total_inv
                            var data = {
                                'sub_ids': sub_ids,
                                'total': {
                                    total_amount: totalAmount,
                                    total_monthly_amort: total_monthly_amort,
                                    total_no_depre: total_no_depre,
                                    total_used: total_used,
                                    total_expensed: total_expensed,
                                    total_unexpensed: total_unexpensed,
                                    total_due_amort: total_due_amort,
                                    total_sub_salvage: total_sub_salvage,
                                    total_rem: total_rem,
                                    total_inv: total_inv
                                },
                                'category_id': branch[0].sub_cat_id,
                                'branch_id': branch[0].branch_id,
                                'branch_code': branch[0].branch_code,
                                'as_of': this.filter.to,
                            }
                            rows.push(['BRANCH TOTAL', '', '',
                                this.formatCurrency(totalAmount),
                                this.formatCurrency(gTotalMonthly),
                                this.formatCurrency(total_no_depre),
                                total_used,
                                this.formatCurrency(total_expensed),
                                this.formatCurrency(total_unexpensed),
                                this.formatCurrency(total_due_amort),
                                this.formatCurrency(total_sub_salvage),
                                this.formatCurrency(total_rem),
                                total_inv, branch, data
                            ]);

                        }
                        rows.push(['GRAND TOTAL', '', '',
                                this.formatCurrency(gTotalAmount),
                                this.formatCurrency(gTotalMonthlyAmort),
                                this.formatCurrency(gTotalNoDepre),
                                gTotalUsed,
                                this.formatCurrency(gTotalExpensed),
                                this.formatCurrency(gTotalUnexpensed),
                                this.formatCurrency(gTotalDueAmort),
                                this.formatCurrency(gTotalSubSalvage),
                                this.formatCurrency(gTotalRem),
                                gTotalInv, branch, data
                            ]);
                    }


                    return rows;
                },
                subsidiaryMonthlyDepreciation: function() {
                    var result = this.subsidiaryAll;
                    var rows = [];
                    for (var i in result) {
                        var branch = result[i];
                        let grandTotalAmount = 0;
                        let grandTotalExpensed = 0;
                        for (var j in branch) {
                            var subsidiary = branch[j];
                            let branchTotalExpensed = 0;
                            let branchTotalAmount = 0;
                            for (var k in subsidiary) {
                                branchTotalExpensed += parseFloat(subsidiary[k].expensed);
                                branchTotalAmount += parseFloat(subsidiary[k].sub_amount);
                            }
                            var result = [
                                j,
                                this.formatCurrency(branchTotalAmount.toFixed(2)),
                                this.formatCurrency(branchTotalExpensed.toFixed(2))
                            ]
                            rows.push(result);
                            grandTotalAmount += branchTotalAmount;
                            grandTotalExpensed += branchTotalExpensed;
                        }
                        var result = [
                            'Grand Total',
                            this.formatCurrency(grandTotalAmount.toFixed(2)),
                            this.formatCurrency(grandTotalExpensed.toFixed(2))
                        ];

                        rows.push(result);
                    }
                    return rows;

                }
            },
            methods: {
                formatCurrency: function(number) {
                    const formatter = new Intl.NumberFormat('en-US', {
                        style: 'decimal',
                        minimumFractionDigits: 2,
                    });

                    return formatter.format(number);
                },
                rowStyles: function(element) {
                    var style = '';
                    if (element === 'Grand Total') {
                        style += 'text-bold';
                    }
                    return style;
                },
                rowStyleSubsidiaryListing: function(p, i, r) {
                    var style = '';
                    if (i >= 6) {
                        style += 'text-right';
                    }
                    if (i == 0) {
                        style += ' text-bold';
                    }
                    return style;
                },
                submitForm: function() {
                    this.fetchSubAll();
                },

                getDate: function() {
                    const d = new Date();
                    const month = d.getMonth() + 1;
                    const year = d.getFullYear();

                    const current_month = month + "-" + year
                    this.sub_month = current_month;
                    var gfg =
                        document.getElementById(
                            "sub_month").defaultValue;
                    return current_month;
                },
                post: function(data) {
                    axios.post(this.url, data, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                        this.newSub = response.data.data;
                        window.reload();
                    }).catch(err => {
                        console.error(err)
                    })
                },
                add: function(subsidiary) {
                    this.subsidiary.sub_cat_id = subsidiary.sub_cat_id
                    this.subsidiary.sub_per_branch = subsidiary.sub_per_branch
                },
                processAction: function() {
                    if (!this.isEdit) {
                        this.createSubsidiary();
                    } else {
                        this.editSubsidiary(this.subId);
                    }
                },
                processEdit: function(sub) {
                    this.isEdit = true;
                    this.subId = sub[13];
                    this.monthlyAmortization = sub[4];
                    this.subsidiary.sub_date = sub[2];
                    this.subsidiary.sub_cat_id = sub[16];
                    this.subsidiary.sub_per_branch = sub[17];
                    this.subsidiary.sub_name = sub[1];
                    this.subsidiary.sub_code = sub[15];
                    this.subsidiary.sub_no_amort = sub[3];
                    this.subsidiary.sub_amount = parseInt(sub[4]);
                    this.subsidiary.sub_salvage = parseInt(sub[14]);
                    this.subsidiary.sub_rate_percentage = sub[6];
                    this.subsidiary.sub_date_of_depreciation = sub[7];
                    this.subsidiary.sub_no_depre = sub[5];

                },
                createSubsidiary: function() {
                    this.isEdit = false;
                    this.subsidiary.sub_no_amort = 0;
                    axios.post('/MAC-ams/subsidiary', this.subsidiary, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                        this.subsidiary = {};
                    }).catch(err => {
                        var errors = err.response.data.errors;
                        var messages = [];
                        for (var i in errors) {
                            var error = errors[i];
                            for (var j in error) {
                                var message = error[j];
                                messages.push(message + '<br />');
                            }
                        }
                        toastr.error(messages);
                    })
                },
                editSubsidiary: function(subId) {
                    this.isEdit = true;
                    this.subsidiary.sub_no_amort = 0;
                    axios.post('/MAC-ams/subsidiary/'+subId, this.subsidiary, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                        this.subsidiary = {};
                    }).catch(err => {
                        var errors = err.response.data.errors;

                        var messages = [];
                        for (var i in errors) {
                            var error = errors[i];
                            for (var j in error) {
                                var message = error[j];
                                messages.push(message + '<br />');
                            }
                        }
                        toastr.error(messages);
                    })
                },
                deleteSub: function(data) {
                    var url = @json(env('APP_URL'));
                    axios.delete('/MAC-ams/subsidiary/' + data, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                    }).catch(err => {
                        toastr.success(err);
                    })
                },

                fetchSubAll: function() {
                    this.filter.type = this.reportType;
                    axios.post(this.search, this.filter, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => {
                            this.subsidiaryAll = response.data.data;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                },

            },

        });
    </script>
@endsection


@section('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
    @include('scripts.reports.reports')
@endsection
