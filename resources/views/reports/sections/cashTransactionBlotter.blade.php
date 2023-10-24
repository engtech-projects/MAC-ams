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
    .total-count {
        background: #4ec891
    }
    .table-header {
        font-size: 11px;

    }
    .select2 {
        width:100%!important;
    }
</style>

<!-- Main content -->
<section class="content" id="app">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
    <div class="row">

        <div class="col-md-12">
				<div class="row">
					<div class="col-md-12 frm-header">
						<h4 ><b>{{$title}}</b></h4>
					</div>
				</div>
                <div class="row">

                    <div class="col-md-3">
                        <label for="branch">Branch</label>
                        <div class="input-group">

                            <select class="select-branch form-control form-control-sm" name="branch_id">
                                <option value="" disabled selected>-Select Branch-</option>
                                @foreach ($branches as $branch)
                                    <option value="{{$branch->branch_id}}">{{$branch->branch_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="branch">Transaction Date</label>
                        <div class="input-group">
                            <input type="date" name="transaction_date" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-4 text-left">
                            <button class="btn btn-success">Search</button>
                        </div>

                    </div>

                    <div class="col-md-3">
                        <div class="mt-4 text-right">
                            <button type="button" class="btn btn-primary" data-type="create" id="create-cashblotter">New Transaction</button>
                        </div>

                    </div>
                </div>
        </div>

    </div>
	<div class="row">
        <div class="col-md-12 mt-5">
            <table id="cash-blotter-tbls"  class="table table-sm table-bordered">
                <thead>
                    <th>Code</th>
                    <th>Branch</th>
                    <th>Transaction Date</th>
                    <th>Total Branch Collection</th>
                    <th>Action</th>
                </thead>
                <tbody>
					<tr v-for="d in data">
						<td>@{{ d.branch_code }}</td>
						<td>@{{ d.branch_name }}</td>
						<td>@{{ d.transaction_date }}</td>
						<td>@{{ d.total_collection }}</td>
						<td>
							<button @click="showCashBlotter(d.collection_id,d.branch_id)" class="mr-1 btn btn-xs btn-success"><i class="fas fa-xs fa-eye" data-toggle="modal" data-target="#cashBlotterPreviewModal"></i></button>
							<button class="mr-1 btn btn-xs btn-warning" id="update-cashblotter"><i class="fas fa-xs fa-edit"></i></button>
							<button class="mr-1 btn btn-xs btn-danger"><i class="fas fa-xs fa-trash delete-cashblotter"></i></button>
							<button class="mr-1 btn btn-xs btn-primary"><i class="fas fa-xs fa-download download-cashblotter"></i></button>
							<button class="mr-1 btn btn-xs btn-default"><i class="fas fa-xs fa-print print-cashblotter"></i></button>
						</td>
					</tr>
                </tbody>
            </table>
        </div>
	</div>
  </div>



  {{-- MODAL --}}

  <div class="modal fade" id="cashBlotterPreviewModal" tabindex="2" role="dialog"
            aria-labelledby="JDetailsVoucherLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid ">
                            <div id="ui-view">
                                <div class="card">
                                    <div class="card-body" id="journal_toPrintVouch">
                                        <link rel="stylesheet"
                                            href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
                                        <link rel="stylesheet"
                                            href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
                                        <link rel="stylesheet" href="{{ asset('css/adminlte/adminlte.min.css') }}">
                                        <div class="col-md-12">
                                            <img src="{{ asset('img/mac_header.fw.png') }}" alt="mac_logo"
                                                class="img img-fluid">
                                        </div>
                                        <div class="col-md-12">
                                            <h3 style="text-align:center">Cashier's Transaction Blotter</h3>
                                        </div>
                                        <div class="row" style="padding-top:10px; border-bottom:10px solid gray;">
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Transaction Date: &nbsp;&nbsp;&nbsp; <strong
                                                            id="">October 13, 2023 10:38 AM</strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Branch: &nbsp;&nbsp;&nbsp; <strong
                                                            id="">00001 MAIN BRANCH - BUTUAN BRANCH</strong></h6>

                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Voucher Date: &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_date"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Reference No: &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_ref_no"></strong></h6>

                                                </div>
                                            </div> -->
                                        </div>
                                        <!-- <div class="row" style="padding-top:15px; border-bottom:10px solid gray;">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Voucher Source : &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_source"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Particular : &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_particular"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Amount : &nbsp;&nbsp;&nbsp; ₱ <strong
                                                            id="journal_voucher_amount"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Amount in words : &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_amount_in_words"
                                                            style="text-transform:capitalize;"></strong></h6>

										</div> -->
									</div>
								</div>
								<div class="table-responsive-sm" style="padding-top:5px;">
									<table class="table table-striped" style="border-top:4px dashed black;">
									<thead>
										<tr>
										<th class="center">DATE</th>
										<th>REFERENCE</th>
										<th>REFERENCE NAME</th>
										<th>SOURCE</th>
										<th>CHK DATE</th>
										<th>CHK NO.</th>
										<th class="center">CASH IN</th>
										<th class="right">CASH OUT</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="fb in filteredCashBlotter.rows">
											<td v-for="f in fb" v-html="f"></td>
										</tr>
										<!-- <tr>
											<td><strong>Beginning Balance</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong>100,000</strong></td>
											<td></td>
										</tr>
										<tr>
											<td>10/13/2023</td>
											<td>CDB-G05E21</td>
											<td>MAIN BRANCH - BUTUAN BRANCH</td>
											<td>POS - TRANS</td>
											<td>10/02/2023</td>
											<td>10/13/2023</td>
											<td>10,000</td>
											<td></td>
										</tr>
										<tr>
											<td>10/13/2023</td>
											<td>CDB-G05E21</td>
											<td>MAIN BRANCH - BUTUAN BRANCH</td>
											<td>POS - TRANS</td>
											<td>10/02/2023</td>
											<td>10/13/2023</td>
											<td>10,000</td>
											<td></td>
										</tr>
										<tr>
											<td>10/13/2023</td>
											<td>CDB-G05E21</td>
											<td>MAIN BRANCH - BUTUAN BRANCH</td>
											<td>POS - TRANS</td>
											<td>10/02/2023</td>
											<td>10/13/2023</td>
											<td></td>
											<td>10,000</td>
										</tr>
										<tr>
											<td>10/13/2023</td>
											<td>CDB-G05E21</td>
											<td>MAIN BRANCH - BUTUAN BRANCH</td>
											<td>POS - TRANS</td>
											<td>10/02/2023</td>
											<td>10/13/2023</td>
											<td></td>
											<td>10,000</td>
										</tr>
										<tr>
											<td>10/13/2023</td>
											<td>CDB-G05E21</td>
											<td>MAIN BRANCH - BUTUAN BRANCH</td>
											<td>POS - TRANS</td>
											<td>10/02/2023</td>
											<td>10/13/2023</td>
											<td></td>
											<td>10,000</td>
										</tr>
										<tr>
											<td>10/13/2023</td>
											<td>CDB-G05E21</td>
											<td>MAIN BRANCH - BUTUAN BRANCH</td>
											<td>POS - TRANS</td>
											<td>10/02/2023</td>
											<td>10/13/2023</td>
											<td></td>
											<td>10,000</td>
										</tr>
										<tr>
											<td><strong>Cash Ending Balance</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong>100,000</strong></td>
										</tr>
										<tr>
											<td><strong>Non Cash Received</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong></strong></td>
										</tr>
										<tr>
											<td><strong>POS Payment</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong></strong></td>
										</tr>
										<tr>
											<td>10/13/2023</td>
											<td>CDB-G05E21</td>
											<td>MAIN BRANCH - BUTUAN BRANCH</td>
											<td>POS - TRANS</td>
											<td>10/02/2023</td>
											<td>10/13/2023</td>
											<td>10,000</td>
											<td>10,000</td>
										</tr>
										<tr>
											<td><strong>Check Payment</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong></strong></td>
										</tr>
										<tr>
											<td><strong>PDC Deposit</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong></strong></td>
										</tr>
										<tr>
											<td><strong>Inter-branch Payment</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong></strong></td>
										</tr>
										<tr>
											<td><strong>COCI Beginning Balance</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong></strong></td>
										</tr>
										<tr>
											<td><strong>COCI Received</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong></strong></td>
										</tr>
										<tr>
											<td><strong>COCI Encashment</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong></strong></td>
										</tr>
										<tr>
											<td><strong>COCI Ending Balance</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong></strong></td>
										</tr>-->
										<tr style="border-top:4px dashed black;border-bottom:4px dashed black;">
											<td><strong>TOTAL</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td><strong>@{{formatCurrency(filteredCashBlotter.total.cashin)}}</strong></td>
											<td><strong>@{{formatCurrency(filteredCashBlotter.total.cashout)}}</strong></td>
										</tr> 
									</tbody>
									</table>
									<div class="row">
										<div class="col-md-4">
											<table class="table table-striped">
												<thead>
													<th>Cash Breakdown</th>
													<th>Pc(s)</th>
													<th>Total Amount</th>
												</thead>
												<tbody>
													<tr>
														<td>1,000</td>
														<td>3</td>
														<td>3,000</td>
													</tr>
													<tr>
														<td>500</td>
														<td>3</td>
														<td>1,500</td>
													</tr>
													<tr>
														<td>200</td>
														<td>3</td>
														<td>600</td>
													</tr>
													<tr>
														<td>100</td>
														<td>3</td>
														<td>300</td>
													</tr>
													<tr>
														<td>50</td>
														<td>3</td>
														<td>150</td>
													</tr>
													<tr>
														<td>20</td>
														<td>3</td>
														<td>60</td>
													</tr>
													<tr>
														<td>10</td>
														<td>3</td>
														<td>30</td>
													</tr>
													<tr>
														<td>1.00</td>
														<td>3</td>
														<td>3.00</td>
													</tr>
													<tr style="border-top:4px dashed black;">
														<td><strong>TOTAL CASH COUNT</strong></td>
														<td></td>
														<td><strong>25,000</strong></td>
													</tr>
													<tr style="border-bottom:4px dashed black;">
														<td><strong>TOTAL OTHERS</strong></td>
														<td></td>
														<td><strong>25,000</strong></td>
													</tr>
													<tr>
														<td><strong>TOTAL RECEIVED</strong></td>
														<td></td>
														<td><strong>50,000</strong></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-md-4">
										<table class="table table-striped">
											<thead>
												<th>Account Officer</th>
												<th>Total Amount</th>
											</thead>
											<tbody>
												<tr>
													<td>jml-452433-221</td>
													<td>3,000</td>
												</tr>
												<tr>
													<td>jml-452433-221</td>
													<td>3,000</td>
												</tr>
												<tr>
													<td>jml-452433-221</td>
													<td>3,000</td>
												</tr>
												<tr>
													<td>jml-452433-221</td>
													<td>3,000</td>
												</tr>
												<tr>
													<td>jml-452433-221</td>
													<td>3,000</td>
												</tr>
												<tr style="border-top:4px dashed black;border-bottom:4px dashed black;">
													<td><strong>TOTAL COLLECTION</strong></td>
													<td><strong>25,000</strong></td>
												</tr>
											</tbody>
										</table>
										</div>
										<div class="col-md-4">
										<table class="table table-striped">
											<thead>
												<th>Other Cash Received</th>
												<th>Total Amount</th>
											</thead>
											<tbody>
												<tr>
													<td></td>
													<td>3,000</td>
												</tr>
												<tr>
													<td></td>
													<td>3,000</td>
												</tr>
												<tr>
													<td></td>
													<td>3,000</td>
												</tr>
												<tr style="border-top:4px dashed black;border-bottom:4px dashed black;">
													<td><strong>TOTAL CASH OTHERS</strong></td>
													<td><strong>25,000</strong></td>
												</tr>
											</tbody>
										</table>
										</div>
									</div>
								</div>
								<div style="margin-top: 24px;">
									<p style="font-size:16px;"><span style="padding-left:32px">I HEREBY CERTIFY that the above total cash and COCI is in my possession as my CASH ON HAND.</span> </br> <span>As Branch Cashier I am aware the the said amount is my cash accountability to MICRO ACCESS LOAN CORP.</span></p>
									<div style="display:flex;margin-top:45px;">
										<div style="flex:1;border-bottom:1px solid #000;margin-right:32px;padding-bottom:32px;">
											<span>Prepared By:</span>
										</div>
										<div style="flex:1;border-bottom:1px solid #000;margin-right:32px;padding-bottom:32px;">
											<span>Certified Corrected By:</span>
										</div>
										<div style="flex:1;border-bottom:1px solid #000;margin-right:32px;padding-bottom:32px;">
											<span>Approved By:</span>
										</div>
										<div style="flex:1">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 col-sm-5">
									</div>
									<div class="col-lg-4 col-sm-5 ml-auto">
									<!-- <table class="table table-clear" style="padding-right:232px">
										<tbody>
										<tr>
											<td class="left">
											<strong>TOTAL</strong>
											</td>
											<td class="left">₱ <strong id="journal_total_debit_voucher"></strong></td>
											<td class="left">₱ <strong id="journal_total_credit_voucher"></strong></td>
										</tr>
										</tbody>
									</table> -->
									<div>
										<button class="btn btn-success float-right no-print" data-dismiss="modal" style="padding:5px 32px">Print</button>
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

  <div class="modal fade bd-example-modal-lg" id="Mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <form id="add-cash-blotter">
            @csrf
        <div class="container">
            <div class="row">
                <div class="col-md-12 frm-header">
                    <h4 id="title"><b></b></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                   <div class="row">
                    <div class="col-sm-3">
                        <label for="branch">Branch</label>
                        <div class="input-group" width="100%">

                            <select id="select_branch" name="branch_id" class="select-branch form-control-sm form-control" name="" required>
                              <option value="" disabled selected>-Select Branch-</option>
                              @foreach ($branches as $branch)
                                  <option value="{{$branch->branch_id}}">{{$branch->branch_name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="branch">Transaction Date</label>
                        <div class="input-group">
                            <input type="date" name="transaction_date" class="form-control form-control-sm" required>
                        </div>
                    </div>
                   </div>
                </div>
            </div>


            <div class="container pl-4">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="row">
                            <form id="add-cash-blotter" method="POST">
                            <table class="table table-sm cash-breakdown-tbl">
                                <thead>
                                    <th class="table-header">Cash Breakdown</th>
                                    <th class="table-header">Pcs.</th>
                                    <th class="table-header">Total Amount</th>
                                </thead>
                                <tbody>
                                    <tr class="cash-breakdown">
                                      <td>₱1000</td>
                                      <td><input type="number" name="onethousand" id="onethousand" class="form-control form-control-sm pcs" required></td>
                                      <td id="onethousandtotalamount" class="total">0</td>
                                    </tr>
                                    <tr class="cash-breakdown">
                                        <td>₱500</td>
                                        <td><input type="number" name="fivehundred" id="fivehundred" class="form-control form-control-sm pcs" required></td>
                                        <td id="fivehundredtotalamount" class="total">0</td>
                                    </tr>
                                    <tr class="cash-breakdown">
                                        <td>₱200</td>
                                        <td><input type="number" name="twohundred" id="twohundred" class="form-control form-control-sm" required></td>
                                        <td id="twohundredtotalamount" class="total">0</td>
                                    </tr>
                                    <tr class="cash-breakdown">
                                        <td>₱100</td>
                                        <td><input type="number" name="onehundred" id="onehundred" class="form-control form-control-sm" required></td>
                                        <td id="onehundredtotalamount" class="total">0</td>
                                    </tr>
                                    <tr class="cash-breakdown">
                                        <td>₱50</td>
                                        <td><input type="number" name="fifty" id="fifty" class="form-control form-control-sm" required></td>
                                        <td id="fiftytotalamount" class="total">0</td>
                                    </tr>
                                    <tr class="cash-breakdown">
                                        <td>₱20</td>
                                        <td><input type="number" name="twenty" id="twenty" class="form-control form-control-sm" required></td>
                                        <td id="twentytotalamount" class="total">0</td>
                                    </tr>
                                    <tr class="cash-breakdown">
                                        <td>₱10</td>
                                        <td><input type="number" name="ten" id="ten" class="form-control form-control-sm" required></td>
                                        <td id="tentotalamount" class="total">0</td>
                                    </tr>
                                    <tr class="cash-breakdown">
                                        <td>₱5</td>
                                        <td><input type="number" name="five" id="five" class="form-control form-control-sm" required></td>
                                        <td id="fivetotalamount" class="total">0</td>
                                    </tr>
                                    <tr class="cash-breakdown">
                                        <td>₱1</td>
                                        <td><input type="number" name="one" id="one" class="form-control form-control-sm" required></td>
                                        <td id="onetotalamount" class="total">0</td>
                                    </tr>
                                    <tr class="cash-breakdown">
                                        <td>₱0.25</td>
                                        <td><input type="number" name="centavo" id="centavo" class="form-control form-control-sm" required></td>
                                        <td id="centavototalamount" class="total">0</td>
                                    </tr>

                                  </tbody>
                                  <tfoot>
                                    <tr>
                                        <td colspan="3"><p>Total Cash Count</p></td>
                                    </tr>
                                    <tr>

                                        <td class="text-right bg-primary" colspan="3" id="totalcashcount"><b>0</b></td>
                                    </tr>
                                  </tfoot>
                            </table>

                            </form>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-12 col-sm-12">

                            <table class="table table-bordered table-sm" id="account-officer-table-collection">
                              <thead class="table-header">
                                <tr>
                                    <th width="200">Account Officer</th>
                                    <th>Remarks</th>
                                    <th>Total Amount</th>
                                    <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <select class="account-officer select-officer form-control form-control-sm rounded-0" name="accountofficer_id" id="accountofficer_id" form="frm-add-account-officer-details">
                                        <option class="default-select" value="" disabled selected>Select-Officer</option>
                                         @foreach ($account_officers as $account_officer)
                                            <option value="{{$account_officer->accountofficer_id}}">{{$account_officer->name}}</option>
                                        @endforeach

                                    </select>
                                  </td>
                                  <td>
                                    <input type="text" id="remarks" class="form-control form-control-sm rounded-0" name="remarks" form="frm-add-account-officer-details" placeholder="Remarks">
                                  </td>
                                  <td>
                                    <input type="text" class="form-control form-control-sm rounded-0 text-right" id="total_amount" placeholder="0.00">
                                  </td>
                                  <td class="text-center">
                                    <button type="button" id="btn-add-account-officer-collection" class="btn btn-xs btn-primary add-accounting-officer">
                                      <i class="fas fa-plus fa-xs"></i>
                                    </button>
                                  </td>
                                </tr>
                                <tr id="footer-row">
                                  <td colspan="7"></td>
                                </tr>
                              </tbody>
                              <tfoot>
                                <tr>
                                    <td colspan="4"><p>Total A/O Collection</p></td>
                                </tr>
                                <tr>

                                    <td class="text-right bg-primary" colspan="4" id="totalaccountofficercollection"><b>0</b></td>
                                </tr>
                              </tfoot>
                            </table>


                          </div>

                          <div class="col-md-12">
                            <table class="table table-bordered table-sm" id="account-officer-table">
                              <thead class="table-header">
                                <tr>
                                    <th width="200">Branch Collection</th>
                                    <th>Total Amount</th>
                                    <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <select class="select-branch form-control form-control-sm rounded-0" id="branch_id">
                                      <option value="" disabled selected>-Select Branch-</option>
                                      @foreach ($branches as $branch)
                                          <option value="{{$branch->branch_id}}">{{$branch->branch_name}}</option>
                                      @endforeach

                                    </select>
                                  </td>
                                  <td>
                                    <input type="text" class="form-control form-control-sm rounded-0 text-right" id="branchcollection_amount" placeholder="0.00">
                                  </td>
                                  <td class="text-center">
                                    <button type="button" class="btn btn-xs btn-primary" id="btn-add-branch-collection">
                                      <i class="fas fa-plus fa-xs"></i>
                                    </button>
                                  </td>
                                </tr>
                                <tr style="background-color: #f1f1f1;" id="branch-collection-row">
                                  <td colspan="7">&nbsp;</td>
                                </tr>
                              </tbody>
                              <tfoot>
                                <tr>
                                    <td colspan="4"><p>Total Branch Collection</p></td>
                                </tr>
                                <tr>

                                    <td class="text-right bg-primary" colspan="4" id="totalbranchcollection"><b>0</b></td>
                                </tr>
                              </tfoot>
                            </table>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success">Post</button>
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
<script>
	new Vue({
		el: '#app',
		data: {
			data: @json($cash_blotter),
			entries:{
						begining_balance:{},
						cash_received:[],
						cash_paid:[],
						non_cash_received:[],
						pos_payment:[],
						check_payment:[],
						pdc_deposit:[],
						interbranch:[],
						coci_beginning_balance:[],
						coci_received:[],
						coci_encashment:[],
					},
			collection:[],
		},
		methods: {
			showCashBlotter:function(id,branch){
				axios.get('/reports/cashTransactionBlotter/showcashblotter/' + id,{params:{branch_id:branch}}) // Replace with your API endpoint
                    .then(response => {
                        // this.responseData = response.data;
						// this.entries = response.data['entries'];
						this.arrangeData( response.data['entries']);
						console.log(response.data);
                    })
                    .catch(error => {
                        console.error(error);
                    });
			},
			arrangeData:function(data){
				for(var i in this.entries){
					var entry = this.entries[i];
					for(var k in data){
						if(i == k){
							this.entries[i] = data[k];
						}
					}
				}
				console.log(this.entries);
			},
			upperWords:function(inputString) {
				var stringWithSpaces = inputString.replace(/_/g, ' ');
				var words = stringWithSpaces.split(' ');
				for (var i = 0; i < words.length; i++) {
					words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
				}
				var result = words.join(' ');

				return result;
			},
			noZero:function(val){
				return val==0?'':this.formatCurrency(val);
			},
			formatCurrency:function(amount) {
				amount = parseFloat(amount);
				if (isNaN(amount)) {
					return "Invalid Number";
				}
				amount = amount.toFixed(2);

				amount = amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

				return amount;
				}
		},
		computed:{
			filteredCashBlotter:function(){
				var rows = [];
				var cashEndingBalance = 0;
				totalCashIn = 0;
				totalCashOut = 0;
				for(var i in this.entries){
					var entry = this.entries[i];
					var row = ['','','','','','','',''];
					if(i.toLowerCase() != 'collections'){
						if(i.toLowerCase() == 'begining_balance'){
							cashEndingBalance += parseFloat(entry.total);
							totalCashIn += parseFloat(entry.total);
							row[0] = '<b>Beginning Balance</b>';
							row[6] = `<b>` + this.formatCurrency(entry.total) + `</b>`;
							rows.push(row);
						}else{
							row[0] = '<b>' + this.upperWords(i) + '</b>';
							rows.push(row);
							for(var k in entry){
								var journal = entry[k];
								totalCashIn += parseFloat(journal.journal_details[0].cash_in);
								totalCashOut += parseFloat(journal.journal_details[0].cash_out);
								if(i == 'cash_received'){
									cashEndingBalance += parseFloat(journal.journal_details[0].cash_in);
								}else if(i == 'cash_paid'){
									cashEndingBalance -= parseFloat(journal.journal_details[0].cash_out);
								}
								var mrow = ['','','','','','','',''];
								mrow[0] = journal.journal_date;
								mrow[1] = journal.journal_no;
								mrow[2] = journal.branch.branch_name;
								mrow[3] = journal.source;
								mrow[4] = journal.cheque_date;
								mrow[5] = journal.cheque_no;
								mrow[6] = journal.journal_details?this.noZero(journal.journal_details[0].cash_in):'';
								mrow[7] = journal.journal_details?this.noZero(journal.journal_details[0].cash_out):'';
								rows.push(mrow);
							}
							if(i == 'cash_paid'){
								rows.push(['<b>Cash Ending Balance</b>','','','','','',cashEndingBalance>0?'<b>'+this.formatCurrency(cashEndingBalance)+'</b>':'',cashEndingBalance<=0?'<b>'+this.formatCurrency(cashEndingBalance)+'</b>':''])
							}
						}
						// 
						
					}
				}
				return {rows:rows,total:{cashin:totalCashIn,cashout:totalCashOut}};
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
