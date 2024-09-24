@extends('layouts.app')

@section('content')
    <style type="text/css">
        .frm-header {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4ec891;
        }

        .tbl-row {
            cursor: pointer;
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

        .no-margin p {
            margin: 0;
        }

        .dataTables_filter {
            float: right !important;
        }

        .label-sty {
            color: #344069 !important;
        }

        a {
            color: #101b27 !important;
        }

        .page-item.active .page-link {
            color: white !important;
        }

        #account-details {
            padding: 50px;
            display: none;
        }

        .editable-container.editable-inline,
        .editable-container.editable-inline .control-group.form-group,
        .editable-container.editable-inline .control-group.form-group .editable-input,
        .editable-container.editable-inline .control-group.form-group .editable-input textarea,
        .editable-container.editable-inline .control-group.form-group .editable-input select,
        .editable-container.editable-inline .control-group.form-group .editable-input input:not([type=radio]):not([type=checkbox]):not([type=submit]) {
            width: 100%;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
            <div class="row">
                <div class="col-md-12">
                    <form id="SearchJournalForm" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 frm-header">
                                <h4><b>Journal Entry List</b></h4>
                            </div>
                            <div class="col-md-12" style="height:20px;"></div>
                            <div class="container-fluid">
                                <div class="row">
                                    @if(Gate::allows('manager'))
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label-normal" for="branch_id">Branch</label>
                                            <div class="input-group">
                                                <select name="s_branch_id" class="form-control form-control-sm select2"
                                                    id="s_branch_id">
                                                    <option value="" disabled selected>-All-</option>
                                                    <option value="1">Butuan City Branch</option>
                                                    <option value="2">Nasipit Branch</option>
                                                    <option value="3">Gingoog Branch</option>
                                                    <option value="4">Head Office</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-{{ Gate::allows('manager') ? '4':'6' }}">
                                        <div class="form-group">
                                            <label class="label-normal" for="branch_id">Book Reference</label>
                                            <div class="input-group">
                                                <select name="s_book_id" class="select2 form-control form-control-sm"
                                                    id="s_book_id">
                                                    <option value="" disabled selected>-All-</option>
                                                    @foreach ($journalBooks as $journalBook)
                                                        <option value="{{ $journalBook->book_id }}">
                                                            {{ $journalBook->book_code }} - {{ $journalBook->book_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-{{ Gate::allows('manager') ? '4':'6' }}">
                                        <div class="form-group">
                                            <label class="label-normal" for="s_status">Status</label>
                                            <div class="input-group">
                                                <select name="s_status" class="select2 form-control form-control-sm"
                                                    id="s_status">
                                                    <option value="" selected>-All-</option>
                                                    <option value="unposted">Unposted</option>
                                                    <option value="posted">Posted</option>
                                                    <option value="cancelled">Cancelled</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="label-normal" for="s_from">From</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control form-control-sm rounded-0"
                                                    name="s_from" id="s_from" value="{{ $default_date_start }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="label-normal" for="s_to">To</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control form-control-sm rounded-0"
                                                    name="s_to" value="{{ $default_date_start }}" id="s_to" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group mt-2">
                                            <label class="label-normal" for="book_ref" style="margin"></label>
                                            <br>
                                            <div class="input-group">
                                                <button class="btn btn-flat btn-sm bg-gradient-success"
                                                    id="searchJournal">SEARCH</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="height:20px;"></div>
                    </form>
                </div>
                <div class="co-md-12" style="height:10px;"></div>
                <div class="col-md-12">
                    <!-- Table -->
                    <section class="content">
                        {{--                 <a class="" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-cog"></i>
                </a> --}}


                        <div class="container-fluid">
                            <div class="col-md-12">
                                <table id="journalEntryDetails" class="table table-bordered">
                                    <thead>
                                        <th>Journal Date</th>
                                        <th>Book Code</th>
                                        <th>Journal #</th>
                                        <th>Source</th>
                                        <th>Amount</th>
                                        <th width="150">Remarks</th>
                                        @if(Gate::allows('manager'))
                                        <th>Branch</th>
                                        @endif
                                        <th>Status</th>
                                        <th width="150">Action</th>
                                    </thead>
                                    <tbody id="journalEntryDetailsContent">
                                        @foreach ($journalEntryList as $journal)
                                            <tr class="tbl-row" data-id="{{ $journal->journal_id }}">
                                                <td>{{ \Carbon\Carbon::parse($journal->journal_date)->format('M d, Y') }}</td>
                                                <td class="font-weight-bold">{{ $journal->bookDetails->book_code }}</td>
                                                <td class="font-weight-bold">{{ $journal->journal_no }}</td>
                                                <td>{{ $journal->source }}</td>
                                                <td class="journal-amount">{{ $journal->amount }}</td>
                                                <?php $remarks = explode('::', $journal->remarks); ?>
                                                <td>
                                                    @foreach ($remarks as $remark)
                                                        <li> {{ $remark }}</li>
                                                    @endforeach
                                                </td>
                                                @if(Gate::allows('manager'))
                                                <td class="font-weight-bold">{{ $journal->branch_id }}</td>
                                                @endif
                                                <td
                                                    class="nav-link {{ $journal->status == 'posted' ? 'text-success' : 'text-danger">Journal Entry</a>' }}">
                                                    <b>{{ ucfirst($journal->status) }}</b>
                                                </td>
                                                <td>
                                                    <button value="{{ $journal->journal_id }}"
                                                        {{ $journal->status == 'posted' ? 'disabled' : '' }}
                                                        class="btn btn-flat btn-xs bg-gradient-danger jnalVoid"><i
                                                            class="fa fa-trash"></i></button>
                                                    <button value="{{ $journal->journal_id }}"
                                                        class="btn btn-flat btn-xs JnalView bg-gradient-primary"><i
                                                            class="fa fa-eye"></i></button>
                                                    <button value="{{ $journal->journal_id }}"
                                                        {{ $journal->status == 'posted' ? 'disabled' : '' }}
                                                        class="btn btn-flat btn-xs JnalEdit bg-gradient-info"><i
                                                            class="fa fa-edit"></i></button>
                                                    <button value="{{ $journal->journal_id }}"
                                                        {{ $journal->status == 'posted' ? 'disabled' : '' }}
                                                        class="btn btn-flat btn-xs bg-gradient-success stStatus"><i
                                                            class="fa fa-check"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- <div id="account-details">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-sm" id="tbl-create-journal">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Account #</th>
                                                            <th>Account Name</th>

                                                            <th>S/L</th>
                                                            <th width="150">Debit</th>
                                                            <th width="150">Credit</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbl-preview-container">
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="text-center">
                                                            <th></th>
                                                            <th width="200"></th>
                                                            <th width="200">TOTAL</th>
                                                            <th width="150" id="vtotal_debit">0</th>
                                                            <th width="150" id="vtotal_credit">0</th>

                                                        </tr>
                                                        <tr class="text-center">
                                                            <th></th>
                                                            <th width="200"></th>
                                                            <th width="200">BALANCE</th>
                                                            <th width="150" id="vbalance_debit">0</th>
                                                            <th width="150" id="vbalance_credit">0</th>


                                                        </tr>

                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div> -->
                            </div>
                        </div>
                    </section>
                    <!-- /.Table -->
                </div>
            </div>
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
                                    <div class="col-md-8 frm-header">
                                        <h4><b>Journal Entry (Preview)</b></h4>
                                    </div>
                                    <div class="col-md-4 frm-header">
                                        <label class="label-bold label-sty" for="date">Journal Date</label>
                                        <div class="input-group">
                                            <label class="label-bold" id="vjournal_date"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                        <div class="box">
                                            <div class="form-group">
                                                <label class="label-bold label-sty" for="branch_id">Branch</label>
                                                <div class="input-group">
                                                    <label class="label-normal" id="vjournal_branch"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                        <div class="box">
                                            <div class="form-group">
                                                <label class="label-bold label-sty" for="">Book Reference</label>
                                                <div class="input-group">
                                                    <label class="label-normal" id="vjournal_book_reference"></label>
                                                </div>
                                                <input type="hidden" name="book_id" id="journalEntryBookId">
                                            </div>
                                        </div>
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
                                                <label class="label-bold label-sty" for="cheque_no">Cheque Date</label>
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
                                        <table class="table table-bordered table-sm text-center" id="tbl-create-journal">
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
                                                        <select name="edit_branch_id" class="form-control form-control-sm"
                                                            id="edit_branch_id" required>
                                                            <option value="" disabled selected>-Select Branch-
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

                                                        <select required name="edit_book_id" class="form-control form-control-sm" id="edit_book_id">
										<option id="edit_book_id" value="" disabled selected></option>
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
                                                        <input type="number"
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
        <!-- Modal -->
        <div class="modal fade" id="journalDetailsVoucher" tabindex="2" role="dialog"
            aria-labelledby="journalDetailsVoucherLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="container-fluid ">
                            <div id="ui-view">
                                <div class="card">

                                    <div class="card-body" id="toPrintVouch">
                                        <link rel="stylesheet"
                                            href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
                                        <link rel="stylesheet"
                                            href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
                                        <link rel="stylesheet" href="{{ asset('css/adminlte/adminlte.min.css') }}">
                                        <div class="col-md-12">
                                            <img src="{{ asset('img/mac_header.fw.png') }}" alt="mac_logo"
                                                class="img img-fluid">
                                        </div>
                                        <div class="col-md-12">
                                            <h3 style="text-align:center">Journal Voucher</h3>
                                        </div>
                                        <div class="row" style="padding-top:10px; border-bottom:10px solid gray;">
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Pay to: &nbsp;&nbsp;&nbsp; <strong
                                                            id="voucher_pay"></strong></h6>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Branch: &nbsp;&nbsp;&nbsp; <strong
                                                            id="voucher_branch"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Voucher Date: &nbsp;&nbsp;&nbsp; <strong
                                                            id="voucher_date"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Reference No: &nbsp;&nbsp;&nbsp; <strong
                                                            id="voucher_ref_no"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Reference Book: &nbsp;&nbsp;&nbsp; <strong
                                                            id="voucher_book_name"></strong></h6>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top:15px; border-bottom:10px solid gray;">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Voucher Source : &nbsp;&nbsp;&nbsp; <strong
                                                            id="voucher_source"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Particular : &nbsp;&nbsp;&nbsp; <strong
                                                            id="voucher_particular"></strong></h6>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Amount : &nbsp;&nbsp;&nbsp; ₱ <strong
                                                            id="voucher_amount"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Amount in words : &nbsp;&nbsp;&nbsp; <strong
                                                            class="voucher_amount_in_words"
                                                            style="text-transform:capitalize;"></strong></h6>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive-sm" style="padding-top:5px;">
                                            <table class="table table-striped" style="margin-bottom:0; border-top:4px dashed black;">
                                                <thead>
                                                    <tr>
                                                        <th class="center">Account</th>
                                                        <th>Title</th>
                                                        <th>S/L</th>
                                                        <th class="center">Debit</th>
                                                        <th class="right">Credit</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="journalVoucherContent">

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row" style="border-top: 10px solid gray; ">
                                            <div class="col-md-4" style="margin-top: 20px;"><h6 style="margin-bottom: 40px;">Prepared By:</h6>
                                            <p>______________________________________________________</p></div>
                                            <div class="col-md-4" style="margin-top: 20px;"><h6 style="margin-bottom: 40px;">Certified Correct By:</h6><p>______________________________________________________</p></div>
                                            <div class="col-md-4" style="margin-top: 20px;"><h6 style="margin-bottom: 40px;">Approved By:</h6><p>______________________________________________________</p></div>
                                        </div>
                                        <div class="received-payment">
                                            <div class="row">
                                                <br>
                                                <br>
                                                <div class="col-md-12" >
                                                    <h6
                                                        style="text-align: justify;text-justify:inter-word;text-transform:uppercase">
                                                        Received payment from MICRO ACCESS LOANS CORPORATION CORPORATION the
                                                        of
                                                        sum
                                                        <span
                                                            class="voucher_amount_in_words">&nbsp;&nbsp;&nbsp;</span>
                                                    </h6>
                                                </div>
                                                <div class="col-md-12">
                                                    <h6>Cheque Number: &nbsp;&nbsp;&nbsp; <span
                                                            class="vjournal_cheque"></span>
                                                    </h6>

                                                </div>
                                                <div class="col-md-12">
                                                    <h6>Cheque Date: <span class="vjournal_cheque_date"></span></h6>
                                                </div>
                                            </div>
                                        <br><br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Received By:________________________________________</h6>

                                                </div>

                                                <div class="col-md-6">
                                                    <h6>Date:_______________________</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-5"></div>
                                            <div class="col-lg-4 col-sm-5 ml-auto">

                                                <!-- <table class="table table-clear">
                                                        <tbody>
                                                            <tr>
                                                                <td class="left">
                                                                    <strong>TOTAL</strong>
                                                                </td>
                                                                <td class="left"><strong id="total_debit_voucher"></strong>
                                                                </td>
                                                                <td class="left"><strong id="total_credit_voucher"></strong>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table> -->

                                            </div>
                                            <div class="col-lg-4 col-sm-5" style="text-align:right;">
                                                <button  class="btn btn-flat btn-sm bg-gradient-success" id="printVoucher"><i class="fa fa-print"></i> Print</button>`
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- /.content -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#printVoucher', function(e) {
                var winPrint = window.open('', '',
                    'left=0,top=0,width=800,height=600,toolbar=0,scrollbars=0,status=0');
                winPrint.document.write($('#toPrintVouch').html());
                winPrint.document.close();
                winPrint.focus();
                window.setTimeout(() => {
                    winPrint.print();
                    winPrint.close();
                }, 500);
            });
        });
    </script>
    @endsection
    @section('footer-scripts')
        @include('scripts.journal.journal')
    @endsection
