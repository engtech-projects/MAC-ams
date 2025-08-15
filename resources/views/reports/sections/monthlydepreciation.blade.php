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
        <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
            <div class="row">
                <div class="col-md-12">
                    <form @submit.prevent="submitForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 frm-header">
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
                                                                <select v-model="filter.category" required
                                                                    class="form-control form-control-sm" id="branch">
                                                                    <option :value="null" disabled selected
                                                                        class="text-uppercase">
                                                                        SELECT CATEGORY
                                                                    </option>
                                                                    <option v-for="sub_cat in sub_categories"
                                                                        v-bind:value="{ sub_cat_id: sub_cat.sub_cat_id,sub_cat_name: sub_cat.description }">
                                                                        @{{ sub_cat.description }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-md-3' v-if="type==''">
                                                    <div class="box">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <select v-model="filter.branch" @change="onSearch()"
                                                                    class="form-control form-control-sm" id="branch">
                                                                    <option :value="null" disabled selected>SELECT
                                                                        BRANCH
                                                                    </option>
                                                                    <option v-for="branch in branches"
                                                                        v-bind:value="{ branch_id: branch.branch_id,branch_code: branch.branch_code, branch_name:branch.branch_name,   branch_alias:`${branch.branch_code}-${branch.branch_name}` }">
                                                                        @{{ branch.branch_code + '-' + branch.branch_name }}
                                                                    </option>
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
                                                                <button class='btn btn-success'
                                                                    style="margin-left:15px;">Search</button>
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
                                            <th>Used
                                            </th>
                                            <th
                                                v-text="filter.category?.sub_cat_name === 'Additional Prepaid Expense' ? 'Prepaid Expense' : 'Expensed' ">
                                            </th>
                                            <th>Unexpensed</th>
                                            <th>Due Amort</th>
                                            <th>Salvage</th>
                                            <th>Rem.</th>
                                            <th>Inv.</th>
                                            <th v-show="filter.branch && searching">Action</th>
                                        </thead>
                                        <tbody>

                                            <tr v-for="(ps,i) in processSubsidiary"
                                                :class="ps[2] == 'Total' || ps[2] == 'Net Movement' ? 'text-bold' : ''">
                                                <td v-for="(p, j) in ps" v-if="j <= 12" :key="j"
                                                    :class="rowStyleSubsidiaryListing(p, j, ps)"
                                                    :colspan="ps.length == 2 && j == 1 ? 8 : ''">
                                                    @{{ p }}
                                                </td>
                                                <td v-if="ps[2]" v-show="filter.branch && searching">
                                                    <button class="btn btn-danger btn-xs" @click='deleteSub(ps[13])'>
                                                        <i class="fa fa-trash fa-xs"></i>
                                                    </button>

                                                    <button class="btn btn-warning btn-xs" data-toggle="modal"
                                                        data-target="#createSubsidiaryModal" @click='processEdit(ps)'>
                                                        <i class="fa fa-pen fa-xs text-white"></i>
                                                    </button>

                                                </td>

                                                <td v-if="ps[0] == 'BRANCH TOTAL'" v-show="filter.branch && searching">
                                                    <button v-show="ps.length >= 13"
                                                        class="btn
                                                        btn-success"
                                                        data-toggle="modal" @click="onAdd(); add(ps[13])"
                                                        data-target="#createSubsidiaryModal">
                                                        Add
                                                    </button>

                                                </td>

                                                <td
                                                    v-show="!filter.branch && ps.length !=1 && ps[0] != 'BRANCH TOTAL' && ps[0] != 'GRAND TOTAL' && ps[0] != '' && searching && i>=2">
                                                    <button class="btn btn-success btn-xs"
                                                        data-target="#payDepreciationModal" @click='pay(ps,i)'>

                                                        <i class="fa fa-solid fa-file-invoice text-white"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <button class="btn btn-primary"
                                                        v-show="subsidiaryAll && Object.keys(subsidiaryAll).length > 0 && !filter.branch"
                                                        @click="postMonthlyDepreciation(processSubsidiary)">
                                                        Post
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
                                            <th
                                                v-text="filter.category?.sub_cat_name === 'Additional Prepaid Expense' ? 'Prepaid Expense' : 'Expensed' ">
                                            </th>
                                            <th>Unexpensed</th>
                                            <th>Salvage</th>
                                            <th>Due Amort.</th>
                                            <th>Rem.</th>
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
        <div class="modal fade" id="createSubsidiaryModal" tabindex="-1" role="dialog"
            aria-labelledby="createSubsidiaryModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"
                            v-text="isEdit ? 'Edit Subsidiary' : 'Add Subsidiary' "></h5>
                        <button type="button" class="close" @click="closeAction()" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="processAction()">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Inventory Number: </label>
                                        <input type="text" v-model="subsidiary.sub_code" class="form-control"
                                            id="sub_code" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Particular Name: </label>
                                        <input type="text" v-model="subsidiary.sub_name" class="form-control"
                                            id="sub_name" required>
                                        <input v-if="isEdit" type="hidden" name="_method" value="PUT">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Date Obtained: </label>
                                        <input type="date" v-model="subsidiary.sub_date" class="form-control"
                                            id="sub_code" required>
                                    </div>
                                    <div class="col-md-3"
                                        v-if="isEdit && filter.category?.sub_cat_name !== 'Additional Prepaid Expense'">
                                        <label for="message-text" class="col-form-label"> Original Life: </label>
                                        <input type="text" :value="subsidiary.sub_no_depre" class="form-control"
                                            id="original_life" readonly>
                                    </div>

                                    <div class="col-md-3"
                                        v-if="isEdit && filter.category?.sub_cat_name !== 'Additional Prepaid Expense'">
                                        <label for="message-text" class="col-form-label">New Life: </label>
                                        <input type="number" v-model="subsidiary.new_life" class="form-control"
                                            id="new_life">
                                        <small v-if="validationErrors.newLifeTooSmall" class="text-danger">
                                            ❌ New life must be greater than or equal to used value.
                                        </small>
                                    </div>

                                    <div class="col-md-6"
                                        v-if="!isEdit && filter.category?.sub_cat_name !== 'Additional Prepaid Expense'">
                                        <label for="message-text" class="col-form-label">Life: </label>
                                        <input type="number" v-model="subsidiary.sub_no_depre" class="form-control"
                                            id="sub_address" required min="1" step="1">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Amount:</label>
                                        <input type="text" v-model="subsidiary.sub_amount" class="form-control"
                                            @change="formatTextField()" id="sub_tel" :readonly="isEdit" required>
                                    </div>

                                    <div class="col-md-6"
                                        v-show="filter.category?.sub_cat_name != 'Additional Prepaid Expense'">
                                        <label for="message-text" class="col-form-label">Monthly Amortization
                                            <span v-if="isEdit" class="text-success ms-2"
                                                style="font-size: 0.875rem;">*Note: unexpensed / remaining
                                                life)*</span>
                                        </label>
                                        <input type="text" disabled :value="amortToDisplay" class="form-control"
                                            id="sub_acct_no">
                                    </div>
                                    <div class="col-md-6"
                                        v-show="filter.category?.sub_cat_name != 'Additional Prepaid Expense'">
                                        <label for="message-text" class="col-form-label">Rate Percentage(%):</label>
                                        <input type="number" v-model="subsidiary.sub_salvage" class="form-control"
                                            id="sub_salvage">
                                    </div>
                                    <div class="col-md-6"
                                        v-show="filter.category?.sub_cat_name != 'Additional Prepaid Expense'">
                                        <label for="message-text" class="col-form-label">Salvage:
                                        </label>
                                        <input type="text" v-model="ratePercentageAmount" class="form-control">
                                    </div>


                                    <div class="col-md-6" v-if="isEdit"
                                        v-show="filter.category?.sub_cat_name != 'Additional Prepaid Expense'">
                                        <label for="message-text" class="col-form-label">Used:</label>
                                        <input type="number" v-model="subsidiary.sub_no_amort" class="form-control"
                                            id="sub_no_amort" readonly>
                                    </div>
                                    <div class="col-md-6"
                                        v-if="isEdit && filter.category?.sub_cat_name !== 'Additional Prepaid Expense'">
                                        <label for="message-text" class="col-form-label"> Remaining Life </label>
                                        <input type="text" :value="remaining_life" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6"
                                        v-show="filter.category?.sub_cat_name === 'Additional Prepaid Expense' && isEdit">
                                        <label for="message-text" class="col-form-label">Expensed</label>
                                        <input type="text" :value="displayPrepaidAmount" class="form-control"
                                            :readonly="isEdit">
                                    </div>

                                    <div class="col-md-6"
                                        v-show="filter.category?.sub_cat_name === 'Additional Prepaid Expense' && isEdit">
                                        <label for="message-text" class="col-form-label">Expense <span
                                                class="text-success ms-2" style="font-size: 0.875rem;">*(Note: Should be
                                                less than
                                                @{{ subsidiary.unexpensed }})*</span></label>
                                        <input type="text" @change="formatToPrepaidAmountField()"
                                            v-model="to_add_prepaid_amount" class="form-control">
                                    </div>
                                    <div class="col-md-6"
                                        v-if="isEdit && filter.category?.sub_cat_name !== 'Additional Prepaid Expense'">
                                        <label for="expensed" class="col-form-label"> Total Expensed: </label>
                                        <input type="text" :value="formattedExpensed" class="form-control"
                                            id="expensed" readonly>
                                    </div>
                                    <div class="col-md-6"
                                        v-if="isEdit && filter.category?.sub_cat_name !== 'Additional Prepaid Expense'">
                                        <label for="unexpensed-text" class="col-form-label"> Total Unexpensed: </label>
                                        <input type="text" :value="formattedUnexpensed" class="form-control"
                                            id="unexpensed" readonly>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="payDepreciationModal" tabindex="-1" role="dialog"
            aria-labelledby="payDepreciationLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Depreciation Payment</h5>
                        </h5>
                        <button type="button" class="close" @click="closeAction()" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="processPayment()">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="message-text" class="col-form-label">Number of remaining bal to
                                            pay:</label>

                                        <input type="number" class="form-control" v-model="sub.rem" min="1">
                                        <small class="text-success">
                                            Must be less than or equal to remaining value.

                                        </small>
                                    </div>


                                    <div class="col-md-12">
                                        <label for="message-text" class="col-form-label">Total of remaining balance:
                                        </label>
                                        <input type="text" disabled v-model="newRemBalance" class="form-control"
                                            id="sub_acct_no">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        </div>

    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- /.content -->
    <script>
        new Vue({
            el: '#app',
            data: {
                sub: {
                    'sub_id': null,
                    'amount': 0,
                    'unexpensed': 0,
                    'expensed': 0,
                    'rem': 0,
                    'monthly_due': 0,
                    'amort': 0,
                    'used': 0
                },
                branches: @json($branches),
                sub_categories: @json($subsidiary_categories),
                reportType: '',
                sub_month: '',
                monthlyAmortization: 0,
                prepaid_expense: 'Additional Prepaid Expense',
                rate_percentage: 0,
                type: '',
                isEdit: false,
                isInitializing: false,
                subId: null,
                newSub: null,
                searching: false,
                filter: {
                    branch: null,
                    subsidiary_id: '',
                    category: null,
                    from: '',
                    to: '',
                    account_id: '',
                    type: ''
                },
                subAmount: 0,
                prepaid_amount: 0,
                to_add_prepaid_amount: 0,
                subsidiary: {
                    sub_name: '',
                    sub_code: null,
                    sub_no_amort: 0,
                    sub_amount: 0,
                    sub_no_depre: '',
                    sub_cat_id: null,
                    sub_per_branch: null,
                    sub_salvage: 0,
                    rate_percentage: 0,
                    branch_id: '',
                    prepaid_expense: null,
                    prepaid_expense_payment: null,
                    expensed: 0,
                    unexpensed: 0,
                    new_life: '',
                    used: '',
                    remaining_life: 0,
                    original_salvage_rate: 0,
                    original_life: 0,
                },
                validationErrors: {
                    newLifeTooSmall: false
                },
                incomeExpense: {
                    income: [],
                    expense: []
                },
                subsidiaryAll: {},
                balance: 0,
                url: "{{ route('reports.post-monthly-depreciation') }}",
                search: "{{ route('reports.monthly-depreciation-report-search') }}",
                rem: 0,
                remDefault: 0,
                bal: 0,
                index: null,
                subsidiaries: {
                    non_dynamic: [],
                    dynamic: [],
                    category: null,
                    date: null,
                    branches: []
                },
                subsidiaryList: {
                    sub_to_depreciate: [],
                    category: null,
                    date: null,
                },
            },
            computed: {
                formattedExpensed() {
                    return this.subsidiary.expensed || '₱0.00';
                },
                newRemBalance() {
                    var monthly_due = 0;
                    if (this.sub.sub_id) {
                        var diff = this.sub.amort - this.sub.used;
                        monthly_due = this.sub.monthly_due * this.sub.rem
                        if (this.sub.rem == this.remDefault) {
                            monthly_due = this.sub.unexpensed
                        }

                    }
                    return this.formatCurrency(monthly_due);
                },


                formattedUnexpensed() {
                    return this.subsidiary.unexpensed || '₱0.00';
                },
                amortToDisplay() {
                    const isEditing = this.isEdit;
                    const newLife = Number(this.subsidiary.new_life);

                    if (isEditing && newLife > 0) {
                        return this.newAmort;
                    }
                    return this.monthlyAmort;
                },
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
                monthlyAmort() {
                    const used = Number(this.subsidiary.sub_no_amort) || 0;

                    if (used === 0) {
                        // New item - use simple calculation
                        let amount = this.subsidiary.sub_amount;
                        if (typeof amount === 'string') {
                            amount = Number(amount.replace(/[^0-9.-]+/g, ""));
                        }
                        const rate = Number(this.subsidiary.sub_salvage) || 0;
                        const salvage = (rate / 100) * amount;
                        const life = Number(this.subsidiary.sub_no_depre) || 1;
                        const amort = (amount - salvage) / life;
                        return isNaN(amort) ? 0 : this.formatCurrency(amort);
                    } else {
                        // Used item - calculate directly without using remaining_life computed property
                        const totalLife = Number(this.subsidiary.sub_no_depre) || 1;
                        const remaining = Math.max(totalLife - used, 1);

                        // Convert unexpensed to number (handle both string and number cases)
                        let unexpensed = this.subsidiary.unexpensed;
                        if (typeof unexpensed === 'string') {
                            unexpensed = Number(unexpensed.replace(/[^0-9.-]+/g, ""));
                        } else {
                            unexpensed = Number(unexpensed) || 0;
                        }

                        const amort = unexpensed / remaining;
                        return isNaN(amort) ? 0 : this.formatCurrency(amort);
                    }
                },
                newAmort() {
                    const newLife = Number(this.subsidiary.new_life) || 0;
                    const used = Number(this.subsidiary.sub_no_amort) || 0;

                    if (used === 0) {
                        // New item with new life
                        let amount = this.subsidiary.sub_amount;
                        if (typeof amount === 'string') {
                            amount = Number(amount.replace(/[^0-9.-]+/g, ""));
                        }
                        const rate = Number(this.subsidiary.sub_salvage) || 0;
                        const salvage = (rate / 100) * amount;
                        const amort = (amount - salvage) / newLife;
                        return isNaN(amort) ? 0 : this.formatCurrency(amort);
                    } else {
                        // Used item - calculate directly without using remaining_life computed property
                        const remaining = Math.max(newLife - used, 1);

                        // Convert unexpensed to number (handle both string and number cases)
                        let unexpensed = this.subsidiary.unexpensed;
                        if (typeof unexpensed === 'string') {
                            unexpensed = Number(unexpensed.replace(/[^0-9.-]+/g, ""));
                        } else {
                            unexpensed = Number(unexpensed) || 0;
                        }

                        const amort = unexpensed / remaining;
                        return isNaN(amort) ? 0 : this.formatCurrency(amort);
                    }
                },
                remaining_life() {
                    if (this.subsidiary.new_life) {
                        const new_life = Number(this.subsidiary.new_life) || 0;
                        const used = Number(this.subsidiary.sub_no_amort) || 0;
                        const remaining = new_life - used;
                        return remaining > 0 ? remaining : 0;
                    }
                    return this.subsidiary.sub_no_depre - this.subsidiary.sub_no_amort;
                },
                displayPrepaidAmount() {
                    if (this.filter.category?.sub_cat_name === 'Additional Prepaid Expense' && this.isEdit && this
                        .to_add_prepaid_amount) {
                        var currentExpensed = Number((this.prepaid_amount || '0').toString().replace(/[^0-9\.-]+/g,
                            ""));
                        var additionalAmount = Number((this.to_add_prepaid_amount || '0').toString().replace(
                            /[^0-9\.-]+/g, ""));
                        return this.formatCurrency(currentExpensed + additionalAmount);
                    }
                    return this.prepaid_amount;
                },

                amort: function() {

                    var amount = this.subsidiary.sub_amount;
                    if (typeof this.subsidiary.sub_amount === 'string') {
                        var amount = Number(amount.replace(/[^0-9\.-]+/g, ""))
                    }
                    var amort = (amount - this.subsidiary.rate_percentage) / this.subsidiary
                        .sub_no_depre;

                    return isNaN(this.monthlyAmortization) ? 0 : this.formatCurrency(this.monthlyAmortization);
                },


                ratePercentage: function() {
                    var unexpensed = this.subsidiary.unexpensed;
                    if (typeof this.subsidiary.unexpensed === 'string') {
                        var unexpensed = Number(unexpensed.replace(/[^0-9\.-]+/g, ""))
                    }
                    this.subsidiary.rate_percentage = (this.subsidiary.sub_salvage / 100) * unexpensed
                    return this.formatCurrency(this.subsidiary.rate_percentage);
                },
                ratePercentageAmount: function() {
                    var amount = this.subsidiary.sub_amount;
                    if (typeof this.subsidiary.sub_amount === 'string') {
                        amount = Number(amount.replace(/[^0-9\.-]+/g, ""))
                    }
                    let salvage = Number(this.subsidiary.sub_salvage);
                    salvage = isNaN(salvage) ? 0 : salvage;
                    this.subsidiary.rate_percentage = (salvage / 100) * amount;
                    return this.formatCurrency(this.subsidiary.rate_percentage);
                },
                processSubsidiary: function() {
                    var data = {};
                    var rows = [];

                    if (this.subsidiaryAll) {
                        data = this.subsidiaryAll;
                    }
                    var grandTotal = {};
                    var accTotal = {};
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
                    let total_prepaid_exepnse = 0;
                    let total_p_exepense_payment = 0;
                    let prepaid_expensed = 0;
                    let total_rem = 0;
                    let total_inv = 0;
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
                    let totalUnpostedPayments = 0;

                    for (var i in this.subsidiaryAll) {
                        var branches = data[i];
                        rows.push([i]);
                        for (var j in branches) {
                            var branch = branches[j];
                            rows.push([j]);

                            totalAmount = 0;
                            total_monthly_amort = 0;
                            total_no_depre = 0;
                            total_no_amort = 0;
                            total_amort = 0;
                            total_used = 0;
                            total_expensed = 0;
                            total_unexpensed = 0;
                            total_due_amort = 0;
                            total_sub_salvage = 0;
                            total_rem = 0;
                            total_inv = 0;
                            total_prepaid_exepnse = 0;

                            let branchTotal = [];
                            var sub_ids = [];
                            var payment_ids = [];

                            for (var k in branch) {
                                var subsidiary = branch[k];
                                no += 1;
                                if (subsidiary.total_amort != 0) {
                                    if (this.filter.category?.sub_cat_name === this.prepaid_expense) {
                                        total_expensed += parseFloat(subsidiary
                                            .prepaid_expense);
                                        totalUnpostedPayments += parseFloat(subsidiary.unposted_payments);
                                    } else {
                                        total_expensed += parseFloat(subsidiary.expensed)
                                    }
                                    if (j == subsidiary.branch) {
                                        sub_ids.push(subsidiary.sub_id)
                                        let val = [no + ' - ' + subsidiary.sub_code,
                                            subsidiary.sub_name,
                                            subsidiary.sub_date,
                                            this.formatCurrency(subsidiary.sub_amount),
                                            this.formatCurrency(subsidiary.monthly_amort),
                                            subsidiary.sub_no_depre,
                                            subsidiary.used,
                                        ]

                                        if (this.filter.category?.sub_cat_name === this.prepaid_expense) {
                                            val.push(this.formatCurrency(subsidiary.prepaid_expense))
                                        } else {
                                            val.push(this.formatCurrency(subsidiary.expensed))
                                        }

                                        var due_amort = subsidiary.due_amort;
                                        if (subsidiary.rem == 1) {
                                            due_amort = subsidiary.unexpensed
                                        }
                                        val.push(
                                            this.formatCurrency(subsidiary.unexpensed),
                                            this.formatCurrency(parseFloat(due_amort)),
                                            this.formatCurrency(subsidiary.salvage),
                                            subsidiary.rem,
                                            subsidiary.inv,
                                            subsidiary.sub_id,
                                            subsidiary.sub_salvage,
                                            subsidiary.sub_code,
                                            subsidiary.sub_cat_id,
                                            subsidiary.sub_per_branch,
                                            subsidiary.used,
                                            payment_ids,
                                            branch[0].branch_id,
                                            branch[0].branch_code,
                                            subsidiary.branch,
                                            subsidiary.monthly_due)
                                        rows.push(val);
                                        totalAmount += parseFloat(subsidiary.sub_amount),
                                            total_monthly_amort += parseFloat(subsidiary.monthly_due)
                                        total_no_depre += parseInt(subsidiary.sub_no_depre)
                                        total_no_amort += parseFloat(subsidiary.sub_no_amort)
                                        total_amort += parseFloat(subsidiary.total_amort)
                                        total_used += parseInt(subsidiary.used)
                                        total_unexpensed += parseFloat(subsidiary.unexpensed)
                                        total_due_amort += due_amort
                                        total_sub_salvage += parseFloat(subsidiary.salvage)
                                        total_rem += parseFloat(subsidiary.rem)
                                        total_inv += parseFloat(subsidiary.inv)
                                        prepaid_expensed += parseFloat(subsidiary.prepaid_expense)


                                    }
                                }


                            }
                            gTotalAmount += totalAmount;
                            gTotalMonthly += total_monthly_amort;
                            gTotalNoDepre += total_no_depre
                            gTotalNoAmort += total_no_amort
                            gTotalUsed += total_used
                            gTotalExpensed += total_expensed
                            gTotalUnexpensed += total_unexpensed
                            gTotalDueAmort += total_due_amort
                            gTotalSubSalvage += total_sub_salvage
                            gTotalRem += total_rem
                            gTotalInv += total_inv
                            var data = {
                                'sub_ids': sub_ids,
                                'payment_ids': payment_ids,
                                'total': {
                                    total_unposted_payments: totalUnpostedPayments,
                                    total_amount: totalAmount,
                                    total_monthly_amort: total_monthly_amort,
                                    total_no_depre: total_no_depre,
                                    total_used: total_used,
                                    total_expensed: total_expensed,
                                    total_unexpensed: total_unexpensed,
                                    total_due_amort: total_due_amort,
                                    total_sub_salvage: total_sub_salvage,
                                    total_rem: total_rem,
                                    total_inv: total_inv,
                                    total_prepaid_exepnse: total_prepaid_exepnse,
                                    prepaid_expense_payment: total_p_exepense_payment
                                },
                                'category_id': branch[0].sub_cat_id,
                                'branch_id': branch[0].branch_id,
                                'branch_code': branch[0].branch_code,
                                'as_of': this.filter.to,
                            }
                            rows.push(['',
                                '',
                                '',
                                'TOTAL AMOUNT',
                                'TOTAL MONTHLY',
                                'TOTAL AMORT',
                                'TOTAL USED',
                                this.filter.category && this.filter.category.sub_cat_name ===
                                this
                                .prepaid_expense ? 'TOTAL PREPAID EXP.' : 'TOTAL EXPENSED',
                                'TOTAL UNEXPENSED',
                                'TOTAL DUE AMORT',
                                'TOTAL SALVAGE',
                                'TOTAL REM.',
                                'TOTAL INV.',
                            ]);
                            rows.push(['BRANCH TOTAL', '', '',
                                this.formatCurrency(totalAmount),
                                this.formatCurrency(total_monthly_amort),
                                total_no_depre,
                                total_used,
                                this.formatCurrency(total_expensed),
                                this.formatCurrency(total_unexpensed),
                                this.formatCurrency(total_due_amort),
                                this.formatCurrency(total_sub_salvage),
                                total_rem,
                                total_inv, branch, data
                            ]);
                        }
                        rows.push(['GRAND TOTAL', '', '',
                            this.formatCurrency(gTotalAmount),
                            this.formatCurrency(gTotalMonthly),
                            gTotalNoDepre,
                            gTotalUsed,
                            this.formatCurrency(gTotalExpensed),
                            this.formatCurrency(gTotalUnexpensed),
                            this.formatCurrency(gTotalDueAmort),
                            this.formatCurrency(gTotalSubSalvage),
                            gTotalRem,
                            gTotalInv, branch, data
                        ]);
                    }
                    if (Object.keys(this.subsidiaryAll).length === 0) {
                        rows.push(['No Data Found.']);
                        rows.push(['',
                            '',
                            '',
                            'TOTAL AMOUNT',
                            'TOTAL MONTHLY',
                            'TOTAL AMORT',
                            'TOTAL USED',
                            'TOTAL EXPENSED',
                            'TOTAL UNEXPENSED',
                            'TOTAL DUE AMORT',
                            'TOTAL SALVAGE',
                            'TOTAL REM.',
                            'TOTAL INV.',
                        ]);
                        rows.push(['BRANCH TOTAL', '', '',
                            this.formatCurrency(totalAmount),
                            this.formatCurrency(total_monthly_amort),
                            total_no_depre,
                            total_used,
                            this.formatCurrency(total_expensed),
                            this.formatCurrency(total_unexpensed),
                            this.formatCurrency(total_due_amort),
                            this.formatCurrency(total_sub_salvage),
                            total_rem,
                            total_inv

                        ]);
                        rows.push(['GRAND TOTAL', '', '',
                            this.formatCurrency(gTotalAmount),
                            this.formatCurrency(gTotalMonthly),
                            gTotalNoDepre,
                            gTotalUsed,
                            this.formatCurrency(gTotalExpensed),
                            this.formatCurrency(gTotalUnexpensed),
                            this.formatCurrency(gTotalDueAmort),
                            this.formatCurrency(gTotalSubSalvage),
                            gTotalRem,
                            gTotalInv
                        ]);

                    }
                    return rows;
                },
                subsidiaryMonthlyDepreciation: function() {
                    var result = this.subsidiaryAll;
                    var rows = [];
                    for (var i in result) {
                        var branch = result[i];
                        grandTotal = []
                        let grandTotalAmount = 0;
                        let grandTotalExpensed = 0;
                        let grandTotalUnexpensed = 0;
                        let grandTotalDueAmort = 0;
                        let grandTotalRem = 0;
                        let grandTotalSubSalvage = 0;
                        for (var j in branch) {
                            var subsidiary = branch[j];
                            let branchTotalExpensed = 0;
                            let branchTotalAmount = 0;
                            let branchTotalUnexpensed = 0;
                            let branchTotalDueAmort = 0;
                            let branchTotalRem = 0;
                            let branchSubSalvage = 0;
                            for (var k in subsidiary) {
                                if (this.filter.category?.sub_cat_name === this.prepaid_expense) {
                                    branchTotalExpensed += parseFloat(subsidiary[k]
                                        .prepaid_expense);
                                } else {
                                    branchTotalExpensed += parseFloat(subsidiary[k].expensed);
                                }
                                branchTotalAmount += parseFloat(subsidiary[k].sub_amount);
                                branchTotalUnexpensed += parseFloat(subsidiary[k].unexpensed);
                                branchSubSalvage += parseFloat(subsidiary[k].salvage);

                                if (parseFloat(subsidiary[k].used) === parseFloat(subsidiary[k]
                                        .sub_no_depre)) {
                                    branchTotalDueAmort += 0.00;
                                } else {
                                    branchTotalDueAmort += parseFloat(subsidiary[k].monthly_due);
                                }
                                branchTotalRem += parseFloat(subsidiary[k].rem);

                            }
                            var result = [
                                j,
                                this.formatCurrency(branchTotalAmount.toFixed(2)),
                                this.formatCurrency(branchTotalExpensed.toFixed(2)),
                                this.formatCurrency(branchTotalUnexpensed.toFixed(2)),
                                this.formatCurrency(branchSubSalvage.toFixed(2)),
                                this.formatCurrency(branchTotalDueAmort.toFixed(2)),
                                branchTotalRem
                            ]
                            rows.push(result);
                            grandTotalAmount += branchTotalAmount;
                            grandTotalExpensed += branchTotalExpensed;
                            grandTotalUnexpensed += branchTotalUnexpensed;
                            grandTotalSubSalvage += branchSubSalvage;
                            grandTotalDueAmort += branchTotalDueAmort;
                            grandTotalRem += branchTotalRem;
                        }
                        var result = [
                            'Grand Total',
                            this.formatCurrency(grandTotalAmount.toFixed(2)),
                            this.formatCurrency(grandTotalExpensed.toFixed(2)),
                            this.formatCurrency(grandTotalUnexpensed.toFixed(2)),
                            this.formatCurrency(grandTotalSubSalvage.toFixed(2)),
                            this.formatCurrency(grandTotalDueAmort.toFixed(2)),
                            grandTotalRem
                        ];

                    }
                    return rows;

                },



            },
            watch: {
                'subsidiary.new_life'(newVal) {
                    const newLife = Number(newVal);
                    const used = Number(this.subsidiary.sub_no_amort);
                    this.validationErrors.newLifeTooSmall = newLife < used;
                    !this.isInitializing ? this.recomputeExpUnexp() : null;
                },
                'subsidiary.used'(newVal) {
                    const newLife = Number(this.subsidiary.new_life);
                    const used = Number(newVal);
                    this.validationErrors.newLifeTooSmall = newLife < used;
                },
                'subsidiary.sub_amount': function() {
                    !this.isInitializing ? this.recomputeExpUnexp() : null;
                },
                'subsidiary.sub_salvage': function() {
                    !this.isInitializing ? this.recomputeExpUnexp() : null;
                },
                'subsidiary.sub_no_amort': function() {
                    !this.isInitializing ? this.recomputeExpUnexp() : null;
                }
            },

            methods: {
                recomputeExpUnexp() {
                    let amount = this.subsidiary.sub_amount;
                    if (typeof amount === 'string') {
                        amount = Number(amount.replace(/[^0-9\.-]+/g, ''));
                    }

                    const used = parseInt(this.subsidiary.sub_no_amort ?? 0);
                    const newLife = parseInt(this.subsidiary.new_life ?? this.subsidiary
                        .sub_no_depre ?? 1);

                    // FIX: Better handling of empty/erased rates
                    const oldRate = parseFloat(this.subsidiary.original_salvage_rate || 0) || 0;

                    // FIX: Explicitly handle empty, null, undefined, or whitespace-only strings as 0
                    let newRateInput = this.subsidiary.sub_salvage;
                    let newRate = 0;

                    if (newRateInput !== null && newRateInput !== undefined && newRateInput !==
                        '') {
                        // Only parse if there's actually a value
                        if (typeof newRateInput === 'string') {
                            newRateInput = newRateInput.trim(); // Remove whitespace
                            if (newRateInput !== '') {
                                newRate = parseFloat(newRateInput) || 0;
                            }
                        } else {
                            newRate = parseFloat(newRateInput) || 0;
                        }
                    }

                    const lifeToUse = newLife > 0 ? newLife : 1;

                    // Calculate original monthly depreciation (without salvage initially)
                    const originalMonthlyBase = amount / lifeToUse;

                    // Parse stored expensed value (handle formatted strings)
                    let storedExpensed = this.subsidiary.expensed;
                    if (typeof storedExpensed === 'string') {
                        storedExpensed = Number(storedExpensed.replace(/[^0-9\.-]+/g, ""));
                    }
                    storedExpensed = isNaN(storedExpensed) ? 0 : storedExpensed;

                    // Parse stored unexpensed value (handle formatted strings)
                    let storedUnexpensed = this.subsidiary.unexpensed;
                    if (typeof storedUnexpensed === 'string') {
                        storedUnexpensed = Number(storedUnexpensed.replace(/[^0-9\.-]+/g, ""));
                    }
                    storedUnexpensed = isNaN(storedUnexpensed) ? 0 : storedUnexpensed;

                    let expensed, unexpensed;

                    if (used === 0) {
                        // NEW ITEM: Apply salvage to full amount
                        const salvageValue = (newRate / 100) * amount;
                        const depreciableAmount = amount - salvageValue;
                        const monthlyDue = depreciableAmount / lifeToUse;

                        expensed = 0;
                        unexpensed = depreciableAmount;

                    } else {
                        // USED ITEM: More complex logic

                        if (oldRate === 0 && newRate > 0) {
                            // Case: No prior rate → New rate
                            // Only subtract new salvage from unexpensed (don't touch expensed)
                            expensed = storedExpensed; // Keep expensed unchanged
                            const newSalvage = (newRate / 100) * amount;
                            unexpensed = storedUnexpensed -
                                newSalvage; // Subtract salvage from unexpensed

                        } else if (oldRate === 0 && newRate === 0) {
                            // Case: No prior rate and still no rate - keep original stored values
                            expensed = storedExpensed;
                            unexpensed = storedUnexpensed;

                        } else if (oldRate > 0 && newRate !== oldRate) {
                            // Case: Existing rate → Different rate
                            if (newRate === 0) {
                                // Rate cleared completely - revert to original stored values
                                expensed = storedExpensed;
                                unexpensed = storedUnexpensed;
                            } else {
                                // Rate changed: Adjust unexpensed based on salvage difference
                                // Keep expensed unchanged: amount = expensed + salvage + unexpensed
                                expensed = storedExpensed; // Don't touch expensed

                                const oldSalvage = (oldRate / 100) * amount;
                                const newSalvage = (newRate / 100) * amount;
                                const salvageDifference = newSalvage - oldSalvage;

                                if (newRate > oldRate) {
                                    // New rate is higher: more salvage, less unexpensed
                                    unexpensed = storedUnexpensed - salvageDifference;
                                } else {
                                    // New rate is lower: less salvage, more unexpensed
                                    unexpensed = storedUnexpensed -

                                        salvageDifference; // This adds because salvageDifference is negative
                                }
                            }

                        } else {
                            // Case: Same rate or life change only OR oldRate=0 and newRate=0 (no change)
                            const hasValidNewLife = newLife > 0 && !isNaN(newLife);
                            const originalLife = this.subsidiary.sub_no_depre || this.subsidiary
                                .original_life;

                            if (hasValidNewLife && newLife != originalLife) {
                                // Check if new life is less than or equal to used months
                                if (newLife <= used) {
                                    // Do nothing - invalid life change
                                    expensed = storedExpensed;
                                    unexpensed = storedUnexpensed;
                                } else {
                                    // Life changed and is valid: KEEP existing expensed (already depreciated)
                                    expensed =
                                        storedExpensed; // Don't touch what's already been expensed

                                    const salvageValue = (newRate / 100) * amount;
                                    const totalDepreciableAmount = amount - salvageValue;

                                    // Calculate new monthly due for remaining months
                                    const remainingAmount = totalDepreciableAmount - expensed;
                                    const remainingLife = newLife - used;

                                    // Unexpensed is what's left to be depreciated over remaining life
                                    unexpensed = remainingAmount;
                                }

                            } else {
                                // FIX: No changes (including oldRate=0, newRate=0) - keep stored values
                                expensed = storedExpensed;
                                unexpensed = storedUnexpensed;
                            }
                        }
                    }

                    // Ensure no negative values
                    expensed = Math.max(0, expensed);
                    unexpensed = Math.max(0, unexpensed);

                    // Round to 2 decimal places and format back to currency
                    this.subsidiary.expensed = this.formatCurrency(Math.round(expensed * 100) /
                        100);
                    this.subsidiary.unexpensed = this.formatCurrency(Math.round(unexpensed * 100) /
                        100);
                },
                onSearch: function() {
                    this.searching = false;
                },
                onAdd: function() {
                    this.isEdit = false;
                    this.resetForm();
                },
                toAddPrepaidAmount() {
                    var prepaidAmount = Number(this.to_add_prepaid_amount.replace(/[^0-9\.-]+/g,
                        ""))
                    prepaidAmount = parseFloat(this.prepaid_amount) + prepaidAmount
                    this.prepaid_amount = this.formatCurrency(prepaidAmount);
                },
                formatCurrency: function(number) {
                    const formatter = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',

                    });

                    return formatter.format(number)
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
                    if (i >= 3) {
                        style += 'text-right';
                    }
                    if (i == 0) {
                        style += ' text-bold';
                    }
                    return style;
                },
                submitForm: function() {

                    this.fetchSubAll();
                    this.searching = true;
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
                postMonthlyDepreciation: function(data) {
                    this.resetForm()
                    if (data) {
                        var newData = [];
                        for (var i = 0; i < data.length; i++) {
                            if (data[i][0] == "BRANCH TOTAL") {
                                newData.push(data[i][14])
                            }
                        }
                        this.subsidiaryList.category = this.filter.category
                        this.subsidiaryList.date = this.filter.to
                        this.subsidiaries.category = this.filter.category;
                        this.subsidiaries.date = this.filter.to
                        this.subsidiaries.non_dynamic.map(item => {
                            item.rem = 1
                            return item;
                        })
                        axios.post('post', this.subsidiaries, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector(
                                        'meta[name="csrf-token"]')
                                    .content
                            }
                        }).then(response => {
                            toastr.success(response.data.message);
                            this.newSub = response.data.data;
                            this.subsidiaries.dynamic = []
                            window.reload();
                        }).catch(err => {
                            console.error(err)
                        })
                    } else {
                        toastr.warning("No data available");
                    }
                },
                post: function(data) {
                    this.resetForm()
                    if (data) {
                        data.branch_id = this.filter.branch.branch_id;
                        axios.post('post', data, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector(
                                        'meta[name="csrf-token"]')
                                    .content
                            }
                        }).then(response => {
                            toastr.success(response.data.message);
                            this.newSub = response.data.data;
                            // window.reload();
                        }).catch(err => {
                            console.error(err)
                        })
                    } else {
                        toastr.warning("No data available");
                    }
                },

                getRawNewAmort() {

                    let amount = this.subsidiary.sub_amount;
                    if (typeof amount === 'string') {
                        amount = Number(amount.replace(/[^0-9\.-]+/g, ""));
                    }

                    let unexpensed = this.subsidiary.unexpensed;
                    if (typeof unexpensed === 'string') {
                        unexpensed = Number(unexpensed.replace(/[^0-9\.-]+/g, ""));
                    }
                    const salvageRate = Number(this.subsidiary.sub_salvage) || 0;
                    const salvage = (salvageRate / 100) * unexpensed;

                    const remaining = this.remaining_life ||
                        1; // computed property or fallback to 1!

                    const amort = (unexpensed - salvage) / remaining;
                    return isNaN(amort) ? 0 : amort;
                },
                calculateMonthlyAmort() {
                    let amount = this.subsidiary.sub_amount;

                    // Convert string to number if needed
                    if (typeof amount === 'string') {
                        amount = Number(amount.replace(/[^0-9\.-]+/g, ''));
                    }

                    const salvage = Number(this.subsidiary.sub_salvage) || 0;
                    const months = Number(this.subsidiary.sub_no_depre) || 1;

                    const amort = (amount - salvage) / months;

                    // ✅ Assign value to data property
                    this.monthlyAmortization = isNaN(amort) ? 0 : amort;
                },
                add: function(subsidiary) {
                    this.isEdit = false;
                    this.resetForm();
                    if (Array.isArray(subsidiary)) {
                        subsidiary = subsidiary[0];
                        this.subsidiary.sub_cat_id = subsidiary.sub_cat_id
                        this.subsidiary.sub_per_branch = subsidiary.sub_per_branch

                    } else {
                        this.subsidiary.sub_cat_id = this.filter.category.sub_cat_id;
                        this.subsidiary.branch_id = this.filter.branch.branch_id;
                    };

                },
                closeAction: function() {
                    this.resetForm();
                },
                processAction: function() {
                    if (!this.isEdit) {
                        this.createSubsidiary();
                    } else {
                        this.editSubsidiary(this.subId);
                    }
                },
                formatTextField() {
                    this.subsidiary.sub_amount = this.formatCurrency(this.subsidiary.sub_amount);
                    this.subAmount = Number(this.subsidiary.sub_amount.replace(/[^0-9\.-]+/g, ""))

                },

                formatPrepaidAmountField() {
                    this.prepaid_amount = this.formatCurrency(this.prepaid_amount);
                },
                formatToPrepaidAmountField() {
                    this.to_add_prepaid_amount = this.formatCurrency(this.to_add_prepaid_amount);

                },
                formatTextToNumberFormat() {
                    if (this.isString(this.to_add_prepaid_amount)) {
                        this.to_add_prepaid_amount = Number(this.to_add_prepaid_amount.replace(
                            /[^0-9\.-]+/g, ""))
                        this.prepaid_amount = Number(this.prepaid_amount.replace(/[^0-9\.-]+/g,
                            ""));
                        this.subsidiary.sub_amount = Number(this.subsidiary.sub_amount.replace(
                            /[^0-9\.-]+/g, ""))
                    }


                },
                isString: function(val) {
                    return typeof val === 'string' || val instanceof String;
                },
                processEdit: function(sub) {
                    this.isInitializing = true;
                    this.isEdit = true;
                    this.to_add_prepaid_amount = '';
                    this.subId = sub[13];
                    this.subsidiary = {
                        sub_code: sub[15],
                        sub_name: sub[1],
                        sub_date: sub[2],
                        sub_cat_id: sub[16],
                        sub_per_branch: sub[17],
                        sub_no_amort: parseInt(sub[6]),
                        sub_amount: sub[3],
                        sub_salvage: sub[14] !== null ? parseFloat(sub[14]) : 0,
                        sub_no_depre: parseInt(sub[5]),
                        prepaid_expense: sub[7],
                        expensed: sub[7],
                        unexpensed: sub[8],
                        sub_rate_percentage: parseInt(sub[6]),
                        sub_date_of_depreciation: sub[2],
                        original_salvage_rate: sub[14] !== null ? parseFloat(sub[14]) : 0,
                        original_life: parseInt(sub[5] ?? 1),
                    };

                    this.monthlyAmortization = sub[4];
                    this.prepaid_amount = sub[7];
                    this.$nextTick(() => {
                        this.isInitializing = false;
                    });
                },
                pay: function(sub, index) {
                    if (sub[11] > 0) {
                        $('#payDepreciationModal').modal('show');
                        this.index = index
                        this.remDefault = sub[11]
                        this.sub = {
                            'sub_id': sub[13],
                            'amount': Number(sub[3].replace(/[^0-9\.-]+/g, "")),
                            'unexpensed': Number(sub[8].replace(/[^0-9\.-]+/g, "")),
                            'expensed': Number(sub[7].replace(/[^0-9\.-]+/g, "")),
                            'rem': Number(sub[11]),
                            'monthly_due': Number(sub[4].replace(/[^0-9\.-]+/g, "")),
                            'amort': Number(sub[5].replace(/[^0-9\.-]+/g, "")),
                            'used': sub[18],
                            'payment_ids': sub[19],
                            'branch_id': sub[20],
                            'branch_code': sub[21],
                            'branch': sub[22]
                        }
                        this.subsidiaries.dynamic = this.subsidiaries.dynamic.filter(
                            item => item.sub_id !== sub[13]
                        );
                        this.subsidiaries.dynamic.push(this.sub);


                    } else {
                        toastr.warning("Depreaciation Payment already paid.");
                        return false;
                    }

                },
                processPayment() {

                    this.sub.amount_to_depreciate = Number(this.newRemBalance.replace(/[^0-9\.-]+/g, ""));
                    this.subsidiaries.non_dynamic = this.subsidiaries.non_dynamic.filter(
                        item => item.sub_id !== this.sub.sub_id
                    );
                    const branchList = this.subsidiaryAll[this.filter.category.sub_cat_name];
                    const selectedItem = this.processSubsidiary[this.index];

                    const subId = selectedItem[13];
                    const current_rem = selectedItem[11];
                    if (this.sub.rem > current_rem) {
                        toastr.warning(`The number of remaining balance should not be greater than ${current_rem}`);
                        return false;
                    }
                    for (const [branchName, rows] of Object.entries(branchList)) {
                        if (!Array.isArray(rows)) continue;

                        const index = rows.findIndex(item => item.sub_id === subId);
                        if (index !== -1) {
                            const updated = {
                                ...rows[index]
                            };
                            updated.due_amort = Number(this.newRemBalance.replace(/[^0-9\.-]+/g, ""));

                            const newArray = [...rows];
                            newArray[index] = updated;

                            this.$set(branchList, branchName, newArray);
                        }
                    }
                    this.$set(this.subsidiaryAll, this.filter.category.sub_cat_name, branchList);
                    $('#payDepreciationModal').modal('hide');
                },


                resetForm: function() {
                    this.subsidiary = {
                        sub_name: '',
                        sub_code: null,
                        sub_no_amort: 0,
                        sub_amount: 0,
                        sub_no_depre: '',
                        sub_per_branch: null,
                        sub_salvage: 0,
                        rate_percentage: 0,
                        prepaid_expense: {
                            id: null,
                            amount: 0,
                            updated_at: null,
                            created_at: null,
                            sub_id: null
                        }
                    }
                    this.to_add_prepaid_amount = '';
                    this.prepaid_amount = 0;
                },
                createSubsidiary: function() {
                    this.isEdit = false;
                    this.subsidiary.sub_no_amort = 0;
                    var amount = this.subsidiary.sub_amount;


                    let prepaid = this.prepaid_amount ?? '';
                    this.subsidiary.prepaid_expense = parseFloat(
                        String(prepaid).replace(/[₱,]/g, '') || '0'
                    );
                    if (typeof this.subsidiary.sub_amount === 'string') {
                        var amount = Number(amount.replace(/[^0-9\.-]+/g, ""))
                    }
                    this.subsidiary.sub_amount = amount;
                    this.subsidiary.branch = this.filter.branch
                    this.subsidiary.sub_cat_id = this.filter.category.sub_cat_id


                    /* this.subsidiary.sub_amount = Number(this.subsidiary.sub_amount.replace(/[^0-9\.-]+/g, "")) */
                    axios.post('/subsidiary', this.subsidiary, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector(
                                    'meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                        this.addSubsidiary(response.data.data);
                        document.activeElement.blur();
                        $('#createSubsidiaryModal').modal('hide');
                        this.resetForm();
                        this.fetchSubAll();
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
                addSubsidiary: function(data) {
                    const filters = this.filter;
                    const category = filters.category.sub_cat_name;
                    const branch = filters.branch.branch_alias;

                    // Initialize if undefined
                    if (!this.subsidiaryAll[category]) {
                        this.$set(this.subsidiaryAll, category, {});
                    }

                    if (!this.subsidiaryAll[category][branch]) {
                        this.$set(this.subsidiaryAll[category], branch, []);
                    }

                    this.subsidiaryAll[category][branch].push(data);
                },
                updateSubsidiary: function(data) {
                    var filters = this.filter;
                    var subsidiaries = this.subsidiaryAll[filters.category.sub_cat_name][filters
                        .branch
                        .branch_alias
                    ]
                    subsidiaries = subsidiaries.map(sub =>
                        sub.sub_id === data.sub_id ? {
                            ...sub,
                            ...data,
                        } : sub
                    );
                    this.subsidiaryAll[filters.category.sub_cat_name][filters.branch
                            .branch_alias
                        ] =
                        subsidiaries;

                },
                deleteSubsidiary: function(subId) {
                    const filters = this.filter;
                    const category = filters.category.sub_cat_name;
                    const branch = filters.branch.branch_alias;

                    const subsidiaries = this.subsidiaryAll[category][branch];
                    const index = subsidiaries.findIndex(sub => sub.sub_id === subId);

                    if (index !== -1) {
                        subsidiaries.splice(index, 1);
                    }

                    // Optional: cleanup if array becomes empty
                    if (subsidiaries.length === 0) {
                        this.$delete(this.subsidiaryAll[category], branch);
                        if (Object.keys(this.subsidiaryAll[category]).length === 0) {
                            this.$delete(this.subsidiaryAll, category);
                        }
                    }
                },
                editSubsidiary: function(subId) {
                    this.isEdit = true;
                    let amount = this.subsidiary.sub_amount;

                    if (typeof amount === 'string') {
                        amount = Number(amount.replace(/[^0-9\.-]+/g, ""));
                    }

                    const newLife = parseInt(this.subsidiary.new_life ?? 0);
                    const used = parseInt(this.subsidiary.sub_no_amort ?? 0);

                    if (newLife > 0 && newLife < used) {
                        toastr.error(
                            "New life must be greater than or equal to months already used."
                        );
                        return; // stop the update
                    }

                    if (this.filter.category?.sub_cat_name === 'Additional Prepaid Expense' &&
                        this
                        .to_add_prepaid_amount) {
                        var unexpensed = Number(this.subsidiary.unexpensed.replace(
                            /[^0-9\.-]+/g, ""));
                        var toAddAmountStr = this.to_add_prepaid_amount ? String(this
                                .to_add_prepaid_amount) :
                            '0';
                        var toAddAmount = Number(toAddAmountStr.replace(/[^0-9\.-]+/g, ""));

                        if (toAddAmount > unexpensed) {
                            toastr.error('Value should be less than or equal to unexpensed');
                            return; // stop the update
                        }
                    }

                    this.formatTextToNumberFormat();
                    this.subsidiary.sub_amount = amount;
                    this.subsidiary.prepaid_expense = this.prepaid_amount;
                    this.subsidiary.prepaid_expense_payment = this.to_add_prepaid_amount;
                    this.subsidiary.category = this.filter.category;
                    this.subsidiary.original_salvage_rate = parseFloat(this.subsidiary
                        .sub_salvage ?? 0);
                    this.subsidiary.original_life = parseInt(this.subsidiary.sub_no_depre ?? 1);

                    this.recomputeExpUnexp();

                    axios.post('/subsidiary/' + subId, this.subsidiary, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector(
                                    'meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);

                        this.updateSubsidiary(response.data.data)
                        document.activeElement.blur();
                        $('#createSubsidiaryModal').modal('hide');
                        this.fetchSubAll();
                        setTimeout(() => {
                            this.resetForm();
                            this.isEdit = false;

                            // this.getSubsidiaries();
                        }, 100);
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
                        this.$nextTick(() => {
                            this.formatTextField();
                            this.formatToPrepaidAmountField();
                        });
                    })
                },
                deleteSub: function(data) {
                    var url = @json(env('APP_URL'));
                    axios.delete('/subsidiary/' + data, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector(
                                    'meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                        this.deleteSubsidiary(data);
                    }).catch(err => {
                        toastr.success(err);
                    })
                },

                fetchSubAll: function() {
                    this.filter.type = this.reportType;
                    axios.post(this.search, this.filter, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector(
                                        'meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => {
                            this.subsidiaryAll = response.data.data;
                            const raw = response.data.data
                            const allItems = Object.values(raw)
                                .flatMap(branches => Object.values(branches).flat());
                            this.subsidiaries.non_dynamic = allItems.map(item => {
                                var diff = item.rem - item.used;

                                var dueAmort = item.due_amort;
                                if (item.rem == 1) {
                                    dueAmort = item.unexpensed
                                }
                                return {
                                    'sub_id': item.sub_id,
                                    'amount': item.sub_amount,
                                    'unexpensed': item.unexpensed,
                                    'expensed': item.expensed,
                                    'rem': item.rem,
                                    'monthly_due': item.monthly_due,
                                    'amort': item.sub_no_amort,
                                    'amount_to_depreciate': dueAmort,
                                    'used': item.sub_no_depre,
                                    'payment_ids': item.payment_ids,
                                    'branch_id': item.branch_id,
                                    'branch_code': item.sub_per_branch,
                                    'branch': item.branch
                                }
                            })
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                },

            },
            getSubsidiaries() {
                axios.get('/subsidiaries')
                    .then(res => {
                        this.subsidiaries = res.data.data;
                    })
                    .catch(err => {
                        toastr.error("Failed to load subsidiaries.");
                    });
            },
            mounted() {
                this.calculateMonthlyAmort();
                $('#createSubsidiaryModal').on('hidden.bs.modal', () => {
                    this.resetForm();
                });
            }

        });
    </script>
@endsection


@section('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
    @include('scripts.reports.reports')
@endsection
