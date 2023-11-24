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
			<form id="" method="get">
				@csrf
				<input type="hidden" class="form-control form-control-sm rounded-0" name="bookId" id="bookId"  placeholder="" >
				<div class="row">
					<div class="col-md-12 frm-header">
						<h4 ><b>General Ledger</b></h4>
                        {{-- <table style="table-layout: fixed;" id="generalLedgerTbl"  class="table">
                            <thead>
                                <tr>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody class="generalLedgerTblContainer">
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{$transaction->account_number}} - {{$transaction->account_name}}</td>
                                        <td>{{ $transaction->journal_details_debit }}</td>
                                        <td>{{ $transaction->journal_details_credit }}</td>
                                        <td>{{ $transaction->balance }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
					</div>
					<!-- <div class="col-md-4 frm-header">
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
					</div> -->

					<div class="col-md-12" style="height:20px;"></div>
					<div class="col-md-6 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">Account Name</label>
								<div class="input-group">
									<select v-model="filter.account_id" name="account_id" class="form-control form-control-sm" id="" value="{{request('account_id')}}" required>
										<option value="all" selected>-All-</option>
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
									<input required v-model="filter.from" value="{{request('from')}}" type="date" class="form-control form-control-sm rounded-0" name="from" id="genLedgerFrom"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="genLedgerTo">To</label>
								<div class="input-group">
									<input required type="date" v-model="filter.to" value="{{request('to')}}" class="form-control form-control-sm rounded-0" name="to" id="genLedgerTo"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>

					</div>
                    <div class="col-md-2 col-xs-12">
                        <div class="box pt-4">
							<input type="submit" class="btn btn-success" value="Search">
                            <!-- <button id="searchledger" class="btn btn-success" type="button">Search</button> -->
                        </div>


					</div>

				</div>

				<div class="col-md-12" style="height:20px;"></div>
			</form>
		</div>
		<div class="co-md-12" style="height:10px;"></div>
		<div class="row">
          {{--   @foreach ($wew as $key => $accounts )
                {{$key}}
                @foreach  ($accounts['content'] as $account)
                    {{$account['account_id']}}
                @endforeach
            @endforeach --}}
			<div class="col-md-12">
					<!-- Table -->
					<section class="content">
						<div class="container-fluid">
							<div class="row" >
								<div class="col-md-12">
									<div id="external_filter_container"></div>

									<table style="table-layout: fixed;" id="generalLedgerTbl"  class="table">
										<thead>
											<th width="15%">Date</th>
											<th>Reference</th>
											<th width="26%">Preference Name</th>
											<th>Source</th>
											<th>Cheque Date</th>
											<th>Cheque No.</th>
											<th class="text-right">Debit</th>
											<th class="text-right">Credit</th>
											<th class="text-right">Balance</th>
										</thead>
										<tbody id="generalLedgerTblContainer">

											@foreach($journalItems as $items)

											<?php 
                                        		$totalDebit = 0;
                                        		$totalCredit = 0;
                                        		$balance = 0;
                                        	?>

											<tr class="account_name">
                                                <td  class="font-weight-bold">{{$items['account_number']}} - {{$items['account_name']}}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right">{{number_format($items['opening_balance'], 2, ".", ",")}}</td>
                                            </tr>

                                            	@foreach($items['data'] as $data)

                                            		<?php 
	                                            		$totalDebit += $data['debit'];
	                                            		$totalCredit += $data['credit'];
	                                            		$balance = $data['balance'];
	                                            	?>

                                            		<tr id="journal">
                                                     	<td>{{ $data['journal_date'] }}</td>
		                                                <td>{{ $data['journal_no'] }}</td>
		                                                <td>{{ $data['sub_name'] }}</td>
		                                                <td>{{ $data['source'] }}</td>
		                                                <td>{{ $data['cheque_date'] }}</td>
		                                                <td>{{ $data['cheque_no'] }}</td>
		                                                <td class="text-right">{{ $data['debit'] }}</td>
		                                                <td class="text-right">{{ $data['credit'] }}</td>
		                                                <td class="text-right">{{ $data['balance'] }}</td>
                                                    </tr>

                                            	@endforeach

                                            	<tr class="account_name">
	                                                <td></td>
	                                                <td></td>
	                                                <td class="font-weight-bold">Total</td>
	                                                <td></td>
	                                                <td></td>
	                                                <td></td>
	                                                <td class="font-weight-bold text-right">{{ number_format($totalDebit, 2, ".", ",") }}</td>
	                                                <td class="font-weight-bold text-right">{{ number_format($totalCredit, 2, ".", ",") }}</td>
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
	                                                <td class="font-weight-bold text-right">{{ number_format($balance, 2, ".", ",") }}</td>
	                                            </tr>


											@endforeach

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

<script>
	new Vue({
		el: '#app',
		data: {
			data: @json($transactions),
			filter:{
				from:@json(request('from'))?@json(request('from')):'',
				to:@json(request('to'))?@json(request('to')):'',
				account_id:@json(request('account_id'))?@json(request('account_id')):'all'
			},
			baseUrl: window.location.protocol + "//" + window.location.host
		},
		methods: {
			search:function(){
				console.log(this.filter);
				window.location.href = this.baseUrl + "/reports/generalLedger?from=" + this.filter.from + '&&to=' +  this.filter.to + '&&account_id=' +  this.filter.account_id;
			},
			logbook:function(e){
				console.log(e);
			}
		},
		mounted(){
			// for(var i in this.data){
			// 	if(this.data[i]){
			// 		console.log(this.data[i]);
			// 	}
			// }
		}
	});
</script>
@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection
