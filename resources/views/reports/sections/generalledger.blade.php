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
	#external_filter_container {
		display: inline-block;
	}

</style>

<!-- Main content -->
<section class="content" id="app">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<div class="row">
		<div class="col-md-12">
			<form id="frm-generate-ledger" method="get">
				@csrf
				<input type="hidden" class="form-control form-control-sm rounded-0" name="bookId" id="bookId"  placeholder="" >
				<div class="row">
					<div class="col-md-12 frm-header">
						<h4 ><b>General Ledger</b></h4>
					</div>
					
					<div class="col-md-12" style="height:20px;"></div>
					<div class="col-md-6 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">Account Name</label>
								<div class="input-group">
									<select v-model="filter.account_id" name="account_id" class="form-control form-control-sm" id="" value="{{request('account_id')}}" required>
										<!-- <option value="all" selected>-All-</option> -->
										@foreach($chartOfAccount as $data)
											<option value="{{$data->account_id}}">{{$data->account_number}} - {{$data->account_name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="genLedgerFrom">From</label>
								<div class="input-group">
									<input v-model="filter.from" value="{{ $requests['from'] }}" type="date" class="form-control form-control-sm rounded-0" name="from" id="genLedgerFrom" min="{{ $fiscalYear->start_date }}" max="{{ $fiscalYear->end_date }}" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="genLedgerTo">To</label>
								<div class="input-group">
									<input type="date" v-model="filter.to" value="{{ $requests['to'] }}" class="form-control form-control-sm rounded-0" name="to" id="genLedgerTo" min="{{ $fiscalYear->start_date }}" max="{{ $fiscalYear->end_date }}" required>
								</div>
							</div>
						</div>
					</div>
                    <div class="col-md-2 col-xs-12">
                        <div class="box pt-4">
							<input type="submit" class="btn btn-success" value="Search">
                        </div>
					</div>

				</div>

				<div class="col-md-12" style="height:20px;"></div>
			</form>
		</div>

		<div class="col-md-12">
			<div id="external_filter_container"></div>
			<table style="" id="generalLedgerTbl" class="table table-sm">
					<thead>
						<tr>
							<th width="10%">Date</th>
							<th width="10%">Reference</th>
							<th width="26%">Reference Name</th>
							<th>Source</th>
							<th>Cheque Date</th>
							<th>Cheque No.</th>
							<th class="text-right">Debit</th>
							<th class="text-right">Credit</th>
							<th class="text-right">Balance</th>
						</tr>
					</thead>

						@foreach($transactions as $transaction)

						<thead>
							<tr class="account_name">
	                            <td class="font-weight-bold" colspan="5">{{$transaction['account_number']}} - {{$transaction['account_name']}}</td>
	                            <td colspan="4" class="font-weight-bold text-right" style="padding-right: 10px;">{{ $transaction['balance'] }}</td>
	                        </tr>
                        </thead>

                        <tbody id="generalLedgerTblContainer">
                        	@foreach($transaction['entries'] as $entry)
                        	
                        		<tr id="journal">
                                 	<td>{{ $entry['journal_date'] }}</td>
                                    <td>{{ $entry['journal_no'] }}</td>
                                    <td>{{ $entry['sub_name'] }}</td>
                                    <td>{{ $entry['source'] }}</td>
                                    <td>{{ $entry['cheque_date'] }}</td>
                                    <td>{{ $entry['cheque_no'] }}</td>
                                    <td class="text-right">{{ $entry['debit'] }}</td>
                                    <td class="text-right">{{ $entry['credit'] }}</td>
                                    <td class="text-right">{{ $entry['current_balance'] }}</td>
                                </tr>

                                <thead>
									<tr>
										<td></td>
			                            <td colspan="8">
			                            	<div>Payee : {{ $entry['payee'] }}</div>
			                            	<div>{{ $entry['remarks'] }}</div>
			                            </td>
			                        </tr>
		                        </thead>

                        	@endforeach

                        	<tr class="account_name">
                                <td></td>
                                <td></td>
                                <td class="font-weight-bold">Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-weight-bold text-right">{{ $transaction['total_debit'] }}</td>
                                <td class="font-weight-bold text-right">{{ $transaction['total_credit'] }}</td>
                                <td></td>
                            </tr>

                            <tr class="account_name">
                                <td></td>
                                <td></td>
                                <td class="font-weight-bold">Net movement</td>
                                <td></td>
                                <td></td>
                                <td></td>
                               	<td></td>
                                <td></td>
                                <td class="font-weight-bold text-right">{{ $transaction['current_balance'] }}</td>
                            </tr>
                        </tbody>
						@endforeach
				</table>
		</div>
	
	</div>
  </div>
</section>
<!-- /.content -->

<script>
	// new Vue({
	// 	el: '#app',
	// 	data: {
	// 		data: @json($transactions),
	// 		filter:{
	// 			from:@json($requests['from'])?@json($requests['from']):'',
	// 			to:@json($requests['to'])?@json($requests['to']):'',
	// 			account_id:@json($requests['account_id'])?@json($requests['account_id']):'all'
	// 		},
	// 		baseUrl: window.location.protocol + "//" + window.location.host
	// 	},
	// 	methods: {
	// 		search:function(){
	// 			console.log(this.filter);
	// 			window.location.href = this.baseUrl + "/reports/generalLedger?from=" + this.filter.from + '&&to=' +  this.filter.to + '&&account_id=' +  this.filter.account_id;
	// 		},
	// 		logbook:function(e){
	// 			console.log(e);
	// 		}
	// 	},
	// 	mounted(){
	// 		// for(var i in this.data){
	// 		// 	if(this.data[i]){
	// 		// 		console.log(this.data[i]);
	// 		// 	}
	// 		// }
	// 	}
	// });
</script>
@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection
