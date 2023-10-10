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
									<option value="1">Butuan CIty Branch</option>
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
								<input v-model="filter.from" name="from" type="date" value="{{request('from')}}" class="form-control form-control-sm">
							</div>
						</div>
						<div class="form-group" style="display:flex;align-items:center">
							<label class="label-normal" for="to" style="flex:1" >To:</label>
							<div class="input-group" style="flex:3">
								<input  v-model="filter.to" name="to" type="date" value="{{request('to')}}" class="form-control form-control-sm">
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
							<div class="row" >
								<div class="col-md-12">
									<div id="external_filter_container"></div>
									<!-- <table style="table-layout: fixed;" id="generalLedgerTbl"  class="table">
										<thead>
											<th width="15%">Date</th>
											<th width="26%">Preference Name</th>
											<th>Source</th>
											<th>Cheque Date</th>
											<th>Cheque No.</th>
											<th>Debit</th>
											<th>Credit</th>
											<th>Balance</th>
										</thead>
										<tbody id="generalLedgerTblContainer">
											<?php
												$id = '';
											?>
											@if(!empty($generalLedgerAccounts))

                                            <?php
                                                $total_credits = 0; $total_debits = 0; $balance = 0;
                                            ?>

                                                @foreach($transactions as $data)


                                                    @if($id == '')
                                                    <?php
                                                        $balance = $data->opening_balance;
                                                    ?>
                                                        <tr class="account_name">
                                                            <td  class="font-weight-bold">{{$data->account_number}} - {{$data->account_name}}</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{number_format($data->opening_balance, 2, ".", ",")}}</td>
                                                        </tr>

                                                        <?php
                                                            $id = $data->account_id;
                                                        ?>

                                                    @elseif($id != $data->account_id)
                                                    <?php
                                                        $balance = $data->opening_balance;
                                                    ?>
                                                        <tr class="totalRow">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{number_format($total_debits,2,",",".")}}</td>
                                                            <td>{{number_format($total_credits,2,",",".")}}</td>
                                                            <td></td>
                                                        </tr>

                                                        <tr class="account_name">
                                                            <td  class="font-weight-bold">{{$data->account_number}} - {{$data->account_name}}</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="debit"></td>
                                                            <td class="credit"></td>
                                                            <td class="balance">{{number_format($data->opening_balance, 2, ".", ",")}}</td>
                                                        </tr>

                                                        <?php
                                                            $total_credits=0;
                                                            $total_debits=0;
                                                            $id = $data->account_id;

                                                        ?>

                                                    @endif

                                                        <?php

                                                            $balance-=$data->journal_details_credit;
                                                            $balance+=$data->journal_details_debit;

                                                            $total_credits+=$data->journal_details_credit;
                                                            $total_debits+=$data->journal_details_debit;
                                                        ?>

                                                        <tr id="journal">
                                                            <td>{{$data->journal_date}}</td>
                                                            <td>{{$data->sub_name}}</td>
                                                            <td>{{$data->source}}</td>
                                                            <td>{{($data->cheque_date == '') ? '/' : $data->cheque_date}}</td>
                                                            <td>{{($data->cheque_no == '') ? '/' : $data->cheque_no}}</td>
                                                            <td>{{number_format($data->journal_details_debit, 2, ".", ",")}}</td>
                                                            <td>{{number_format($data->journal_details_credit, 2, ".", ",")}}</td>
                                                            <td>{{number_format($balance, 2, ".", ",")}}</td>

                                                        </tr>

                                            @endforeach

                                                <tr class="totalRow">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{number_format($total_debits,2,".",",")}}</td>
                                                    <td>{{number_format($total_credits,2,".",",")}}</td>
                                                    <td></td>
                                                </tr>

										@endif
										</tbody>
									</table> -->
									<table style="table-layout: fixed;" class="table table-bordered" id="journalLedgerTbl">
										<thead>
											<tr>
												<th>Date</th>
												<th>Reference</th>
												<th>Source</th>
												<th>Reference Name</th>
												<th></th>
												<th></th>
											</tr>
											<tr>
												<th></th>
												<th></th>
												<th>Account Title</th>
												<th>S/L</th>
												<th>Debit</th>
												<th>Credit</th>
											</tr>
										</thead>
										<tbody>
											@if (sizeof($jLedger)==0)
												<tr><td>No data found.</td></tr>
											@endif
											<tr style="border-bottom:2px solid #000;">
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											@foreach ($jLedger as $jl)
											<?php $totalDebit = 0; $totalCredit = 0; ?>
											<tr style="border-bottom:2px solid #000;">
												<td><b>{{$jl['date']}}</b></td>
												<td>{{$jl['reference']}}</td>
												<td>{{$jl['source']}}</td>
												<td colspan="3">{{$jl['reference_name']}}</td>
											</tr>
												@foreach ($jl['details'] as $jld)
												<?php $totalDebit += $jld['debit']; $totalCredit += $jld['credit']; ?>
												<tr>
													<td></td>
													<td>{{$jld['account']}}</td>
													<td>{{$jld['title']}}</td>
													<td>{{$jld['subsidiary']}}</td>
													<td>{{$jld['debit']==0?'':number_format($jld['debit'], 2, '.', ',')}}</td>
													<td>{{$jld['credit']==0?'':number_format($jld['credit'], 2, '.', ',')}}</td>
												</tr>
												@endforeach
											<!-- <tr>
												<td></td>
												<td>1350</td>
												<td>Advances to Officers and Employee</td>
												<td>Jomel</td>
												<td>3,100.00</td>
												<td></td>
											</tr>
											<tr>
												<td></td>
												<td>1010</td>
												<td>Cash On Hand</td>
												<td>00001</td>
												<td></td>
												<td>3,100.00</td>
											</tr> -->
											<tr>
												<td></td>
												<td style="border-top:2px solid #000;border-bottom:2px solid #000;"></td>
												<td style="border-top:2px solid #000;border-bottom:2px solid #000;"></td>
												<td style="border-top:2px solid #000;border-bottom:2px solid #000;"><b>Total</b></td>
												<td style="border-top:2px solid #000;border-bottom:2px solid #000;">{{$totalDebit==0?'':number_format($totalDebit, 2, '.', ',')}}</td>
												<td style="border-top:2px solid #000;border-bottom:2px solid #000;">{{$totalCredit==0?'':number_format($totalCredit, 2, '.', ',')}}</td>
											</tr>
											<tr>
												<td></td>
												<td colspan="2" style="font-size:16px">{{$jl['remarks']}}</td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											@endforeach
										</tbody>
									</table>
                                    <div class="d-flex">
                                        {{ $jLedger->links()}}
                                        {{-- {!! $generalLedgerAccounts->paginationLinks() !!} --}}
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
  </div>
</section>
<!-- /.content -->

<script>
	new Vue({
		el: '#app',
		data: {
			data: @json($jLedger),
			filter:{
				from:@json(request('from'))?@json(request('from')):'',
				to:@json(request('to'))?@json(request('to')):'',
				branch_id:@json(request('branch_id'))?@json(request('branch_id')):'',
				status:@json(request('status'))?@json(request('status')):'',
				book_id:@json(request('book_id'))?@json(request('book_id')):'',
				journal_no:@json(request('journal_no'))?@json(request('journal_no')):''
			},
			baseUrl: window.location.protocol + "//" + window.location.host
		},
		methods: {
			search:function(){
				console.log(this.filter);
				window.location.href = this.baseUrl + "/reports/journalledger?from=" + this.filter.from + '&&to=' +  this.filter.to + '&&branch_id=' +  this.filter.branch_id + '&&status=' +  this.filter.status + '&&book_id=' +  this.filter.book_id + '&&journal_no=' +  this.filter.journal_no;
			},
			logbook:function(e){
				console.log(e);
			}
		},
		mounted(){
			// console.log(this.data);
		}
	});
</script>
@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection
