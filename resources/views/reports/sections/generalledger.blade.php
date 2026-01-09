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

        #external_filter_container {
            display: inline-block;
        }
    </style>

    <!-- Main content -->
    <section class="content" id="app">
        <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
            <div class="row">
                <div class="col-md-12">
                    <form method="get">

                        <input type="hidden" class="form-control form-control-sm rounded-0" name="bookId" id="bookId"
                            placeholder="">
                        <div class="row">
                            <div class="col-md-12 frm-header">
                                <h4><b>General Ledger</b></h4>
                            </div>

                            <div class="col-md-12" style="height:20px;"></div>
                            <div class="col-md-6 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="book_ref">Account Name</label>
                                        <div class="input-group">
                                            <select name="account_id" class="select2 form-control form-control-sm"
                                                id="select-account" value="" required>
                                                <!-- <option value="all" selected>-All-</option> -->
                                                @foreach ($chartOfAccount as $data)
                                                    @if (request('account_id') == $data->account_id)
                                                        <option value="{{ $data->account_id }}" Selected>
                                                            {{ $data->account_number }} - {{ $data->account_name }}</option>
                                                    @else
                                                        <option value="{{ $data->account_id }}">{{ $data->account_number }}
                                                            - {{ $data->account_name }}</option>
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
                                        <label class="label-normal" for="genLedgerFrom">From</label>
                                        <div class="input-group">
                                            <input v-model="filter.from" value="{{ $requests['from'] }}" type="date"
                                                class="form-control form-control-sm rounded-0" name="from"
                                                id="genLedgerFrom" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="genLedgerTo">To</label>
                                        <div class="input-group">
                                            <input type="date" v-model="filter.to" value="{{ $requests['to'] }}"
                                                class="form-control form-control-sm rounded-0" name="to"
                                                id="genLedgerTo" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <div class="box pt-4">
                                    <input type="submit" class="btn btn-success" value="Search">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12" style="height:20px;"></div>
                    </form>
                </div>

                <div class="col-md-12">
                    <div id="external_filter_container"></div>
                    <table style="" class="table table-sm">
                        <thead>
                            <tr>
                                <th width="10%">Date</th>
                                <th width="10%">Reference</th>
                                <th width="26%">Reference Name</th>
                                <th>Source</th>
                                <th>Cheque Date</th>
                                <th>Cheque No.</th>
                                <th class="text-right">Debit</th>
                                <th class="text-right">Credit</th>
                                <th class="text-right">Balance</th>
                                <th></th>
                            </tr>
                        </thead>

                        @if (count($transactions) > 0)
                            @foreach ($transactions as $transaction)
                                <thead>

                                    <tr class="account_name">
                                        <td class="font-weight-bold" colspan="5">{{ $transaction['account_number'] }} -
                                            {{ $transaction['account_name'] }}</td>
                                        <td colspan="4" class="font-weight-bold text-right" style="padding-right: 10px;">
                                            {{ $transaction['balance'] }}</td>
                                    </tr>
                                </thead>

                                <tbody id="generalLedgerTblContainer">

                                    @foreach ($transaction['entries'] as $entry)
                                        <tr id="journal">
                                            <td>{{ $entry['journal_date'] }}</td>
                                            <td>{{ $entry['journal_no'] }}</td>
                                            <td>{{ $entry['branch_name'] }}</td>
                                            <td>{{ $entry['source'] }}</td>
                                            <td>{{ $entry['cheque_date'] }}</td>
                                            <td>{{ $entry['cheque_no'] }}</td>
                                            <td class="text-right">{{ $entry['debit'] }}</td>
                                            <td class="text-right">{{ $entry['credit'] }}</td>
                                            <td class="text-right">{{ $entry['current_balance'] }}</td>
                                            <td>
                                                <div class="row">
                                                    <button value="{{ $entry['journal_id'] }}"
                                                        class="btn btn-flat btn-sm JnalView bg-gradient-success"><i
                                                            class="fa fa-eye"></i>View</button>
                                                    @if (Gate::allows('manager'))
                                                        <button value="{{ $entry['journal_id'] }}"
                                                            class="btn btn-flat btn-sm JnalEdit bg-gradient-warning text-white"><i
                                                                class="fa fa-pen text-white"></i>Edit</button>
                                                    @endif
                                                </div>

                                            </td>
                                        </tr>

                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td colspan="8">
                                                    <div>Payee : {{ $entry['payee'] }}</div>
                                                    <div>{{ $entry['remarks'] }}</div>
                                                </td>
                                            </tr>
                                        </thead>
                                    @endforeach

                                    <tr class="account_name">
                                        <td></td>
                                        <td></td>
                                        <td class="font-weight-bold">Total</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="font-weight-bold text-right">{{ $transaction['total_debit'] }}</td>
                                        <td class="font-weight-bold text-right">{{ $transaction['total_credit'] }}</td>
                                        <td></td>
                                    </tr>

                                    <tr class="account_name">
                                        <td></td>
                                        <td></td>
                                        <td class="font-weight-bold">Net movement</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="font-weight-bold text-right">{{ $transaction['current_balance'] }}</td>
                                    </tr>
                                    <tr id="loading-row">
                                        <td colspan="5" class="text-center">
                                            <i class="fa fa-spinner fa-spin"></i> Loading entries...
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        @else
                            <thead>
                                <tr class="account_name">
                                    <td class="font-weight-bold" colspan="5">{{ $account['account_number'] }} -
                                        {{ $account['account_name'] }}</td>
                                    <td colspan="4" class="font-weight-bold text-right" style="padding-right: 10px;">
                                        @{{ formatCurrency(balance) }}
                                    </td>
                                </tr>
                            </thead>
                        @endif

                    </table>
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
                                    <div class="col-md-12 text-right" id="posted-content">

                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="journalModalEdit" tabindex="1" role="dialog"
                aria-labelledby="journalModalEdit" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="container-fluid ">
                                <div class="col-md-12">
                                    <form id="journalEntryFormEdit" method="POST">
                                        @csrf
                                        <input type="hidden" class="form-control form-control-sm rounded-0"
                                            name="edit_journal_id" id="edit_journal_id" placeholder="">
                                        <input type="hidden" name="source_page" id="source_page" value="General Ledger">
                                        <div class="row">
                                            <div class="col-md-8 frm-header">
                                                <h4><b>Journal Entry (Edit)</b></h4>
                                            </div>
                                            <div class="col-md-4 frm-header">
                                                <label class="label-normal" for="date">Journal Date</label>
                                                <div class="input-group">
                                                    <input model="journal_date" name="journal_date" type="text"
                                                        id="edit_journal_date"
                                                        class="form-control form-control-sm rounded-0">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-xs-12">
                                                <div class="box">
                                                    <div class="form-group">
                                                        <label class="label-normal" for="edit_branch_id">Branch</label>
                                                        <div class="input-group">
                                                            <select name="edit_branch_id"
                                                                class="select2 form-control form-control-sm"
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

                                                            <select required name="edit_book_id"
                                                                class="select2 form-control form-control-sm"
                                                                id="edit_book_id" style="width: 150px;">
                                                                <option id="edit_book_id" value="" disabled>
                                                                </option>
                                                                @foreach ($journalBooks as $journalBook)
                                                                    <option value="{{ $journalBook->book_id }}"
                                                                        _count="{{ $journalBook->book_code }}-{{ sprintf('%006s', $journalBook->ccount + 1) }}"
                                                                        book-src="{{ $journalBook->book_src }}">
                                                                        {{ $journalBook->book_code }} -
                                                                        {{ $journalBook->book_name }}</option>
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
                                                            <input type="hidden" name="edit_journal_no"
                                                                id="edit_journal_no">
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
                                                        <label class="label-normal" for="edit_cheque_date">Cheque
                                                            Date</label>
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
                                                            <select name="edit_status"
                                                                class="form-control form-control-sm" id="edit_status"
                                                                required>
                                                                <option value="unposted" selected>Unposted</option>
                                                                <option value="posted" selected>Posted</option>
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
                                                                name="edit_payee" id="edit_payee" placeholder="Payee">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="box">
                                                    <div class="form-group">
                                                        <label class="label-normal" for="edit_remarks">Remarks (<font
                                                                style="color:red;">Separate with double colon (::) for the
                                                                next
                                                                remarks</font>)</label>
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control form-control-sm rounded-0"
                                                                name="edit_remarks" id="edit_remarks"
                                                                placeholder="Remarks" required>
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
    </section>
    <!-- /.content -->

    <script>
        new Vue({
            el: '#app',
            data: {
                data: @json($transactions),
                balance: @json($balance),
                filter: {
                    from: @json($requests['from']) ? @json($requests['from']) : '',
                    to: @json($requests['to']) ? @json($requests['to']) : '',
                    account_id: @json($requests['account_id']) ? @json($requests['account_id']) : 'all'
                },
                baseUrl: window.location.protocol + "//" + window.location.host
            },
            methods: {
                formatCurrency: function(amount) {
                    amount = parseFloat(amount);
                    if (isNaN(amount)) {
                        return "Invalid Number";
                    }
                    amount = amount.toFixed(2);

                    amount = amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    return amount;
                },
                search: function() {
                    axios.get('/api/reports/general-ledger-search', {
                        params: {
                            from: this.filter.from,
                            to: this.filter.to,
                            account_id: this.filter.account_id

                        },
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        this.data = response.data.transactions;

                    }).catch(err => {
                        toastr.error(err.response.data);

                    })


                },
                logbook: function(e) {
                    console.log(e);
                }
            },
            mounted() {


            }
        });
    </script>
@endsection


@section('footer-scripts')
    @include('scripts.reports.reports')
    @include('scripts.journal.journal')
@endsection
