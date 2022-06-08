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
			<form id="journalEntryForm" method="post">
				@csrf
				<input type="hidden" class="form-control form-control-sm rounded-0" name="journal_id" id="journal_id"  placeholder="" >
				<div class="row">
					<div class="col-md-8 frm-header">
						<h4 ><b>Journal Entry</b></h4>
					</div>
					<div class="col-md-4 frm-header">
						<label class="label-normal" for="date">Journal Date</label>
						<div class="input-group">
						<input type="date" class="form-control form-control-sm rounded-0" name="journal_date" id="journal_date"  placeholder="Journal Date" required>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="branch_id">Branch</label>
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
								<label class="label-normal" for="book_id">Book Reference</label>
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
									<input type="Number" class="form-control form-control-sm rounded-0" name="cheque_no" id="cheque_no"  placeholder="Cheque No" required>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="status">Status</label>
								<div class="input-group">
									<select name="book_id" class="form-control form-control-sm" id="book_id">
										<option value="" disabled >Posted</option>
										<option value="" disabled selected>Unposted</option>
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
									<input type="text" class="form-control form-control-sm rounded-0" name="payee" id="payee"  placeholder="Payee" required>
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
								<td value="" ></td>
								<td class='editable-table-data' value="" ><a href="#" ed-title="account_no" class="editable-row-item"></a> </td>
								<td class='editable-table-data' value="" ><a href="#" class="editable-row-item"></a> </td>
								<td class='editable-table-data' value="" ><a href="#" class="editable-row-item"></a> </td>
								<td class='editable-table-data' value="" >
									<select name="" class="form-control form-control-sm" id="" >
										<option value="" disabled selected>-Select S/L-</option>
										@foreach($journalBooks as $journalBook)
											<option value="{{$journalBook->book_id}}" book-src="{{$journalBook->book_src}}">{{$journalBook->book_name}}</option>
										@endforeach
									</select>
								</td>
								<td class='editable-table-data' value="" ><a href="#" class="editable-row-item"></a> </td>
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
				<button class="btn btn-flat btn-sm bg-gradient-success" > SAVE</button>
			</div>
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
			Launch demo modal
			</button>
		</div>
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
  @include('scripts.journal.journal')
@endsection