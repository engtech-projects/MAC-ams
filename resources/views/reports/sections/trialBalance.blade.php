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
			<form id="getTrialBalance" method="get">
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
										<input v-model="filter.asof" value="{{ $transactionDate }}" type="date" class="form-control form-control-sm rounded-0" name="date" id="book_ref"  placeholder="Book Reference" required>
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
									@if(count($trialBalance["accounts"])==0)
									<tr><td>No data found.</td></tr>
									@endif
									<?php
										$totaldeb = 0;
										$totalcred = 0;
									?>
									@foreach($trialBalance["accounts"] as $category => $categoryData)
										<!-- <tr>
											<td colspan="4" class="font-weight-bold">{{ Str::upper($category) }}</td>
										</tr> -->
										@foreach($categoryData["types"] as $type => $typeData)
											@foreach($typeData["accounts"] as $accountIndex => $account)
											<tr>
												<td class="font-weight-bold">{{$account['account_number']}}</td>
												<!-- <td>{{$account['account_name']}}</td> -->
												<td>{{$account['account_name']}} </td>
												<td>{{in_array($category, ['assets', 'expense']) ? number_format($account['total'], 2, '.', ',') : ""}}</td>
												<td>{{in_array($category, ['liabilities', 'equity', 'revenue']) ? number_format($account['total'], 2, '.', ',') : ""}}</td>
											</tr>
											<?php
												switch ($category) {
													case 'assets':
														$totaldeb += $account['total'];
														break;
													case 'liabilities':
														$totalcred += $account['total'];
														break;
													case 'equity':
														$totalcred += $account['total'];
														break;
													case 'revenue':
														$totalcred += $account['total'];
														break;
													case 'expense':
														$totaldeb += $account['total'];
														break;
												}
											?>
											@endforeach
										@endforeach
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
