@extends('layouts.app')

@section('content')

<style type="text/css">
	.frm-header{
		margin-bottom:10px;
		padding-bottom:10px;
		border-bottom:2px solid #4ec891;
	}
	.search-custom{
		display:block;
		position:absolute;
		z-index:999;
		width:100%;
		margin:0px!important;
		color:#3d9970!;
		font-weight:bold;
		font-size:14px;
	}
	.dataTables_filter{
		float:right!important;
	}
	.label-sty{
		color:#344069!important;
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
						<h4 ><b>Journal Entry List</b></h4>
					</div>
					<div class="col-md-12" style="height:20px;"></div>
					<div class="col-md-4 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="branch_id">Branch</label>
								<div class="input-group">
									<select name="s_branch_id" class="form-control form-control-sm" id="s_branch_id">
										<option value="" disabled selected>-All-</option>
										<option value="1">Butuan CIty Branch</option>
										<option value="2">Nasipit Branch</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="branch_id">Book Reference</label>
								<div class="input-group">
									<select name="s_book_id" class="form-control form-control-sm" id="s_book_id" >
										<option value="" disabled selected>-All-</option>
										@foreach($journalBooks as $journalBook)
											<option value="{{$journalBook->book_id}}">{{$journalBook->book_code}} - {{$journalBook->book_name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="s_status">Status</label>
								<div class="input-group">
									<select name="s_status" class="form-control form-control-sm" id="s_status">
											<option value="" selected>-All-</option>
											<option value="unposted">Unposted</option>
											<option value="posted">Posted</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="s_from">From</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="s_from" id="s_from"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="s_to">To</label>
								<div class="input-group">
									<input disabled type="date" class="form-control form-control-sm rounded-0" name="s_to" id="s_to"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">To</label>
								<div class="input-group">
									<button class="btn btn-flat btn-sm bg-gradient-success" id="searchJournal" >SEARCH</button>
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
				<div class="container-fluid">
					<div class="col-md-12">
						<table id="journalEntryDetails"  class="table table-bordered">
							<thead>
								<th>Reference #</th>
								<th>Source</th>
								<th>Amount</th>
								<th>Remarks</th>
								<th>Journal Date</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody id="journalEntryDetailsContent">
								@foreach($journalEntryList as $journal)
									<tr>
										<td class="font-weight-bold">{{$journal->bookDetails->book_code}}</td>
										<td>{{$journal->source}}</td>
										<td>{{$journal->amount}}</td>
										<td>{{$journal->remarks}}</td>
										<td>{{$journal->journal_date}}</td>
										<td class="nav-link {{($journal->status  == 'posted') ? 'text-success' : 'text-danger">Journal Entry</a>'}}"><b>{{ucfirst($journal->status)}}</b></td>
										<td>
											<button value="{{$journal->journal_id}}" {{($journal->status  == 'posted') ? 'disabled' : ''}} class="btn btn-flat btn-sm bg-gradient-danger JnalDelete">Delete</button>
											<button value="{{$journal->journal_id}}" class="btn btn-flat btn-sm JnalView bg-gradient-primary">View</button>
											<button value="{{$journal->journal_id}}" class="btn btn-flat btn-sm JnalEdit bg-gradient-info">Edit</button>
										</td>
									</tr>
								@endforeach 
							</tbody>
						</table>
					</div>
				</div>
			</section>
			<!-- /.Table -->
			</div>
		</div>
	</div>
  </div>
  <div class="modal fade" id="journalModalView" tabindex="1" role="dialog" aria-labelledby="journalModal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="container-fluid ">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-8 frm-header">
								<h4 ><b>Journal Entry (Preview)</b></h4>
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
											<label class="label-normal" id="vjournal_branch" ></label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="box">
									<div class="form-group">
										<label class="label-bold label-sty" for="">Book Reference</label>
										<div class="input-group">
											<label class="label-normal"  id="vjournal_book_reference" ></label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2 col-xs-12">
								<div class="box">
									<div class="form-group">
										<label class="label-bold label-sty" for="source">Source</label>
										<div class="input-group">
											<label class="label-normal"  id="vjournal_source"></label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2 col-xs-12">
								<div class="box">
									<div class="form-group">
										<label class="label-bold label-sty" for="cheque_no">Cheque No</label>
										<div class="input-group">
										<label class="label-normal"  id="vjournal_cheque" ></label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2 col-xs-12">
								<div class="box">
									<div class="form-group">
										<label class="label-bold label-sty" for="status">Status</label>
										<div class="input-group">
											<label class="label-normal"  id="vjournal_status" ></label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="box">
									<div class="form-group">
										<label class="label-bold label-sty" for="amount">Amount</label>
										<div class="input-group">
											<label class="label-normal" style="font-size:40px;">₱ <font  id="vjournal_amount"></font></label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="box">
									<div class="form-group">
										<label class="label-bold label-sty" for="payee">Payee</label>
										<div class="input-group">
											<label class="label-normal" id="vjournal_payee" >Book_no</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="box">
									<div class="form-group">
										<label class="label-bold label-sty" for="remarks">Remarks</label>
										<div class="input-group">
										<label class="label-normal" id="vjournal_remarks">Book_no</label>
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
								<table class="table table-bordered table-sm" id="tbl-create-journal">
									<thead>
										<tr class="text-center">
											<th>Account #</th>
											<th>Account Name</th>
											<th>Debit</th>
											<th>Credit</th>
											<th>S/L</th>
											<th>Description</th>
										</tr>
									</thead>
									<tbody id="tbl-create-journalview-container">
									</tbody>
									<tfoot>
										<tr class="text-center">
											<th></th>
											<th width="200">TOTAL</th>
											<th width="150" id="vtotal_debit">0</th>
											<th width="150" id="vtotal_credit">0</th>
											<th width="200"></th>
											<th width="200"></th>
										</tr>
										<tr class="text-center">
											<th></th>
											<th width="200">BALANCE</th>
											<th width="150" id="vbalance_debit">0</th>
											<th width="150" id="vbalance_credit">0</th>
											<th width="200"></th>
											<th width="200"></th>
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
<div class="modal fade" id="journalModalEdit" tabindex="1" role="dialog" aria-labelledby="journalModal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="container-fluid ">
					<div class="col-md-12">
						<form id="journalEntryForm" method="POST">
							@csrf
							<input type="hidden" class="form-control form-control-sm rounded-0" name="journal_id" id="journal_id"  placeholder="" >
								<div class="row">
									<div class="col-md-8 frm-header">
										<h4 ><b>Journal Entry</b></h4>
									</div>
									<div class="col-md-4 frm-header">
										<label class="label-sty label-normal" for="date">Journal Date</label>
										<div class="input-group">
										<input type="date" class="form-control form-control-sm rounded-0" name="journal_date" id="journal_date"  placeholder="Journal Date" required>
										</div>
									</div>
									<div class="col-md-3 col-xs-12">
										<div class="box">
											<div class="form-group">
												<label class="label-sty label-normal" for="branch_id">Branch</label>
												<div class="input-group">
												<select name="branch_id" class="form-control form-control-sm" id="branch_id">
													<option value="" disabled selected>-Select Branch-</option>
													<option value="1">Butuan CIty Branch</option>
													<option value="2">Nasipit Branch</option>
												</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-xs-12">
										<div class="box">
											<div class="form-group">
												<label class="label-sty label-normal" for="">Book Reference</label>
												<div class="input-group">
												<select name="book_id" class="form-control form-control-sm" id="book_id" >
													<option value="" disabled selected>-Select Book References-</option>
													@foreach($journalBooks as $journalBook)
														<option value="{{$journalBook->book_id}}" book-src="{{$journalBook->book_src}}">{{$journalBook->book_name}}</option>
													@endforeach
												</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 col-xs-12">
										<div class="box">
											<div class="form-group">
												<label class="label-sty label-normal" for="source">Source</label>
												<div class="input-group">
													<input type="text" class="form-control form-control-sm rounded-0" name="source" id="source"  placeholder="Source" required>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 col-xs-12">
										<div class="box">
											<div class="form-group">
												<label class="label-sty label-normal" for="cheque_no">Cheque No</label>
												<div class="input-group">
													<input type="Number" class="form-control form-control-sm rounded-0" name="cheque_no" id="cheque_no"  placeholder="Cheque No" required>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 col-xs-12">
										<div class="box">
											<div class="form-group">
												<label class="label-sty label-normal" for="status">Status</label>
												<div class="input-group">
													<select name="status" class="form-control form-control-sm" id="status">
														<option value="unposted" selected>Unposted</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-xs-12">
										<div class="box">
											<div class="form-group">
												<label class="label-sty label-normal" for="amount">Amount</label>
												<div class="input-group">
													<input type="number" class="form-control form-control-sm rounded-0" name="amount" id="amount"  placeholder="Amount" required>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-xs-12">
										<div class="box">
											<div class="form-group">
												<label class="label-sty label-normal" for="payee">Payee</label>
												<div class="input-group">
													<input type="text" class="form-control form-control-sm rounded-0" name="payee" id="payee"  placeholder="Payee" required>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<div class="box">
											<div class="form-group">
												<label class="label-sty label-normal" for="remarks">Remarks</label>
												<div class="input-group">
													<input type="text" class="form-control form-control-sm rounded-0" name="remarks" id="remarks"  placeholder="Remarks" required>
												</div>
											</div>
										</div>
									</div>
								</div>
								<button id="btn_submit" style="display:none;" > SAVE</button>
						</form>
					</div>
					<div class="co-md-12" style="height:10px;"></div>
					<div class="col-md-12">
						<div class="col-md-12 text-right">
							<button class="btn btn-flat btn-sm bg-gradient-success" id="add_item"><i class="fa fa-plus"></i> Add Details </button>
						</div>
						<div class="co-md-12" style="height:10px;"></div>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-sm" id="tbl-create-journal">
								<thead>
									<tr class="text-center">
										<th>Account #</th>
										<th width="200">Account Name</th>
										<th width="150">Debit</th>
										<th width="150">Credit</th>
										<th width="200">S/L</th>
										<th width="200">Description</th>
										<th class="text-right" width="50">Action</th>
									</tr>
								</thead>
								<tbody id="tbl-create-journal-container">
									@for($i = 0; $i < 5; $i++)
										<tr class='editable-table-row'>
											<td class='editable-table-data' value="" ><a href="#" fieldName="journal_details_account_no" class="editable-row-item"></a></td>
											<td class='editable-table-data' value="" ><a href="#" fieldName="journal_details_title" class="editable-row-item"></a> </td>
											<td class='editable-table-data' value="" ><a href="#" fieldName="journal_details_debit"class=" editable-row-item"></a> </td>
											<td class='editable-table-data' value="" ><a href="#" fieldName="journal_details_credit" class=" editable-row-item"></a> </td>
											<td class='editable-table-data' value="" >
												<select  fieldName="subsidiary_id" class="form-control form-control-sm subsidiary_item">
													<option disabled value="" selected>-Select S/L-</option>
													@foreach($subsidiaries as $subsidiary)
														<option value="{{$subsidiary->sub_id}}">{{$subsidiary->sub_name}}</option>
													@endforeach
												</select>
											</td>
											<td class='editable-table-data' value="" ><a href="#" fieldName="journal_details_description" class=" editable-row-item"></a></td>
											
											<td>
												<button class="btn btn-secondary btn-flat btn-sm btn-default remove-journalDetails">
													<span>
														<i class="fas fa-trash" aria-hidden="true"></i>
													</span>
												</button>
											</td>
										</tr>
									@endfor
								</tbody>
							</table>
								</div>
							</div>
						</div>
						<div class="col-md-12 text-right">
							<button class="btn btn-flat btn-sm bg-gradient-success" onclick="$('#btn_submit').click()" > SAVE JOURNAL</button>
						</div>
						<!-- Button trigger modal -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="journalDetailsVoucher" tabindex="2" role="dialog" aria-labelledby="journalDetailsVoucherLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-body"  >
					
					<div class="container-fluid ">
						<div id="ui-view">
							<div class="card">
							
								<div class="card-body" id="toPrintVouch">
									<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
									<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
									<link rel="stylesheet" href="{{ asset('css/adminlte/adminlte.min.css') }}">
									<div class="col-md-12">
										<img src="{{ asset('img/mac_header.fw.png') }}" alt="mac_logo"  class="img img-fluid">
									</div>
									<div class="col-md-12">
										<h3 style="text-align:center">Journal Voucher</h3>
									</div>
									<div class="row" style="padding-top:10px; border-bottom:10px solid gray;">
										<div class="col-md-6">
											<div class="col-md-12">
												<h6 class="mb-4">Pay to: &nbsp;&nbsp;&nbsp; <strong id="voucher_pay"></strong></h6>
												
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-md-12">
												<h6 class="mb-4">Branch: &nbsp;&nbsp;&nbsp; <strong id="voucher_branch"></strong></h6>
												
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-md-12">
												<h6 class="mb-4">Voucher Date: &nbsp;&nbsp;&nbsp; <strong id="voucher_date"></strong></h6>
												
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-md-12">
												<h6 class="mb-4">Reference No: &nbsp;&nbsp;&nbsp; <strong id="voucher_ref_no"></strong></h6>
												
											</div>
										</div>
									</div>
									<div class="row" style="padding-top:15px; border-bottom:10px solid gray;">
										<div class="col-md-12">
											<div class="col-md-12">
												<h6 class="mb-4">Voucher Source : &nbsp;&nbsp;&nbsp; <strong id="voucher_source"></strong></h6>
												
											</div>
										</div>
										<div class="col-md-12">
											<div class="col-md-12">
												<h6 class="mb-4">Particular : &nbsp;&nbsp;&nbsp; <strong id="voucher_particular"></strong></h6>
												
											</div>
										</div>
										<div class="col-md-12">
											<div class="col-md-12">
												<h6 class="mb-4">Amount :  &nbsp;&nbsp;&nbsp; ₱ <strong id="voucher_amount"></strong></h6>
												
											</div>
										</div>
										<div class="col-md-12">
											<div class="col-md-12">
												<h6 class="mb-4">Amount in words : &nbsp;&nbsp;&nbsp; <strong id="voucher_amount_in_words" style="text-transform:capitalize;"></strong></h6>
												
											</div>
										</div>
									</div>
									<div class="table-responsive-sm" style="padding-top:5px;">
										<table class="table table-striped" style="border-top:4px dashed black;border-bottom:4px dashed black;">
										<thead>
											<tr>
											<th class="center">Account</th>
											<th>Title</th>
											<th>S/L</th>
											<th class="center">Debii</th>
											<th class="right">Credit</th>
											</tr>
										</thead>
										<tbody id="journalVoucherContent">
											
										</tbody>
										</table>
									</div>
									<div class="row">
										<div class="col-lg-4 col-sm-5"></div>
										<div class="col-lg-4 col-sm-5 ml-auto">
										<table class="table table-clear">
											<tbody>
											<tr>
												<td class="left">
												<strong>TOTAL</strong>
												</td>
												<td class="left">₱ <strong id="total_debit_voucher"></strong></td>
												<td class="left">₱ <strong id="total_credit_voucher"></strong></td>
											</tr>
											
											</tbody>
										</table>
										
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
</section>	
<!-- /.content -->
@endsection


@section('footer-scripts')
 	@include('scripts.journal.journal')
@endsection