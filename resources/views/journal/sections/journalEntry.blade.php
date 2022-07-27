@extends('layouts.app')

@section('content')

<style type="text/css">
	a{
		color:black!important;
		font-style: normal!important;
	}
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
	.editable
	{
		color:black;
	}
</style>

<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<div class="row">
		<div class="col-md-12">
			<form id="journalEntryForm" method="POST">
				@csrf
					<div class="row">
						<div class="col-md-8 frm-header">
							<h4 ><b>Journal Entry</b></h4>
						</div>
						<div class="col-md-4 frm-header">
							<label class="label-normal" for="date">Journal Date</label>
							<div class="input-group">
							<input type="date" class="form-control form-control-sm rounded-0" name="journal_date" id="journal_date"  placeholder="Journal Date" required >
							</div>
						</div>
						<div class="col-md-3 col-xs-12">
							<div class="box">
								<div class="form-group">
									<label class="label-normal" for="branch_id">Branch</label>
									<div class="input-group">
									<select name="branch_id" class="form-control form-control-sm" id="branch_id" required>
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
									<label class="label-normal" for="">Book Reference</label>
									<div class="input-group">
									<select name="book_id" class="form-control form-control-sm" id="book_id" required>
										<option value="" disabled selected>-Select Book References-</option>
										@foreach($journalBooks as $journalBook)
											<option value="{{$journalBook->book_id}}" book-src="{{$journalBook->book_src}}">{{$journalBook->book_code}} - {{$journalBook->book_name}}</option>
										@endforeach
									</select>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-2 col-xs-12">
							<div class="box">
								<div class="form-group">
									<label class="label-normal" for="source">Source</label>
									<div class="input-group">
										<input type="text" class="form-control form-control-sm rounded-0" name="source" id="source"  placeholder="Source" required>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-2 col-xs-12">
							<div class="box">
								<div class="form-group">
									<label class="label-normal" for="cheque_no">Cheque No</label>
									<div class="input-group">
										<input type="Number" class="form-control form-control-sm rounded-0" name="cheque_no" id="cheque_no"  placeholder="Cheque No">
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-2 col-xs-12">
							<div class="box">
								<div class="form-group">
									<label class="label-normal" for="status">Status</label>
									<div class="input-group">
										<select name="status" class="form-control form-control-sm" id="status" required>
											<option value="unposted" selected>Unposted</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-xs-12">
							<div class="box">
								<div class="form-group">
									<label class="label-normal" for="amount">Amount</label>
									<div class="input-group">
										<input type="number" class="form-control form-control-sm rounded-0" name="amount" id="amount"  placeholder="Amount" required>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-3 col-xs-12">
							<div class="box">
								<div class="form-group">
									<label class="label-normal" for="payee">Payee</label>
									<div class="input-group">
										<input type="text" class="form-control form-control-sm rounded-0" name="payee" id="payee"  placeholder="Payee" required >
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6 col-xs-12">
							<div class="box">
								<div class="form-group">
									<label class="label-normal" for="remarks">Remarks</label>
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
							@for($i = 0; $i < 1; $i++)
								<tr class='editable-table-row'>
									<td  class="acctnu" value="" >
										<a href="#" class="editable-row-item journal_details_account_no"></a>
									</td>
									<td class='editable-table-data' value="" >
										<select  fieldName="account_id" class="form-control editable-row-item form-control-sm COASelect">
											<option disabled value="" selected>-Select Account Name-</option>
											@foreach($chartOfAccount as $account)
												<option value="{{$account->account_id}}" acct-num="{{$account->account_number}}">{{$account->account_name}}</option>
											@endforeach
										</select>
									</td>
									<td class='editable-table-data journalNum' value="" ><a href="#" fieldName="journal_details_debit"class=" editable-row-item"></a> </td>
									<td class='editable-table-data journalNum' value="" ><a href="#" fieldName="journal_details_credit" class=" editable-row-item"></a> </td>
									<td class='editable-table-data' value="" >
										<select  fieldName="subsidiary_id" class="form-control form-control-sm editable-row-item">
											<option disabled value="" selected>-Select S/L-</option>
											
											<?php
												$temp = '';
												foreach($subsidiaries as $subsidiary){
													if($temp == '')
													{
														$temp = $subsidiary->toArray()["subsidiary_category"]["sub_cat_name"];
														echo '<optgroup label="'.$subsidiary->toArray()["subsidiary_category"]["sub_cat_name"].'">';
													}else if($temp != $subsidiary->toArray()["subsidiary_category"]["sub_cat_name"])
													{
														echo '<optgroup label="'.$subsidiary->toArray()["subsidiary_category"]["sub_cat_name"].'">';
														$temp = $subsidiary->toArray()["subsidiary_category"]["sub_cat_name"];
													}
													echo '<option value="'.$subsidiary->sub_id.'">'.$subsidiary->toArray()["subsidiary_category"]["sub_cat_code"].' - '.$subsidiary->sub_name.'</option>';
												}
											?>
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
						<tfoot>
							<tr class="text-center">
								<th></th>
								<th width="200">TOTAL</th>
								<th width="150" id="total_debit">0</th>
								<th width="150" id="total_credit">0</th>
								<th width="200"></th>
								<th width="200"></th>
								<th class="text-right" width="50"></th>
							</tr>
							<tr class="text-center">
								<th></th>
								<th width="200">BALANCE</th>
								<th width="150" id="balance_debit">0</th>
								<th width="150"></th>
								<th width="200"></th>
								<th width="200"></th>
								<th class="text-right" width="50"></th>
							</tr>
						</tfoot>
					</table>
					</div>
				</div>
			</div>
			<div class="col-md-12 text-right">
				<button class="btn btn-flat btn-sm bg-gradient-success" onclick="$('#btn_submit').click()" > SAVE JOURNAL</button>
			</div>
		
		</div>
	
		
  </div>
</section>	
<!-- /.content -->


@endsection


@section('footer-scripts')
  @include('scripts.journal.journal')
@endsection