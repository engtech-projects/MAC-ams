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
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<div class="row">
		<div class="col-md-12">
			<form id="bookJournalForm" method="post">
				@csrf
				<input type="hidden" class="form-control form-control-sm rounded-0" name="bookId" id="bookId"  placeholder="" >
				<div class="row">
					<div class="col-md-8 frm-header">
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

					<div class="col-md-12" style="height:20px;"></div>
					<div class="col-md-6 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="book_ref">Account Name</label>
								<div class="input-group">
									<select name="accountName" class="select-account form-control form-control-sm" id="genLedgerAccountName">
										<option value="" selected>-All-</option>
										@foreach($chartOfAccount as $data)
											<option value="{{$data->account_id}}">{{$data->account_number}} - {{$data->account_name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="genLedgerFrom">From</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="genLedgerFrom" id="genLedgerFrom"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div class="box">
							<div class="form-group">
								<label class="label-normal" for="genLedgerTo">To</label>
								<div class="input-group">
									<input type="date" class="form-control form-control-sm rounded-0" name="genLedgerTo" id="genLedgerTo"  placeholder="Book Reference" required>
								</div>
							</div>
						</div>
                        <button type="button" class="btn btn-success">Search</button>
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


@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection
