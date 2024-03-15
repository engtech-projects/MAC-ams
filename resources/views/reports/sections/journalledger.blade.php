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
			<form id="bookJournalForm" method="get">
				@csrf
				<input type="hidden" class="form-control form-control-sm rounded-0" name="bookId" id="bookId"  placeholder="" >
				<div style="display:flex;margin-bottom:32px;">
					<div style="display:flex;flex:1;flex-direction:column;margin-right:32px;">
						<div class="form-group" style="display:flex;align-items:center">
							<label class="label-normal" for="book_id" style="flex:1" >By Book</label>
							<div class="input-group" style="flex:3">
								<select @change="logbook($event)" v-model="filter.book_id" name="book_id" class="select-jl-bybook form-control form-control-sm" id="book_id">
									<option value="" disabled selected>-Select Book-</option>
									@foreach ($journalBooks as $journalBook)
									<option value="{{$journalBook->book_id}}" _count="{{$journalBook->book_code}}-{{sprintf('%006s',$journalBook->ccount + 1)}}" book-src="{{$journalBook->book_src}}">{{$journalBook->book_code}} - {{$journalBook->book_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<!-- <div class="form-group" style="display:flex;flex:1;align-items:center">
							<label class="label-normal" for="book_ref" style="flex:1" >Account Title</label>
							<div class="input-group" style="flex:3">
								<select name="jlAccountTitle" class="select-jl-account-title form-control form-control-sm" id="jlAccountTitle">
									<option value="" selected>-All-</option>
								</select>
							</div>
						</div>
						<div class="form-group" style="display:flex;flex:1;align-items:center">
							<label class="label-normal" for="book_ref" style="flex:1" >Subsidiary</label>
							<div class="input-group" style="flex:3">
								<select name="jlSubsidiary" class="select-jl-subsidiary form-control form-control-sm" id="jlSubsidiary">
									<option value="" selected>-All-</option>
								</select>
							</div>
						</div> -->
						<div class="form-group" style="display:flex;align-items:center">
							<label class="label-normal" for="branch_id" style="flex:1" >Branch</label>
							<div class="input-group" style="flex:3">
								<select v-model="filter.branch_id" name="branch_id" class="select-jl-branch form-control form-control-sm" id="jlBranch">
									<option value="" disabled selected>-Select Branch-</option>
									<option value="1">Butuan City Branch</option>
									<option value="2">Nasipit Branch</option>
								</select>
							</div>
						</div>
					</div>
					<div style="display:flex;flex:1;flex-direction:column;margin-right:32px;">
						<div class="form-group" style="display:flex;align-items:center">
							<label class="label-normal" for="status" style="flex:1" >Journal Status:</label>
							<div class="input-group" style="flex:3">
								<select v-model="filter.status" name="status" class="select-jl-status form-control form-control-sm" id="jlStatus">
								<option value="posted" selected>Posted</option>
									<option value="unposted">Unposted</option>
								</select>
							</div>
						</div>
						<div class="form-group" style="display:flex;align-items:center">
							<label class="label-normal" for="" style="flex:1" >Book Reference:</label>
							<div class="input-group" style="flex:3">
								<input v-model="filter.journal_no" name="journal_no" value="{{request('journal_no')}}" type="text" class="form-control form-control-sm">
							</div>
						</div>
					</div>
					<div style="display:flex;flex:1;flex-direction:column;">
						<div class="form-group" style="display:flex;align-items:center">
							<label class="label-normal" for="from" style="flex:1" >From:</label>
							<div class="input-group" style="flex:3">
								<input name="from" type="date" value="{{ $requests['from'] }}" class="form-control form-control-sm">
							</div>
						</div>
						<div class="form-group" style="display:flex;align-items:center">
							<label class="label-normal" for="to" style="flex:1" >To:</label>
							<div class="input-group" style="flex:3"> 
								<input name="to" type="date" value="{{ $requests['to'] }}" class="form-control form-control-sm">
							</div>
						</div>
						<div class="form-group" style="display:flex;align-items:center;justify-content:right;">
							<button class="btn btn-success" style="padding-left:32px;padding-right:32px;">Search</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 frm-header">
						<h4 ><b>Journal Ledger</b></h4>
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
							<div class="row">
								<div class="col-md-12">
									<div id="external_filter_container"></div>

									<table style="table-layout: fixed;" class="table table-bordered table-sm" id="journalLedgerTbl">
										<thead>
											<tr>
												<th width="10%">Date</th>
												<th width="15%">Reference</th>
												<th width="20%">Source</th>
												<th width="20%">Reference Name</th>
												<th width="15%"></th>
												<th width="15%"></th>
											</tr>
											<tr>
												<th></th>
												<th></th>
												<th>Account Title</th>
												<th>S/L</th>
												<th class="text-right">Debit</th>
												<th class="text-right">Credit</th>
											</tr>
										</thead>
										<tbody>
											@if (sizeof($jLedger)==0)
												<tr><td>No data found.</td></tr>
											@endif

											<tr style="border-bottom:2px solid #000;">
												<td colspan="6">&nbsp;</td>
												<td style="display:none"></td>
												<td style="display:none"></td>
												<td style="display:none"></td>
												<td style="display:none"></td>
												<td style="display:none"></td>
											</tr>
                                            <?php  $grandTotal =0;  ?>
											@foreach ($jLedger as $jl)
											<?php $totalDebit = 0; $totalCredit = 0;?>
											<tr style="border-bottom:2px solid #000;">
												<td><b>{{$jl['date']}}</b></td>
												<td>{{$jl['reference']}}</td>
												<td>{{$jl['source']}}</td>
												<td colspan="3">{{$jl['reference_name']}}</td>
												<td style="display:none"></td>
												<td style="display:none"></td>
											</tr>
											
											@foreach ($jl['details'] as $jld)
											<?php $totalDebit += $jld['debit']; $totalCredit += $jld['credit']; ?>
											<tr>
												<td width="10%"></td>
												<td width="15%">{{$jld['account']}}</td>
												<td width="20%">{{$jld['title']}}</td>
												<td width="20%">{{$jld["subsidiary"]}}</td>
												<td width="15%" class="text-right">{{$jld['debit']==0?'':number_format($jld['debit'], 2, '.', ',')}}</td>
												<td width="15%" class="text-right">{{$jld['credit']==0?'':number_format($jld['credit'], 2, '.', ',')}}</td>
											</tr>
											@endforeach

											<tr>
												<td></td>
												<td style="border-top:2px solid #000;border-bottom:2px solid #000;"></td>
												<td style="border-top:2px solid #000;border-bottom:2px solid #000;"></td>
												<td class="text-right" style="border-top:2px solid #000;border-bottom:2px solid #000;"><b>Total</b></td>
												<td class="text-right" style="border-top:2px solid #000;border-bottom:2px solid #000;">{{$totalDebit==0?'':number_format($totalDebit, 2, '.', ',')}}</td>
												<td class="text-right" style="border-top:2px solid #000;border-bottom:2px solid #000;">{{$totalCredit==0?'':number_format($totalCredit, 2, '.', ',')}}</td>
											</tr>
											<tr>
												<td></td>
												<td colspan="3" style="font-size:16px">{{$jl['remarks']}}</td>
												<td style="display:none"></td>
												<td style="display:none"></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td colspan="6">&nbsp;</td>
												<td style="display:none"></td>
												<td style="display:none"></td>
												<td style="display:none"></td>
												<td style="display:none"></td>
												<td style="display:none"></td>
											</tr>
													
											<!-- 	<td style="display:none"></td>
												<td style="display:none"></td>
												<td style="display:none"></td>
												<td style="display:none"></td>
												<td style="display:none"></td> -->
											<!-- </tr> -->
                                            <?php $grandTotal+=$totalDebit; ?>

											@endforeach

										</tbody>
                                        <tfoot>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right" style="border-top:2px solid #000;border-bottom:2px solid #000;"><b>Grand Total</b></td>
                                            <td class="text-right" style="border-top:2px solid #000;border-bottom:2px solid #000;"><b>{{number_format($grandTotal, 2, '.', ',') }}</b></td>
                                            <td></td>
                                        </tfoot>
									</table>
                                    {{-- <div class="d-flex">
                                        {{ $jLedger->links()}}
                                    </div> --}}
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
	// new Vue({
	// 	el: '#app',
	// 	data: {
	// 		data: @json($jLedger),
	// 		filter:{
	// 			from:@json(request('from'))?@json(request('from')):'',
	// 			to:@json(request('to'))?@json(request('to')):'',
	// 			branch_id:@json(request('branch_id'))?@json(request('branch_id')):'',
	// 			status:@json(request('status'))?@json(request('status')):'',
	// 			book_id:@json(request('book_id'))?@json(request('book_id')):'',
	// 			journal_no:@json(request('journal_no'))?@json(request('journal_no')):''
	// 		},
	// 		baseUrl: window.location.protocol + "//" + window.location.host
	// 	},
	// 	methods: {
	// 		search:function(){
	// 			// console.log(this.filter);
	// 			window.location.href = this.baseUrl + "/reports/journalledger?from=" + this.filter.from + '&&to=' +  this.filter.to + '&&branch_id=' +  this.filter.branch_id + '&&status=' +  this.filter.status + '&&book_id=' +  this.filter.book_id + '&&journal_no=' +  this.filter.journal_no;
	// 		},
	// 		logbook:function(e){
	// 			console.log(e);
	// 		}
	// 	},
	// 	mounted(){
	// 		// console.log(this.data);
	// 	}
	// });
</script>
@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection
