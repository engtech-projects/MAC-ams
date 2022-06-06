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
	.buttons-print, .buttons-html5{
		display:none;
	}
</style>

<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<div class="row">
		<div class="col-md-12">
			<form id="subsidiaryForm" method="post">
				@csrf
				<input type="hidden" class="form-control form-control-sm rounded-0" name="sub_id" id="sub_id"  placeholder="" >
				<div class="row">
					<div class="col-md-8 frm-header">
						<h4 ><b>Subsidiary Ledger</b></h4>
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
								<label class="label-normal" for="sub_acct_no">Code</label>
								<div class="input-group">
									<input type="number" class="form-control form-control-sm rounded-0" name="sub_acct_no" id="sub_acct_no"  placeholder="Subsidiary Account No." required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="sub_name">Account Name</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="sub_name" id="sub_name"  placeholder="Subsidiary Name" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-4 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="sub_address">Address</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="sub_address" id="sub_address"  placeholder="Address" required>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="sub_life_used">Life Used</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="sub_life_used" id="sub_life_used"  placeholder="Life Used" required>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="sub_tel">Phone Number</label>
								<div class="input-group">
									<input type="Number" class="form-control form-control-sm rounded-0" name="sub_tel" id="sub_tel"  placeholder="Subsidiary Telephone Number" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="sub_cat_id">Subsidiary Category</label>
								<div class="input-group">
								<select name="sub_cat_id" class="form-control form-control-sm" id="sub_cat_id">
									<option value="" disabled selected>-Select Category-</option>
									@foreach ($sub_categories as $sub_category)
										<option value="{{$sub_category->sub_cat_id}}">{{$sub_category->sub_cat_code}} - {{$sub_category->sub_cat_name}}</option>
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
									<input type="text" class="form-control form-control-sm rounded-0" name="sub_per_branch" id="sub_per_branch"  placeholder="Branch" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="sub_date">Date</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="sub_date" id="sub_date"  required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="sub_amount">Amount</label>
								<div class="input-group">
									<input type="number" class="form-control form-control-sm rounded-0" name="sub_amount" id="sub_amount"  placeholder="Amount" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="sub_no_amort">Amort</label>
								<div class="input-group">
									<input type="number" class="form-control form-control-sm rounded-0" name="sub_no_amort" id="sub_no_amort" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="sub_salvage">Salvage</label>
								<div class="input-group">
									<input type="number" class="form-control form-control-sm rounded-0" name="sub_salvage" id="sub_salvage"  placeholder="Salvage" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="sub_date_post">Date Post</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="sub_date_post" id="sub_date_post"  placeholder="Date Posted" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 text-right" style="padding-bottom:20px">
						<button class="btn btn-flat btn-sm bg-gradient-success " type="submit">Save/Update</button>
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
											<th>Date Posted</th>
											<th>Action</th>
										</thead>
										<tbody>
											@foreach ($subsidiaryData as $data)
												<tr>
													<td class="font-weight-bold">{{$data->sub_acct_no}}</td>
													<td>{{$data->sub_name}}</td>
													<td>{{$data->sub_address}}</td>
													<td>{{$data->sub_tel}}</td>
													<td>{{$data->sub_per_branch}}</td>
													<td>{{Carbon::parse($data->sub_dat)->format('m/d/Y')}}</td>
													<td>{{$data->sub_amount}}</td>
													<td>{{$data->sub_no_amort}}</td>
													<td>{{$data->sub_life_used}}</td>
													<td>{{$data->sub_salvage}}</td>
													<td>{{$data->sub_date_post}}</td>
													<td>
														<div class="btn-group">
															<button type="button" class="btn btn-xs btn-default btn-flat coa-action">Action</button>
															<a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
															<span class="sr-only">Toggle Dropdown</span>
															</a>
															<div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
																<a class="dropdown-item btn-edit-account subsid-view-info"  value="{{$data->sub_id}}" href="#">Edit</a>
																<a class="dropdown-item btn-edit-account subsid-delete"  value="{{$data->sub_id}}" href="#">delete</a>
															</div>
														</div>
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
  </div>
</section>	
<!-- /.content -->


@endsection


@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
  @include('scripts.reports.reports')
@endsection