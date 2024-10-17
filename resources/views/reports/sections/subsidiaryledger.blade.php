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
                        <div v-show="reportType=='subsidiary_all_account'||reportType=='subsidiary_per_account'||reportType=='income_minus_expense'"
                            class="row col-md-12 no-print">
                            <div class="col-md-2" style="margin-right: 10px;">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="sub_acct_no">Subsidiary</label>
                                        <div class="input-group">
                                            <select name="subsidiary_id"
                                                class="select2 form-control form-control-sm" style="width:100%"
                                                id="subsidiaryDD">
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

                            

                            <div v-show="reportType=='subsidiary_per_account'" class="col-md-3" >
                                <div class="box">
                                    <div class="form-group" style="width: 100%">
                                        <label class="label-normal" for="sub_name"> Account Title </label>
                                        <div class="input-group" style="width: 100% !important">
                                            <select 
                                                name="account_id" 
                                                class="select2 form-control form-control-sm"
                                                id="subsidiaryFilterAccountTitle"
                                                style="width: 100% !important;"
                                                >
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

                            <div class="col-md-2 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="sub_date">From</label>
                                        <div class="input-group">
                                            <input v-model="filter.from" type="date"
                                                class="form-control form-control-sm rounded-0" name="from"
                                                id="sub_date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="sub_date">To</label>
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



                                    <table
                                        v-if="reportType=='subsidiary_all_account'||reportType=='subsidiary_per_account'"
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
                                            <th class="text-right"></th>
                                        </thead>
                                            <tbody id="generalLedgerTblContainer">
                                            <tr v-if="!subsidiaryAll.length">
                                                <td colspan="10">
                                                    <center>No data available in table.</center>
                                                </td>
                                            </tr>
                                            <tr v-for="ps in processedSubsidiary" 
                                                :class="ps[2] == 'Total' || ps[2] == 'Net Movement' ? 'text-bold' : ''">
                                                <td v-for="(p, i) in ps.slice(0,9)" :class="rowStyles(p, i, ps)" 
                                                    :colspan="ps.length == 2 && i == 1 ? 8 : ''">
                                                    @{{ p }}
                                                </td>
                                                <!-- Display the button for journal_id only if journal_no exists -->
                                                <td v-if="ps[1]"> <!-- Check if journal_no exists -->
                                                    <button v-if="ps[9]" :value="`${ps[9]}`" class="btn btn-flat btn-xs JnalView bg-gradient-success">
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
                                            <label class="label-bold label-sty" for="date">Journal Reference No</label>
                                            <div class="input-group">
                                                <label class="label-bold" id="voucher_ref_no"></label>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-3 col-xs-12">
                                            <div class="box">
                                                <div class="form-group">
                                                    <label class="label-bold label-sty" for="branch_id">Branch</label>
                                                    <div class="input-group">
                                                        <label class="label-normal text-bold" id="vjournal_branch"></label>
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
            </div>
        </div>
        </div>
    </section>
    <!-- /.content -->
    <script>
        new Vue({
            el: '#app',
            data: {
                reportType: '',
                filter: {
                    subsidiary_id: '',
                    from: '',
                    to: '',
                    account_id: '',
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
                    if (this.reportType == 'subsidiary_all_account' || this.reportType == 'subsidiary_per_account') {
                        this.filter.account_id = $('#subsidiaryFilterAccountTitle').find(':selected').val()
                        this.filter.subsidiary_id = $('#subsidiaryDD').find(':selected').val()
                        this.fetchSubAll();
                    } else if (this.reportType == 'income_minus_expense') {
                        this.fetchIncomeExpense();
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
                            console.log(response.data.data[0]);
                            this.subsidiaryAll = response.data.data[0];
                            this.balance = response.data.data[1];
                            // console.log(response.data.data);
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
                            // console.log(response.data.data);
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
                        if (this.subsidiaryAll[0]) {
                            entries = this.subsidiaryAll[0].entries;
                        }
                    }

                    for (var i in entries) {
                        console.log(entries[i]);
                        var entry = entries[i];
                        var totalCredit = 0;
                        var totalDebit = 0;
                        rows.push([entry.account_number + ' - ' + entry.account_name ? entry.account_name
                            .toUpperCase() : '' + ':', '', '', '', '', '', '', '', this.formatCurrency(
                                this.balance)
                        ]);
                        for (var d in entry.data) {
                            var data = entry.data[d];
                            totalCredit += parseFloat(data.credit);
                            totalDebit += parseFloat(data.debit);
                            var row = [data.journal_date,
                                data.journal_no,
                                data.branch,
                                data.source,
                                data.cheque_date,
                                data.cheque_no,
                                data.debit != 0 ? this.formatCurrency(data.debit) : '',
                                data.credit != 0 ? this.formatCurrency(data.credit) : '',
                                data.balance ? this.formatCurrency(data.balance) : '0.00',
                                data.journal_id // Include the journal_id in the array
                                
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
@endsection

