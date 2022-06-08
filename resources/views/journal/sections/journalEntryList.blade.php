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
</style>

<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<div class="row">
		<div class="col-md-12">
			<form id="bookJournalForm" method="post">
				@csrf
				<input type="hidden" class="form-control form-control-sm rounded-0" name="bookId" id="bookId"  placeholder="" >
				<div class="row">
					<div class="col-md-8 frm-header">
						<h4 ><b>General Ledger</b></h4>
					</div>
					<div class="col-md-4 frm-header">
						<label class="label-normal" for="gender">Select Report</label>
						<div class="input-group">
							<select name="gender" class="form-control form-control-sm" id="gender">
								<option value="" disabled selected>-Select Report-</option>
								<option value="income_minus_expense">Income Minus Expense</option>
								<option value="income_minus_expense_summary">Income Minus Expense (Summary)</option>
								<option value="subsidiary_all_account">Subsidiary (All Account)</option>
								<option value="subsidiary_per_account">Subsidiary (Per Account)</option>
								<option value="schedule_of_account">Schedule of Account</option>
								<option value="subsidiary_aging_account">Subsidiary Aging / Account</option>
								<option value="aging_of_payables">Aging  of Payables</option>
								<option value="statment_of_receivables">Statement of Receivables</option>
								<option value="statement_of_payables">Statemnt of Payables</option>
								<option value="collection_details_report">Collection Details Report</option>
								<option value="payment_details_report">Payment Details Report</option>
								<option value="month_end_schedule_report">Month End Schedule Report</option>
							</select>
						</div>
					</div>
					
					<div class="col-md-12" style="height:20px;"></div>
					<div class="col-md-6 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">Account Name</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">From</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">To</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-12" style="height:20px;"></div>
			</form>
		</div>
		<div class="co-md-12" style="height:10px;"></div>
		<div class="row">
			<div class="col-md-12">
					<!-- Table -->
					<section class="content">
						<div class="container-fluid">
							<div class="row" >
								<div class="col-md-12">
									<table id="journalEntryDetails"  class="table table-bordered">
										<thead>
											<th>Reference No.</th>
											<th>Account Name</th>
											<th>Address</th>
											<th>Tel No.</th>
											<th>Branch</th>
											<th>Date</th>
											<th>Amount</th>
											<th>Amort</th>
											<th>life Used</th>
											<th>Salv</th>
											<th>Account</th>
											<th>Date Posted</th>
										</thead>
										<tbody>
											
											<tr>
												<td class="font-weight-bold">0000</td>
												<td>Head Office</td>
												<td>Butuan City</td>
												<td>354-2202</td>
												<td>BRANCH-BRANCH</td>
												<td>1/1/22</td>
												<td>25,001.00</td>
												<td>320</td>
												<td>5</td>
												<td>5</td>
												<td>01292</td>
												<td>1/12/22</td>
											</tr>
											<tr>
												<td class="font-weight-bold">0000</td>
												<td>Head Office</td>
												<td>Butuan City</td>
												<td>354-2202</td>
												<td>BRANCH-BRANCH</td>
												<td>1/1/22</td>
												<td>25,001.00</td>
												<td>320</td>
												<td>5</td>
												<td>5</td>
												<td>01292</td>
												<td>1/12/22</td>
											</tr>
											<tr>
												<td class="font-weight-bold">0000</td>
												<td>Head Office</td>
												<td>Butuan City</td>
												<td>354-2202</td>
												<td>BRANCH-BRANCH</td>
												<td>1/1/22</td>
												<td>25,001.00</td>
												<td>320</td>
												<td>5</td>
												<td>5</td>
												<td>01292</td>
												<td>1/12/22</td>
											</tr>
											<tr>
												<td class="font-weight-bold">0000</td>
												<td>Head Office</td>
												<td>Butuan City</td>
												<td>354-2202</td>
												<td>BRANCH-BRANCH</td>
												<td>1/1/22</td>
												<td>25,001.00</td>
												<td>320</td>
												<td>5</td>
												<td>5</td>
												<td>01292</td>
												<td>1/12/22</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</section>
					<!-- /.Table -->
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