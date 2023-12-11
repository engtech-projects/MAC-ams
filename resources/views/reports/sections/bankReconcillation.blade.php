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
			<form @submit.prevent="fetchReconciliation" id="bookJournalForm" method="post">
				@csrf
				<input type="hidden" class="form-control form-control-sm rounded-0" name="bookId" id="bookId"  placeholder="" >
				<div class="row">
					<div class="col-md-12 frm-header">
						<h4 ><b>Bank Reconcillation</b></h4>
					</div>

					<div class="col-md-12" style="height:20px;"></div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">Account Name</label>
								<div class="input-group">
									<select v-model="filter.account_id" name="account_id" class="form-control form-control-sm" id="" value="{{request('account_id')}}" required>
										<option value="all" selected>-All-</option>
										<option v-for="acc,a in filteredAccounts" :key="a" :value="acc.account_id">@{{acc.account_number}} - @{{acc.account_name}}</option>
										<!-- @foreach($chartOfAccount as $data)
											<option value="{{$data->account_id}}">{{$data->account_number}} - {{$data->account_name}}</option>
										@endforeach -->
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">Bank Balance</label>
								<div class="input-group">
									<input v-model="bankBalance" type="number" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="0.00" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">From</label>
								<div class="input-group">
									<input v-model="filter.date_from" type="date" class="form-control form-control-sm rounded-0" name="date_from" id="dateFrom" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">To</label>
								<div class="input-group">
									<input v-model="filter.date_to" type="date" class="form-control form-control-sm rounded-0" name="date_to" id="dateTo" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<div class="box pt-4">
									<input type="submit" class="btn btn-success" value="Search" style="width:60%">
									<!-- <button id="searchledger" class="btn btn-success" type="button">Search</button> -->
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
							<table  class="table table-bordered">
								<thead>
									<th>Ref Date</th>
									<th>Source</th>
									<th>Trn Date</th>
									<th>Check No.</th>
									<th>Deposits</th>
									<th>Withdrawals</th>
									<th>Status</th>
								</thead>
								<tbody>
									<tr v-if="!processedData.length">
										<td colspan="7"><center>No data available in table.</b></td>
									</tr>
									<tr v-for="rd,i in processedData[0]?.entries" :key="i">
										<td>@{{rd.journal_date}}</td>
										<td>@{{rd.source}}</td>
										<td>@{{rd.journal_date}}</td>
										<td>@{{rd.cheque_no}}</td>
										<td>@{{rd.deposits!=0?formatCurrency(rd.deposits):''}}</td>
										<td>@{{rd.withdrawals!=0?formatCurrency(rd.withdrawals):''}}</td>
										<td>@{{rd.status}}</td>
									</tr>
								</tbody>
							</table>
							<!-- <div v-if="processedData.entries.length" class="d-flex" style="width:100%;justify-content:space-between;margin-top:45px;">
								<div class="d-flex flex-column">
									<b>MICRO ACCESS LOANS CORPORATION</b>
									<span>Bank Reconciliation (@{{processedData.account_name}})</span>
									<span>From @{{filter.date_from}} To @{{filter.date_to}}</span>
								</div>
								<div class="d-flex flex-column">
									<span>Monday, 11/22/2023 GLS</span>
									<span>1:58 PM</span>
								</div>
							</div> -->
							<table v-if="processedData.length" class="table" style="margin-top:45px;border-top:4px dashed #000">
								<thead>
									<th></th>
									<th>CLEARED</th>
									<th>UNCLEARED</th>
									<th>TOTALS</th>
								</thead>
								<tbody>
									<tr>
										<td>Per Books Beg. Bal: </td>
										<td>0.00</td>
										<td>0.00</td>
										<td>0.00</td>
									</tr>
									<tr>
										<td>Deposits: </td>
										<td>@{{formatCurrency(processedData.totalDepositsCleared)}}</td>
										<td>@{{formatCurrency(processedData.totalDepositsUncleared)}}</td>
										<td>@{{formatCurrency(processedData.totalDepositsCleared + processedData.totalDepositsUncleared)}}</td>
									</tr>
									<tr>
										<td>Withdrawals: </td>
										<td>@{{formatCurrency(processedData.totalWithdrawalsCleared)}}</td>
										<td>@{{formatCurrency(processedData.totalWithdrawalsUncleared)}}</td>
										<td>@{{formatCurrency(processedData.totalWithdrawalsCleared + processedData.totalWithdrawalsUncleared)}}</td>
									</tr>
									<tr>
										<td></td>
										<td class="text-right"><b>Per Books Ending Balance: </b></td>
										<td></td>
										<td>0.00</td>
									</tr>
									<tr>
										<td></td>
										<td class="text-right"><b>Bank Statement Balance: </b></td>
										<td></td>
										<td>@{{formatCurrency(bankBalance)}}</td>
									</tr>
									<tr>
										<td></td>
										<td class="text-right"><b>Adjustments/Reconciling Diff: </b></td>
										<td></td>
										<td>0.00</td>
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
				account_id:'',
				date_from:'',
				date_to:''
			},
			accounts:@json($chartOfAccount),
			bankBalance:'0.00',
			reconData:[],
			url:"{{route('reports.bank.reconciliation')}}",
		},
		methods: {
			fetchReconciliation:function(){
				axios.post(this.url, this.filter, {
					headers: {
						'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
					}
				})
				.then(response => {
					var arr = [];
					arr.push(response.data);
					this.reconData = arr;
				})
				.catch(error => {
					console.error('Error:', error);
				});
			},
			formatCurrency:function(number) {
				const formatter = new Intl.NumberFormat('en-US', {
					style: 'decimal',
					minimumFractionDigits: 2,
				});

				return formatter.format(number);
			}

		},
		computed:{
			processedData:function(){
				if(this.reconData.length){

					this.reconData[0].totalDepositsCleared = 0;
					this.reconData[0].totalDepositsUncleared = 0;
					this.reconData[0].totalWithdrawalsCleared = 0;
					this.reconData[0].totalWithdrawalsUncleared = 0;
					this.reconData[0][0].entries.forEach(data => {
						if(data.status.toLowerCase() == 'cleared'){
							this.reconData[0].totalDepositsCleared += parseFloat(data.deposits);
							this.reconData[0].totalWithdrawalsCleared += parseFloat(data.withdrawals);
						}else{
							this.reconData[0].totalDepositsUncleared += parseFloat(data.deposits);
							this.reconData[0].totalWithdrawalsUncleared += parseFloat(data.withdrawals);
						}
					});
					return this.reconData[0];
				}
				return {entries:[]}
			},
			filteredAccounts:function(){
				var valid = ['1025','1026','1045','1060','1050','1055','1260'];
				var result = [];
				for(var i in valid){
					var vd = valid[i];
					for(var m in this.accounts){
						var acc = this.accounts[m];
						if(vd == acc.account_number){
							result.push(acc);
						}
					}
				}
				return result;
			}
		},
		mounted(){
			// this.fetchReconciliation();
		}
	});
</script>
@endsection

@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection
