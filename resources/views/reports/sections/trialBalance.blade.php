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
<section class="content" id="app">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<div class="row">
		<div class="col-md-12">
			<form id="bookJournalForm" method="get">
				@csrf
				<input type="hidden" class="form-control form-control-sm rounded-0" name="bookId" id="bookId"  placeholder="" >
				<div class="row">
					<div class="col-md-8 frm-header">
						<h4 ><b>Trial Balance</b></h4>
					</div>

					<div class="col-md-12" style="height:20px;"></div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div style="display:flex;align-items:center">
								<div class="form-group" style="flex:1">
									<label class="label-normal" for="book_ref">As of</label>
									<div class="input-group">
										<input disabled v-model="filter.asof" type="date" class="form-control form-control-sm rounded-0" name="asof" id="book_ref"  placeholder="Book Reference" required>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<!-- <label class="label-normal" for="book_ref">To</label> -->
								<div class="input-group" style="padding-top:30px">
									<input type="submit" value="Generate" style="max-width:150px" class="form-control form-control-sm rounded-0 btn btn-success btn-sm">
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
									@if(count($paginated)==0)
									<tr><td>No data found.</td></tr>
									@endif
									<?php
										$totaldeb = 0;
										$totalcred = 0;
									?>
									@foreach($paginated as $data)
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
							<div style="display:flex;justify-content:flex-end;margin-top:32px;">
								{{ $paginated->appends(request()->query())->links('pagination::bootstrap-4') }}
							</div>
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
<script>
	new Vue({
		el: '#app',
		data: {
			filter:{
				asof:@json($transactionDate),
			},
			baseUrl: window.location.protocol + "//" + window.location.host
		},
		methods: {
			search:function(){
				window.location.href = this.baseUrl + "/reports/trialBalance?asof=" + this.filter.asof;
			},
		},
		mounted(){
			// console.log(this.baseUrl);
		}
	});
</script>

@endsection



@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection
