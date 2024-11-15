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
        <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
            <div class="row">
                <div class="col-md-12">
                    <form id="subsidiaryForm" method="post">
                        @csrf
                        <input type="hidden" class="form-control form-control-sm rounded-0" name="sub_id" id="sub_id"
                            placeholder="">
                        <div class="row">
                            <div class="col-md-8 frm-header">
                                <h4><b>Subsidiary Ledger</b></h4>
                            </div>
                            <div class="col-md-4 frm-header">
                                <label class="label-normal" for="gender">Select Report</label>
                                <div class="input-group">
                                    <select v-model="reportType" name="gender" class="form-control form-control-sm"
                                        id="gender">
                                        <option value="" disabled selected>-Select Report-</option>
                                        <option value="income_minus_expense">Income Minus Expense</option>
                                        <option value="income_minus_expense_summary">Income Minus Expense (Summary)</option>
                                        <option value="subsidiary_all_account">Subsidiary (All Account)</option>
                                        <option value="subsidiary_per_account">Subsidiary (Per Account)</option>
                                        <option value="subsidiary-ledger-listing-report">Subsidiary (Listing)</option>
                                        <option value="subsidiary-ledger-summary-report">Subsidiary (Summary)</option>
                                        <option value="schedule_of_account">Schedule of Account</option>
                                        <option value="subsidiary_aging_account">Subsidiary Aging / Account</option>
                                        <option value="aging_of_payables">Aging of Payables</option>
                                        <option value="statment_of_receivables">Statement of Receivables</option>
                                        <option value="statement_of_payables">Statemnt of Payables</option>
                                        <option value="collection_details_report">Collection Details Report</option>
                                        <option value="payment_details_report">Payment Details Report</option>
                                        <option value="month_end_schedule_report">Month End Schedule Report</option>
                                    </select>
                                </div>
                            </div>
                            <div v-if="reportType==''" class="row col-md-12">
                                <div class="col-md-2 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_acct_no">Code</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control form-control-sm rounded-0"
                                                    name="sub_acct_no" id="sub_acct_no" placeholder="Subsidiary Account No."
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_name">Account Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm rounded-0"
                                                    name="sub_name" id="sub_name" placeholder="Subsidiary Name" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_address">Address</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm rounded-0"
                                                    name="sub_address" id="sub_address" placeholder="Address" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_life_used">Life Used</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm rounded-0"
                                                    name="sub_life_used" id="sub_life_used" placeholder="Life Used"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_tel">Phone Number</label>
                                            <div class="input-group">
                                                <input type="Number" class="form-control form-control-sm rounded-0"
                                                    name="sub_tel" id="sub_tel" placeholder="Subsidiary Telephone Number"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_cat_id">Subsidiary Category</label>
                                            <div class="input-group">
                                                <select name="sub_cat_id" class="form-control form-control-sm"
                                                    id="sub_cat_id">
                                                    <option value="" disabled selected>-Select Category-</option>
                                                    @foreach ($sub_categories as $sub_category)
                                                        <option value="{{ $sub_category->sub_cat_id }}">
                                                            {{ $sub_category->sub_cat_code }} -
                                                            {{ $sub_category->sub_cat_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_per_branch">Branch</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm rounded-0"
                                                    name="sub_per_branch" id="sub_per_branch" placeholder="Branch"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_date">Date</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control form-control-sm rounded-0"
                                                    name="sub_date" id="sub_date" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_amount">Amount</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control form-control-sm rounded-0"
                                                    name="sub_amount" id="sub_amount" placeholder="Amount" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_no_amort">Amort</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control form-control-sm rounded-0"
                                                    name="sub_no_amort" id="sub_no_amort" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_salvage">Salvage</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control form-control-sm rounded-0"
                                                    name="sub_salvage" id="sub_salvage" placeholder="Salvage" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_date_post">Date Post</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control form-control-sm rounded-0"
                                                    name="sub_date_post" id="sub_date_post" placeholder="Date Posted"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right" style="padding-bottom:20px">
                                    <button class="btn btn-flat btn-sm bg-gradient-success "
                                        type="submit">Save/Update</button>
                                </div>
                            </div>


                        </div>

                    </form>
                    <form @submit.prevent="submitForm" action="">
                        <div v-show="reportType=='subsidiary_all_account'||reportType=='subsidiary_per_account'||reportType=='income_minus_expense'||reportType=='subsidiary-ledger-listing-report'||reportType=='subsidiary-ledger-summary-report'"
                            class="row col-md-12 no-print">
                            <div class="col-md-2 col-xs-12"
                                v-show="reportType=='subsidiary_all_account'||reportType=='subsidiary_per_account'||reportType=='income_minus_expense'">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="sub_acct_no">Subsidiary</label>
                                        <div class="input-group">
                                            <select name="subsidiary_id" class="select2 form-control form-control-sm"
                                                style="width:100%" id="subsidiaryDD">
                                                @foreach ($subsidiaryData as $subdata)
                                                    <option value="{{ $subdata->sub_id }}">
                                                        {{ $subdata->sub_code }} - {{ $subdata->sub_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-show="reportType=='subsidiary_per_account'||reportType=='subsidiary-ledger-listing-report'||reportType=='subsidiary-ledger-summary-report'"
                                class="col-md-3 col-xs-12" style="margin-right:64px;">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="account">Account</label>
                                        <div class="input-group">
                                            <select name="account_id" class="select2 form-control form-control-sm"
                                                id="subsidiaryFilterAccountTitle" {{--          v-model="filter.account_id" --}}
                                                style="width: 100% !important;">
                                                <option value="all">All Accounts</option>
                                                @foreach ($accounts as $account)
                                                    @if ($account->type == 'L' || $account->type == 'R')
                                                        <option value="{{ $account->account_id }}">
                                                            {{ $account->account_number }} - {{ $account->account_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-2 col-xs-12"
                                v-show="reportType=='subsidiary_per_account'||reportType=='subsidiary-ledger-listing-report'">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="date_from">From</label>
                                        <div class="input-group">
                                            <input v-model="filter.from" type="date"
                                                v-if="reportType=='subsidiary_per_account'||reportType=='subsidiary-ledger-listing-report'"
                                                class=" form-control form-control-sm rounded-0" name="from"
                                                id="sub_date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-xs-12"
                                v-if="reportType=='subsidiary_per_account'||reportType=='subsidiary-ledger-listing-report'">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="date_to">To</label>
                                        <div class="input-group">
                                            <input v-model="filter.to" type="date"
                                                class="form-control form-control-sm rounded-0" name="to"
                                                id="sub_date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12" v-show="reportType=='subsidiary-ledger-summary-report'">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="sub_date">As of:</label>
                                        <div class="input-group">
                                            <input v-model="filter.to" type="date"
                                                class="form-control form-control-sm rounded-0" name="to"
                                                id="sub_date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-2 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="sub_date"></label>
                                        <div class="input-group">
                                            <button class="btn btn-flat btn-sm bg-gradient-success " type="submit"
                                                style="margin-top:8px;width:100px;">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="co-md-12" style="height:10px;"></div>
                <div class="col-md-12">
                    <button class="btn btn-success" id="subsidiaryPrintExcel" type="subsidiary_ledger">Print
                        Excel</button>
                </div>
                <div class="col-md-12">

                    <!-- Table -->
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table v-if="reportType==''" id="subsidiaryledgerTbl" class="table ">
                                        <thead>
                                            <th>Account Name</th>
                                            <th>Address</th>
                                            <th>Tel No.</th>
                                            <th>Branch</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Amort</th>
                                            <th>Date Posted</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($subsidiaryData as $data)
                                                <tr>
                                                    <td>{{ $data->sub_name }}</td>
                                                    <td>{{ $data->sub_address }}</td>
                                                    <td>{{ $data->sub_tel }}</td>
                                                    <td>{{ $data->sub_per_branch }}</td>
                                                    <td>{{ Carbon::parse($data->sub_dat)->format('m/d/Y') }}</td>
                                                    <td>{{ $data->sub_amount }}</td>
                                                    <td>{{ $data->sub_no_amort }}</td>
                                                    <td>{{ $data->sub_date_post }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-xs btn-default btn-flat coa-action">Action</button>
                                                            <a type="button"
                                                                class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right" role="menu"
                                                                style="left:0;">
                                                                <a class="dropdown-item btn-edit-account subsid-view-info"
                                                                    value="{{ $data->sub_id }}" href="#">Edit</a>
                                                                <a class="dropdown-item btn-edit-account subsid-delete"
                                                                    value="{{ $data->sub_id }}" href="#">delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <table v-if="reportType=='subsidiary-ledger-listing-report'"
                                        style="table-layout: fixed;" id="generalLedgerTbl" class="table">
                                        <thead>
                                            <th width="15%">Date</th>
                                            <th>Reference</th>
                                            <th width="26%">Preference Name</th>
                                            <th>Source</th>
                                            <th>Cheque Date</th>
                                            <th>Cheque No.</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right">Credit</th>
                                            <th class="text-right">Balance</th>

                                        </thead>
                                        <tbody id="generalLedgerTblContainer">
                                            <tr v-if="!subsidiaryAll.entries">
                                                <td colspan="7">
                                                    <center>No data available in table.</b>
                                                </td>
                                            </tr>

                                            <tr v-for="ps in listing"
                                                :class="ps[2] == 'Total' || ps[2] == 'Net Movement' ? 'text-bold' : ''">
                                                {{-- <td v-for="p,i in ps" :colspan="ps.length == 2 && i==1 ? 8 : ''">@{{ p }}</td> --}}
                                                <td v-for="p,i in ps" :class="rowStyleSubsidiaryListing(p, i, ps)"
                                                    :colspan="ps.length == 2 && i == 1 ? 8 : ''">@{{ p }}</td>
                                            </tr>
                                        </tbody>
                                    </table>


                                    <table v-if="reportType=='subsidiary-ledger-summary-report'"
                                        style="table-layout: fixed;" id="subsidiarySummaryReport" class="table">
                                        <thead>
                                            <th width="15%">Code</th>
                                            <th width="25%">Reference Name</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right">Credit</th>
                                            <th class="text-right">Balance</th>


                                        </thead>
                                        <tbody id="generalLedgerTblContainer">
                                            <tr v-if="!subsidiaryAll.entries">
                                                <td colspan="7">
                                                    <center>No data available in table.</b>
                                                </td>
                                            </tr>

                                            <tr v-for="ps in summary">
                                                <td v-for="p,i in ps" :class="rowStyleSubsidiarySummary(p, i, ps)"
                                                    :colspan="ps.length == 2 && i == 1 ? 8 : ''">@{{ p }}</td>
                                            </tr>
                                        </tbody>
                                    </table>



                                    <table v-if="reportType=='subsidiary_per_account'" style="table-layout: fixed;"
                                        id="generalLedgerTbl" class="table">
                                        <thead>
                                            <th width="15%">Date</th>
                                            <th>Reference</th>
                                            <th width="26%">Preference Name</th>
                                            <th>Source</th>
                                            <th>Cheque Date</th>
                                            <th>Cheque No.</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right">Credit</th>
                                            <th class="text-right">Balance</th>
                                            <th class="text-right"></th>
                                        </thead>
                                        <tbody id="generalLedgerTblContainer">
                                            <tr v-if="subsidiaryAll.length == 0">
                                                <td colspan="7">
                                                    <center>No data available in table.</b>
                                                </td>
                                            </tr>
                                            {{--
                                            <tr v-for="ps in processedSubsidiary"
                                                :class="ps[2] == 'Total' || ps[2] == 'Net Movement' ? 'text-bold' : ''">
                                                <td v-for="p,i in ps" :class="rowStyles(p, i, ps)"
                                                    :colspan="ps.length == 2 && i == 1 ? 8 : ''">@{{ p }}</td>
                                            </tr> --}}
                                            <tr v-for="(ps,i) in subsidiaryLedger"
                                                :class="ps[2] == 'Total' || ps[2] == 'Net Movement' ? 'text-bold' : ''">
                                                {{-- <td v-for="p,i in ps" :colspan="ps.length == 2 && i==1 ? 8 : ''">@{{ p }}</td> --}}
                                                <td v-if="i<=8" v-for="p,i in ps"
                                                    :class="rowStyleSubsidiaryListing(p, i, ps)"
                                                    :colspan="ps.length == 2 && i == 1 ? 8 : ''">@{{ p }}
                                                </td>
                                                <td v-if="ps[2]"> <!-- Check if journal_no exists -->
                                                    <button v-if="ps[2]" :value="`${ps[9]}`"
                                                        class="btn btn-flat btn-sm JnalView bg-gradient-success">
                                                        <i class="fa fa-eye"></i> View
                                                    </button>

                                                    <button v-if="ps[9]" :value="`${ps[9]}`"
                                                        class="btn btn-flat btn-sm JnalEdit bg-gradient-warning text-white">
                                                        <i class="fa fa-pen text-white"></i> Edit
                                                    </button>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>

                                    <table v-if="reportType=='subsidiary_all_account'" style="table-layout: fixed;"
                                        id="generalLedgerTbl" class="table">
                                        <thead>
                                            <th width="15%">Date</th>
                                            <th>Reference</th>
                                            <th width="26%">Preference Name</th>
                                            <th>Source</th>
                                            <th>Cheque Date</th>
                                            <th>Cheque No.</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right">Credit</th>
                                            <th class="text-right">Balance</th>
                                            <th class="text-right"></th>
                                        </thead>
                                        <tbody id="generalLedgerTblContainer">
                                            <tr v-if="!subsidiaryAll.entries">
                                                <td colspan="7">
                                                    <center>No data available in table.</b>
                                                </td>
                                            </tr>

                                            <tr v-for="(ps,i) in processedSubsidiary"
                                                :class="ps[2] == 'Total' || ps[2] == 'Net Movement' ? 'text-bold' : ''">

                                                <td v-if="i<=8" v-for="p,i in ps" :class="rowStyles(p, i, ps)"
                                                    :colspan="ps.length == 2 && i == 1 ? 8 : ''">@{{ p }}
                                                </td>
                                                <td v-if="ps[9]"> <!-- Check if journal_no exists -->
                                                    <button v-if="ps[9]" :value="`${ps[9]}`"
                                                        class="btn btn-flat btn-xs JnalView bg-gradient-success">
                                                        <i class="fa fa-eye"></i> View
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                    <table v-if="reportType=='income_minus_expense'" style="table-layout: fixed;"
                                        id="generalLedgerTbl" class="table">
                                        <thead>
                                            <th width="15%">Date</th>
                                            <th>Reference</th>
                                            <th width="26%">Particular</th>
                                            <th>Source</th>
                                            <th>Cheque Date</th>
                                            <th>Cheque No.</th>
                                            <th class="text-right">Amount</th>
                                            <th class="text-right">Commulative</th>
                                        </thead>
                                        <tbody id="generalLedgerTblContainer">
                                            <tr
                                                v-if="!processedIncomeExpense.income.length&&!processedIncomeExpense.expense.length">
                                                <td colspan="7">
                                                    <center>No data available in table.</b>
                                                </td>
                                            </tr>
                                            <tr v-if="processedIncomeExpense.income.length">
                                                <td><b>REVENUE</b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr :Class="rowStylesIncomeExpense(i)"
                                                v-for="i in processedIncomeExpense.income">
                                                <td v-for="j in i">@{{ j }}</td>
                                            </tr>
                                            <tr v-if="processedIncomeExpense.income.length">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>0.00</td>
                                                <td></td>
                                            </tr>
                                            <tr v-if="processedIncomeExpense.income.length">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>0.00</td>
                                            </tr>
                                            <tr v-if="processedIncomeExpense.expense.length">
                                                <td><b>EXPENSE</b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr :Class="rowStylesIncomeExpense(l)"
                                                v-for="l in processedIncomeExpense.expense">
                                                <td v-for="m in l">@{{ m }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </section>
                    <!-- /.Table -->
                </div>
            </div>
            <div class="modal fade" id="journalModalView" tabindex="1" role="dialog" aria-labelledby="journalModal"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="container-fluid ">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 frm-header">
                                            <h4><b>Journal Entry (Preview)</b></h4>
                                        </div>
                                        <div class="col-md-4 frm-header">
                                            <label class="label-bold label-sty" for="date">Journal Date</label>
                                            <div class="input-group">
                                                <label class="label-bold" id="vjournal_date"></label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 frm-header">
                                            <label class="label-bold label-sty" for="date">Journal Reference
                                                No</label>
                                            <div class="input-group">
                                                <label class="label-bold" id="voucher_ref_no"></label>
                                            </div>
                                        </div>


                                        <div class="col-md-3 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-bold label-sty" for="branch_id">Branch</label>
                                                    <div class="input-group">
                                                        <label class="label-normal text-bold"
                                                            id="vjournal_branch"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-bold label-sty" for="">Book
                                                        Reference</label>
                                                    <div class="input-group">
                                                        <label class="label-normal" id="vjournal_book_reference"></label>
                                                    </div>
                                                    <input type="hidden" name="book_id" id="journalEntryBookId">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-12">

                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-bold label-sty" for="source">Source</label>
                                                    <div class="input-group">
                                                        <label class="label-normal" id="vjournal_source"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-bold label-sty" for="cheque_no">Cheque No</label>
                                                    <div class="input-group">
                                                        <label class="label-normal vjournal_cheque"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-bold label-sty" for="cheque_no">Cheque
                                                        Date</label>
                                                    <div class="input-group">
                                                        <label class="label-bold vjournal_cheque_date"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-bold label-sty" for="amount">Amount</label>
                                                    <div class="input-group">
                                                        <label class="label-normal" style="font-size:30px;">₱ <font
                                                                id="vjournal_amount"></font></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-bold label-sty" for="payee">Payee</label>
                                                    <div class="input-group">
                                                        <label class="label-normal" id="vjournal_payee">Book_no</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-bold label-sty" for="remarks">Remarks</label>
                                                    <div class="input-group no-margin">
                                                        <label class="label-normal" id="vjournal_remarks"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-bold label-sty" for="status">Status</label>
                                                    <div class="input-group">
                                                        <label class="label-normal" id="vjournal_status"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="co-md-12" style="height:10px;"></div>
                                <div class="col-md-12">
                                    <div class="co-md-12" style="height:10px;"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-sm text-center"
                                                id="tbl-create-journal">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th style="width: 10%;">Account #</th>
                                                        <th style="width: 30%;">Account Name</th>
                                                        <th style="width: 30%;">S/L</th>
                                                        <th style="width: 15%;">Debit</th>
                                                        <th style="width: 15%;">Credit</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl-create-journalview-container">
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th width="200">TOTAL</th>
                                                        <th width="150" id="vtotal_debit">0</th>
                                                        <th width="150" id="vtotal_credit">0</th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th width="200">BALANCE</th>
                                                        <th width="150" id="vbalance_debit">0</th>
                                                        <th width="150" id="vcredit"></th>
                                                    </tr>

                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="height:20px;"></div>


                                </div>
                            </div>
                            <!-- Button trigger modal -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="journalModalEdit" tabindex="1" role="dialog" aria-labelledby="journalModalEdit"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid ">
                            <div class="col-md-12">
                                <form id="journalEntryFormEdit" method="POST">
                                    @csrf
                                    <input type="hidden" class="form-control form-control-sm rounded-0"
                                        name="edit_journal_id" id="edit_journal_id" placeholder="">
                                    <div class="row">
                                        <div class="col-md-8 frm-header">
                                            <h4><b>Journal Entry (Edit)</b></h4>
                                        </div>
                                        <div class="col-md-4 frm-header">
                                            <label class="label-normal" for="date">Journal Date</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control form-control-sm rounded-0"
                                                    name="edit_journal_date" id="edit_journal_date"
                                                    placeholder="Journal Date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-normal" for="edit_branch_id">Branch</label>
                                                    <div class="input-group">
                                                        <select name="edit_branch_id" class="select2 form-control form-control-sm"
                                                            id="edit_branch_id" required>
                                                            <option value="" disabled>-Select Branch-
                                                            </option>
                                                            <option value="1">Butuan City Branch</option>
                                                            <option value="2">Nasipit Branch</option>
                                                            <option value="3">Gingoog Branch</option>
                                                            <option value="4">Head Office</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-normal" for="">Book Reference</label>
                                                    <div class="input-group">

                                                        <select required name="edit_book_id" class="select2 form-control form-control-sm" id="edit_book_id">
										<option id="edit_book_id" value="" disabled></option>
										@foreach($journalBooks as $journalBook)
											<option value="{{$journalBook->book_id}}" _count="{{$journalBook->book_code}}-{{sprintf('%006s',$journalBook->ccount + 1)}}" book-src="{{$journalBook->book_src}}">{{$journalBook->book_code}} - {{$journalBook->book_name}}</option>
										@endforeach
									</select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-normal" for="">Reference No.</label>
                                                    <div class="input-group">
                                                        <input type="hidden" name="edit_journal_no" id="edit_journal_no">
                                                        <label class="label-normal" id="edit_LrefNo"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-normal" for="edit_source">Source</label>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control form-control-sm rounded-0"
                                                            name="edit_source" id="edit_source" placeholder="Source"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-normal" for="edit_cheque_no">Cheque No</label>
                                                    <div class="input-group">
                                                        <input type="Text"
                                                            class="form-control form-control-sm rounded-0"
                                                            name="edit_cheque_no" id="edit_cheque_no"
                                                            placeholder="Cheque No">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-normal" for="edit_cheque_date">Cheque Date</label>
                                                    <div class="input-group">
                                                        <input type="date"
                                                            class="form-control form-control-sm rounded-0"
                                                            name="edit_cheque_date" id="edit_cheque_date"
                                                            placeholder="Cheque Date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-normal" for="edit_status">Status</label>
                                                    <div class="input-group">
                                                        <select name="edit_status" class="form-control form-control-sm"
                                                            id="edit_status" required>
                                                            <option value="unposted" selected>Unposted</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-normal" for="edit_amount">Amount</label>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control form-control-sm rounded-0"
                                                            name="edit_amount" id="edit_amount" step="any"
                                                            placeholder="Amount" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-normal" for="edit_payee">Payee</label>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control form-control-sm rounded-0"
                                                            name="edit_payee" id="edit_payee" placeholder="Payee"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-normal" for="edit_remarks">Remarks (<font
                                                            style="color:red;">Separate with double colon (::) for the next
                                                            remarks</font>)</label>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control form-control-sm rounded-0"
                                                            name="edit_remarks" id="edit_remarks" placeholder="Remarks"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="edit_btn_submit" style="display:none;"> UPDATE</button>
                                </form>
                            </div>
                            <div class="co-md-12" style="height:10px;"></div>
                            <div class="col-md-12">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-flat btn-sm bg-gradient-success" id="add_item"><i
                                            class="fa fa-plus"></i> Add Details </button>
                                </div>
                                <div class="co-md-12" style="height:10px;"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-sm text-center"
                                            id="tbl-create-journal-container" style="table-layout: fixed;">
                                            <thead>
                                                <tr class="text-center">
                                                    <th style="width: 10%;">Account #</th>
                                                    <th style="width: 30%;">Account Name</th>
                                                    <th style="width: 15%;">Debit</th>
                                                    <th style="width: 15%;">Credit</th>
                                                    <th style="width: 30%;">S/L</th>
                                                    <th style="width: 5%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl-create-edit-container">

                                            </tbody>
                                            <tfoot>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th>TOTAL</th>
                                                    <th width="150">₱<span id="edit_total_debit">0.00</span></th>
                                                    <th width="150">₱<span id="edit_total_credit">0.00</span></th>
                                                    <th></th>
                                                    <th class="text-right" width="50"></th>
                                                </tr>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th>BALANCE</th>
                                                    <th>₱<span id="edit_balance_debit">0.00</span></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="text-right" width="50"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button class="btn btn-flat btn-sm bg-gradient-success"
                                    onclick="$('#edit_btn_submit').click()"> UPDATE JOURNAL</button>
                            </div>
                            <!-- Button trigger modal -->
                        </div>
                    </div>
                </div>
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
                balance: '',
                reportType: '',
                filter: {
                    subsidiary_id: '',
                    branch_id: '',
                    from: '2024-01-01',
                    to: '2024-06-28',
                    account_id: 'all',
                    type: ''
                },
                incomeExpense: {
                    income: [],
                    expense: []
                },
                subsidiaryAll: [],
                balance: 0,
                url: "{{ route('reports.subsidiary-ledger') }}",
            },
            methods: {
                submitForm: function() {
                    this.filter.account_id = $('#subsidiaryFilterAccountTitle').find(':selected').val()
                    this.filter.subsidiary_id = $('#subsidiaryDD').find(':selected').val()
                    if (this.reportType == 'income_minus_expense') {
                        this.fetchIncomeExpense();
                    } else {
                        this.fetchSubAll();
                    }

                },
                fetchSubAll: function() {
                    this.filter.type = this.reportType;
                    axios.post(this.url, this.filter, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => {
                            if (this.reportType == 'subsidiary-ledger-listing-report' || this.reportType ==
                                'subsidiary-ledger-summary-report') {
                                this.subsidiaryAll = response.data.data;
                                this.balance = response.data.balance;

                            } else {
                                this.subsidiaryAll = response.data.data[0];
                                let bal = response.data.data[1];
                                this.balance = parseFloat(bal);
                            }



                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                },
                fetchIncomeExpense: function() {
                    var data = {
                        subsidiary_id: this.filter.subsidiary_id,
                        date_from: this.filter.from,
                        date_to: this.filter.to,
                        type: this.reportType
                    };
                    axios.post(this.url, data, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => {
                            this.incomeExpense = response.data.data;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                },
                rowStyles: function(p, i, r) {
                    var style = '';
                    if (i >= 6) {
                        style += 'text-right';
                    }
                    if (i == 0 && !r[1].length) {
                        style += ' text-bold';
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
                rowStyleSubsidiarySummary: function(p, i, r) {
                    var style = '';
                    if (i >= 2) {
                        style += 'text-right';
                    }
                    if (i == 0) {
                        style += ' text-bold';
                    }
                    return style;
                },
                rowStylesIncomeExpense: function(row) {
                    if (row[0].length && !row[1].length) {
                        return 'text-bold';
                    }
                    if (!row[0].length && (row[6].length || row[7].length)) {
                        return 'text-bold';
                    }
                    return '';
                },
                formatCurrency: function(number) {
                    const formatter = new Intl.NumberFormat('en-US', {
                        style: 'decimal',
                        minimumFractionDigits: 2,
                    });

                    return formatter.format(number);
                }
            },
            computed: {
                processedSubsidiary: function() {
                    var entries = {};
                    var rows = [];
                    if (this.subsidiaryAll) {
                        entries = this.subsidiaryAll.entries;

                    }
                    for (var i in entries) {
                        var entry = entries[i];
                        var totalCredit = 0;
                        var totalDebit = 0;
                        var netMovement = 0;
                        rows.push([entry.account_number + ' - ' + entry.account_name ? entry.account_name
                            .toUpperCase() : '' + ':', '', '', '', '', '', '', '', this.formatCurrency(
                                entries[i].opening_balance)
                        ]);
                        for (var d in entry.data) {
                            var data = entry.data[d];
                            totalCredit += parseFloat(data.credit);
                            totalDebit += parseFloat(data.debit);
                            var row = [data.journal_date,
                                data.journal_no,
                                data.sub_name,
                                data.source,
                                data.cheque_date,
                                data.cheque_no,
                                data.debit != 0 ? this.formatCurrency(data.debit) : '',
                                data.credit != 0 ? this.formatCurrency(data.credit) : '',
                                data.balance ? this.formatCurrency(data.balance) : '0.00',
                                data.journal_id
                            ];
                            rows.push(row);

                            if (this.reportType == 'subsidiary_per_account') {
                                data.payee != null ? rows.push(['', 'PAYEE: ' + data.payee]) : rows.push(['',
                                    'PAYEE: NONE'
                                ])
                                rows.push(['', data.remarks ? data.remarks.toUpperCase() : ''])
                            }
                        }
                        rows.push(['', '', 'Total', '', '', '', totalDebit != 0 ? this.formatCurrency(
                                totalDebit) : '',
                            totalCredit != 0 ? this.formatCurrency(totalCredit) : '',
                            ''
                        ]);
                        rows.push(['', '', 'Net Movement', '', '', '', '', '', '0.00'])
                    }
                    return rows;

                },
                subsidiaryLedger: function() {
                    var data = {};
                    var rows = [];

                    if (this.subsidiaryAll) {
                        data = this.subsidiaryAll;
                    }

                    let currentBalance = this.balance;;

                    for (var i in data) {
                        var result = data[i];
                        rows.push([result.branch_name, '', '', '', '', '', '', '', '']);
                        rows.push([result.account_name, '', '', '', '', '', '', '', this.formatCurrency(this
                            .balance)]);

                        var entries = result.entries;
                        var totalCredit = 0;
                        var totalDebit = 0;
                        var netMovement = 0;

                        for (var d in entries) {
                            var entry = entries[d];
                            var count = entries.length;
                            const credit = parseFloat(entry.credit.replace(/,/g, ""));
                            const debit = parseFloat(entry.debit.replace(/,/g, ""));
                            totalCredit += credit
                            totalDebit += debit;
                            currentBalance += debit;
                            currentBalance -= credit;

                            var arr = [
                                entry.journal_date,
                                entry.journal_no,
                                entry.sub_name,
                                entry.source,
                                entry.cheque_date,
                                entry.cheque_no,
                                entry.debit,
                                entry.credit,
                                this.formatCurrency(currentBalance),
                                entry.journal_id
                            ];

                            rows.push(arr);

                        }

                        rows.push(['', '', 'Total', '', '', '', totalDebit != 0 ? this.formatCurrency(
                                totalDebit) : '',
                            totalCredit != 0 ? this.formatCurrency(totalCredit) : '',
                            ''
                        ]);
                        rows.push(['', '', 'Net Movement', '', '', '', '', '', this.formatCurrency(parseFloat(arr[8].replace(/,/g, "")))])
                    }


                    return rows;
                },
                subledger: function() {
                    var data = {};
                    var rows = [];

                    if (this.subsidiaryAll) {
                        data = this.subsidiaryAll;
                    }

                    for (var i in data) {
                        var subsidiary = data[i];
                        rows.push([subsidiary.sub_code + ' - ' + subsidiary.sub_name, '', '', '', '', '', '',
                            '', this.formatCurrency(this.balance)
                        ]);

                        var entries = subsidiary.entries;
                        var totalCredit = 0;
                        var totalDebit = 0;
                        var netMovement = 0;

                        for (var d in entries) {
                            var entry = entries[d];
                            var detailsList = entry.data;
                            var count = entry.data.length;

                            for (var h in detailsList) {


                                var details = detailsList[h];
                                totalCredit += parseFloat(details.credit);
                                totalDebit += parseFloat(details.debit);

                                var arr = [
                                    details.journal_date,
                                    details.journal_no,
                                    details.sub_name,
                                    details.source,
                                    details.cheque_date,
                                    details.cheque_no,
                                    details.debit != 0 ? this.formatCurrency(details.debit) : '',
                                    details.credit != 0 ? this.formatCurrency(details.credit) : '',
                                    details.balance ? this.formatCurrency(details.balance) : '0.00',
                                    details.journal_id
                                ];
                                if (count == parseInt(h) + 1) {
                                    netMovement = details.balance;
                                }
                                rows.push(arr);
                            }
                        }
                        rows.push(['', '', 'Total', '', '', '', totalDebit != 0 ? this.formatCurrency(
                                totalDebit) : '',
                            totalCredit != 0 ? this.formatCurrency(totalCredit) : '',
                            ''
                        ]);
                        rows.push(['', '', 'Net Movement', '', '', '', '', '', this.formatCurrency(
                            netMovement)])
                    }


                    return rows;
                },
                listing: function() {
                    var data = {};
                    var rows = [];

                    if (this.subsidiaryAll) {
                        data = this.subsidiaryAll;
                    }
                    for (var i in data) {
                        var subsidiary = data[i];

                        rows.push([subsidiary.sub_code + ' - ' + subsidiary.sub_name]);

                        var entries = subsidiary.entries;
                        var totalCredit = 0;
                        var totalDebit = 0;

                        for (var d in entries) {
                            var entry = entries[d];
                            var detailsList = entry.data;


                            for (var h in detailsList) {
                                var details = detailsList[h];
                                totalCredit += parseFloat(details.credit);
                                totalDebit += parseFloat(details.debit);

                                var arr = [
                                    details.journal_date,
                                    details.journal_no,
                                    details.sub_name,
                                    details.source,
                                    details.cheque_date,
                                    details.cheque_no,
                                    details.debit != 0 ? this.formatCurrency(details.debit) : '',
                                    details.credit != 0 ? this.formatCurrency(details.credit) : '',
                                    details.balance ? this.formatCurrency(details.balance) : '0.00'
                                ];

                                // Push the unique row to rows
                                rows.push(arr);
                            }
                        }
                    }

                    return rows;
                },
                summary: function() {
                    var data = {};
                    var rows = [];

                    if (this.subsidiaryAll) {
                        data = this.subsidiaryAll;
                    }


                    var grandTotal = 0;
                    var grandTotalCredit = 0;
                    var grandTotalDebit = 0;
                    for (var i in data) {
                        var subsidiary = data[i];

                        var entries = subsidiary.entries;

                        for (var d in entries) {
                            var entry = entries[d];
                            var detailsList = entry.data;
                            var totalCredit = 0;
                            var totalDebit = 0;
                            for (var h in detailsList) {
                                var details = detailsList[h];
                                totalCredit += parseFloat(details.credit);
                                totalDebit += parseFloat(details.debit);
                            }
                        }

                        rows.push([subsidiary.sub_code, subsidiary.sub_name, this.formatCurrency(totalDebit),
                            this.formatCurrency(totalCredit),
                            this.formatCurrency(totalDebit - totalCredit)
                        ]);
                        grandTotalDebit += totalDebit;
                        grandTotalCredit += totalCredit
                    }
                    rows.push(['Grand Total', '', this.formatCurrency(grandTotalDebit), this.formatCurrency(
                            grandTotalCredit),
                        this.formatCurrency(grandTotalDebit - grandTotalCredit)
                    ]);

                    return rows;
                },
                processedSubsidiaryListing: function() {
                    var subsidiaries = {};
                    var rows = [];

                    if (this.subsidiaryAll) {
                        if (this.subsidiaryAll) {
                            subsidiaries = this.subsidiaryAll;
                        }
                    }
                    for (var i in subsidiaries) {
                        var subsidiary = subsidiaries[i];
                        var entry = subsidiaries[i];
                        var totalCredit = 0;
                        var totalDebit = 0;
                        rows.push([subsidiary.sub_code + ' - ' + subsidiary.sub_name]);
                        for (var d in subsidiary) {
                            var entries = subsidiary.entries;
                            for (k in entries) {
                                var entry = entries[k];
                                for (j in entry.data) {
                                    var detail = entry.data[j];
                                    totalCredit += parseFloat(detail.credit);
                                    totalDebit += parseFloat(detail.debit);
                                    var row = [detail.journal_date,
                                        detail.journal_no,
                                        detail.sub_name,
                                        detail.source,
                                        detail.cheque_date,
                                        detail.cheque_no,
                                        detail.debit != 0 ? this.formatCurrency(detail.debit) : '',
                                        detail.credit != 0 ? this.formatCurrency(detail.credit) :
                                        '',
                                        detail.balance ? this.formatCurrency(detail.balance) :
                                        '0.00'
                                    ];
                                    rows.push(row);
                                    if (this.reportType == 'subsidiary_per_account') {
                                        data.payee != null ? rows.push(['', 'PAYEE: ' + data.payee]) :
                                            rows
                                            .push([
                                                '',
                                                'PAYEE: NONE'
                                            ])
                                        rows.push(['', data.remarks ? data.remarks.toUpperCase() : ''])
                                    }
                                }

                            }

                        }
                        rows.push(['', '', 'Total', '', '', '', totalDebit != 0 ? this.formatCurrency(
                                totalDebit) : '',
                            totalCredit != 0 ? this.formatCurrency(totalCredit) : '',
                            ''
                        ]);
                        rows.push(['', '', 'Net Movement', '', '', '', '', '', '0.00'])
                    }
                    return rows;
                },
                processedSubsidiarySummary: function() {
                    var subsidiaries = {};
                    var rows = [];

                    if (this.subsidiaryAll) {
                        if (this.subsidiaryAll) {
                            subsidiaries = this.subsidiaryAll;
                        }
                    }
                    var grandTotalDebit = 0;
                    var grandTotalCredit = 0;
                    for (var i in subsidiaries) {

                        var subsidiary = subsidiaries[i];
                        var entry = subsidiaries[i];
                        var totalCredit = 0;
                        var totalDebit = 0;

                        for (var d in subsidiary) {

                            var entries = subsidiary.entries;

                            for (k in entries) {
                                var entry = entries[k];
                                for (j in entry.data) {
                                    var detail = entry.data[j];
                                    totalCredit += parseFloat(detail.credit);
                                    totalDebit += parseFloat(detail.debit);



                                }

                            }


                        }

                        rows.push([subsidiary.sub_code, subsidiary.sub_name, totalDebit, totalCredit,
                            totalDebit - totalCredit
                        ]);
                        grandTotalDebit += totalDebit;
                        grandTotalCredit += totalCredit
                    }

                    rows.push(['Grand Total', '', grandTotalDebit != 0 ? this.formatCurrency(
                            grandTotalDebit) : '',
                        grandTotalCredit != 0 ? this.formatCurrency(grandTotalCredit) : '',
                        grandTotalDebit - grandTotalCredit
                    ]);

                    return rows;
                },
                processedIncomeExpense: function() {
                    var result = {
                        income: [],
                        expense: []
                    }
                    this.incomeExpense.income.forEach(income => {
                        result.income.push([income.account_name, '', '', '', '', '', '', ''])
                        var totalAmount = 0;
                        income.entries.forEach(entry => {
                            var row = [];
                            var amount = entry.credit == 0 ? entry.debit : entry.credit;
                            totalAmount += parseFloat(amount);
                            row.push(entry.journal_date);
                            row.push(entry.journal_no);
                            row.push(entry.subsidiary_name);
                            row.push(entry.source);
                            row.push(entry.cheque_date);
                            row.push(entry.cheque_no);
                            row.push(this.formatCurrency(amount));
                            row.push('0.00');
                            result.income.push(row);
                        });
                        if (income.entries.length) {
                            result.income.push(['', '', '', '', '', '', this.formatCurrency(
                                totalAmount), ''])
                            result.income.push(['', '', '', '', '', '', '', '0.00'])
                        }
                    });
                    this.incomeExpense.expense.forEach(expense => {
                        result.expense.push([expense.account_name, '', '', '', '', '', '', ''])
                        var totalAmount = 0;
                        expense.entries.forEach(entry => {
                            var row = [];
                            var amount = entry.credit == 0 ? entry.debit : entry.credit;
                            totalAmount += parseFloat(amount);
                            row.push(entry.journal_date);
                            row.push(entry.journal_no);
                            row.push(entry.subsidiary_name);
                            row.push(entry.source);
                            row.push(entry.cheque_date);
                            row.push(entry.cheque_no);
                            row.push(this.formatCurrency(amount));
                            row.push('0.00');
                            result.expense.push(row);
                        });
                        if (expense.entries.length) {
                            result.expense.push(['', '', '', '', '', '', this.formatCurrency(
                                totalAmount), ''])
                            result.expense.push(['', '', '', '', '', '', '', '0.00'])
                        }

                    });
                    return result;
                }
            },
            mounted() {
                // for(var i in this.data){
                // 	if(this.data[i]){
                // 		console.log(this.data[i]);
                // 	}
                // }
            }
        });
    </script>
@endsection


@section('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
    @include('scripts.reports.reports')
    @include('scripts.journal.journal')
@endsection
