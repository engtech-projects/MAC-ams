@extends('layouts.app')

@section('content')

<style type="text/css">
	.dataTables_filter {
		float: left !important;
	}
	.nav-pills .nav-link.active, .nav-pills .show>.nav-link{
		background-color: #3d9970!important;
  		color: #fff!important;
		border-radius:0px;
	}
	.nav-link:hover, .nav-link:focus{
		background-color: #4ec891!important;
  		color: #fff!important;
		border-radius:0px;
		
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
						<h4 ><b>Trial Balance</b></h4>
					</div>
					
					<div class="col-md-12" style="height:20px;"></div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">From</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
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
		<div class="col-md-12">
			<!-- Table -->
			<section class="content">
				<div class="container-fluid">
					<div class="row" >
						<div class="col-md-12">
							<table id="subsidiaryledgerTbl"  class="table table-bordered">
								<thead>
									<th>Code</th>
									<th>Account Name</th>
									<th>Debit</th>
									<th>Credit</th>
									
								</thead>
								<tbody id="trialBalance">
									<?php 
										$totaldeb = 0;
										$totalcred = 0;
									?>
									@foreach($trialBalance as $data)
									<tr>
										<td class="font-weight-bold">{{$data->account_number}}</td>
										<td>{{$data->account_name}}</td>
										<td>{{number_format($data->total_debit, 2, '.', ',')}}</td>
										<td>{{number_format($data->total_credit, 2, '.', ',')}}</td>
									</tr>
									<?php 
										$totaldeb += $data->total_debit;
										$totalcred += $data->total_credit;
									?>
									@endforeach
									<tr>
										<td class="font-weight-bold"></td>
										<td></td>
										<td><b>{{number_format($totalcred, 2, '.', ',')}}</b></td>
										<td><b>{{number_format($totalcred, 2, '.', ',')}}</b></td>
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
</section>	
<!-- /.content -->


@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection