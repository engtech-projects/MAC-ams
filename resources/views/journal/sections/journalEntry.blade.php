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
						<h4 ><b>Journal Entry</b></h4>
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
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_code">Code</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="book_code" id="book_code"  placeholder="Book Code" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_name">Account Name</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="book_name" id="book_name"  placeholder="Book Name" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-7 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_src">Address</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="book_src" id="book_src"  placeholder="Book Source" required>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_name">Phone Number</label>
								<div class="input-group">
									<input type="Number" class="form-control form-control-sm rounded-0" name="book_name" id="book_name"  placeholder="Book Name" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_name">Subsidiary Category</label>
								<div class="input-group">
								<select name="gender" class="form-control form-control-sm" id="gender">
									<option value="" disabled selected>-Select Report-</option>
									<option value="income_minus_expense">Cat1</option>
									<option value="income_minus_expense_summary">Cat2</option>
									<option value="subsidiary_all_account">Cat3</option>
								</select>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">Branch</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">Date</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">Amount</label>
								<div class="input-group">
									<input type="number" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_head">Depresation</label>
								<div class="input-group">
									<input type="number" class="form-control form-control-sm rounded-0" name="book_head" id="book_head"  placeholder="Print Voucher" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_head">Amort</label>
								<div class="input-group">
									<input type="number" class="form-control form-control-sm rounded-0" name="book_head" id="book_head"  placeholder="Print Voucher" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_head">Salvage</label>
								<div class="input-group">
									<input type="number" class="form-control form-control-sm rounded-0" name="book_head" id="book_head"  placeholder="Print Voucher" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">Date Post</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		<div class="co-md-12" style="height:10px;"></div>
		<div class="row">
			<div class="col-md-12">
					<!-- Table -->
					<section class="content">
						<div class="container-fluid">
							<div class="row" >
								<div class="col-md-12 table-responsive">
									<table id="subsidiaryledgerTbl"  class="table table-bordered ">
										<thead>
											<th>Code</th>
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
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
		Launch demo modal
		</button>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
				
					<div class="modal-body">
						<div class="container-fluid ">
							<div id="ui-view">
								<div>
								<div class="card">
									<div class="card-header">
										<div class="col-md-12">
											<img src="{{ asset('img/mac_header.fw.png') }}" alt="mac_logo"  class="img img-fluid">
										</div>
									</div>
									<div class="card-body">
									<div class="row mb-4">
										<div class="col-sm-4">
										<h6 class="mb-3">From:</h6>
										<div>
											<strong>BBBootstrap Inc.</strong>
										</div>
										<div>546 Aston Avenue</div>
										<div>NYC, NY 12394</div>
										<div>Email: contact@bbbootstrap.com</div>
										<div>Phone: +1 848 389 9289</div>
										</div>
										<div class="col-sm-4">
										<h6 class="mb-3">To:</h6>
										<div>
											<strong>Facebook Inc.</strong>
										</div>
										<div>345, SA Road</div>
										<div>Cupertino CA 92154</div>
										<div>Email: billings@facebook.com</div>
										<div>Phone: +1 894 989 9898</div>
										</div>
										<div class="col-sm-4">
										<h6 class="mb-3">Details:</h6>
										<div>Invoice <strong> #BBB-245432</strong>
										</div>
										<div>March 22, 2020</div>
										<div>VAT: BBB0909090</div>
										<div>Account Name: BANK OF AMERICA</div>
										<div>
											<strong>SWIFT code: 985798579487</strong>
										</div>
										</div>
									</div>
									<div class="table-responsive-sm">
										<table class="table table-striped">
										<thead>
											<tr>
											<th class="center">#</th>
											<th>Item</th>
											<th>Description</th>
											<th class="center">UNIT</th>
											<th class="right">COST</th>
											<th class="right">Total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
											<td class="center">1</td>
											<td class="left">Laptops</td>
											<td class="left">Macbook Air 8GB RAM, 256GB SSD</td>
											<td class="center">5</td>
											<td class="right">$900</td>
											<td class="right">$4500</td>
											</tr>
											<tr>
											<td class="center">2</td>
											<td class="left">Samsung SSD</td>
											<td class="left">Samsung SSD(256 GB)</td>
											<td class="center">20</td>
											<td class="right">$50</td>
											<td class="right">$3000</td>
											</tr>
											<tr>
											<td class="center">3</td>
											<td class="left">PEN DRIVES</td>
											<td class="left">Samsung Pendrives(32GB)</td>
											<td class="center">100</td>
											<td class="right">$10</td>
											<td class="right">$1000</td>
											</tr>
										</tbody>
										</table>
									</div>
									<div class="row">
										<div class="col-lg-4 col-sm-5">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.</div>
										<div class="col-lg-4 col-sm-5 ml-auto">
										<table class="table table-clear">
											<tbody>
											<tr>
												<td class="left">
												<strong>Subtotal</strong>
												</td>
												<td class="right">$8500</td>
											</tr>
											<tr>
												<td class="left">
												<strong>Discount (20%)</strong>
												</td>
												<td class="right">$160</td>
											</tr>
											<tr>
												<td class="left">
												<strong>VAT (10%)</strong>
												</td>
												<td class="right">$90</td>
											</tr>
											<tr>
												<td class="left">
												<strong>Total</strong>
												</td>
												<td class="right">
												<strong>$9000</strong>
												</td>
											</tr>
											</tbody>
										</table>
										<div class="pull-right">
											<a class="btn btn-sm btn-success" href="#" data-abc="true">
											<i class="fa fa-paper-plane mr-1"></i> Proceed to payment </a>
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
			</div>
				
		</div>
		
  </div>
</section>	
<!-- /.content -->


@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection