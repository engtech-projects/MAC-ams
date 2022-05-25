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
	.statementHeader{
		height:40px;
		line-height:40px;
		background:#d2d1d1;
		font-size:1rem;
		font-weight:bold;
		border:1px solid black;

	}
	.statementBody{
		background:white;
		border:1px solid black;
	}
	.statementContent{
		border:0px solid white!important;
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
						<h4 ><b>Income Statement</b></h4>
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
					<div class="col-md-4 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">From</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">To</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12" style="height:20px;"></div>
					<div class="col-md-12 statementHeader">
						REVENUE
					</div>
					<div class="col-md-12 statementBody">
						<div class="invoice-content">
							<div class="table-responsive">
								<table class="table table-invoice">
									<thead>
										<tr>
										<th colspan="3">INCOME FROM LEANDING OPERATION</th>
										<th></th>
										<th></th>
										<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td width="8%"></td>
											<td width="50%">
												<span class="text-inverse">Website design &amp; development</span>
												<br>
												<small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small>
											</td>
											<td class="text-left" >$2,500.00</td>
											<td class="text-center"></td>
										</tr>
										<tr>
											<td width="8%"></td>
											<td width="50%">
												<span class="text-inverse">Website design &amp; development</span>
												<br>
												<small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small>
											</td>
											<td class="text-left" >$2,500.00</td>
											<td class="text-center"></td>
										</tr>
											<tr>
											<td width="8%"></td>
											<td width="50%">
												<span class="text-inverse">Website design &amp; development</span>
												<br>
												<small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small>
											</td>
											<td class="text-left" >$2,500.00</td>
											<td class="text-center"></td>
										</tr>
									</tbody>
								</table>
								<table class="table table-invoice">
									<thead>
										<tr>
										<th colspan="3">OTHER INCOME</th>
										<th></th>
										<th></th>
										<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td width="8%"></td>
											<td width="50%">
												INTEREST INCOME
											</td>
											<td class="text-left" >$2,500.00</td>
											<td class="text-center"></td>
										</tr>
										<tr>
											<td width="8%"></td>
											<td width="50%">
												COMISSION INCOME
											</td>
											<td class="text-left" >$2,500.00</td>
											<td class="text-center"></td>
										</tr>
										<tr>
											<td width="8%"></td>
											<td width="50%">
												OTHER INCOME
											</td>
											<td class="text-left" >$2,500.00</td>
											<td class="text-center"></td>
										</tr>
									</tbody>
								</table>
							</div>
						
						</div>
					</div>
					<div class="col-md-12 statementHeader">
						EXPENSE
					</div>
					<div class="col-md-12 statementBody">
						<div class="invoice-content">
							<div class="table-responsive">
								<table class="table table-invoice">
									<thead>
										<tr>
										<th colspan="3">TASK DESCRIPTION</th>
										<th></th>
										<th></th>
										<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td width="8%"></td>
											<td width="50%">
												<span class="text-inverse">Website design &amp; development</span>
												<br>
												<small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small>
											</td>
											<td class="text-left" >$2,500.00</td>
											<td class="text-center"></td>
										</tr>
										<tr>
											<td width="8%"></td>
											<td width="50%">
												<span class="text-inverse">Website design &amp; development</span>
												<br>
												<small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small>
											</td>
											<td class="text-left" >$2,500.00</td>
											<td class="text-center"></td>
										</tr>
											<tr>
											<td width="8%"></td>
											<td width="50%">
												<span class="text-inverse">Website design &amp; development</span>
												<br>
												<small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small>
											</td>
											<td class="text-left" >$2,500.00</td>
											<td class="text-center"></td>
										</tr>
									</tbody>
								</table>
								
							</div>
					
						</div>
					</div>
				</div>
				
				<div class="col-md-12" style="height:20px;"></div>
			</form>
		</div>
		<div class="co-md-12" style="height:10px;"></div>

	</div>
  </div>
</section>	
<!-- /.content -->


@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection