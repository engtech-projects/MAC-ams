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
<section class="content">
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

                            <select class="select-branch form-control form-control-sm" name="">
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
                            <input type="date" class="form-control form-control-sm">
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
            <table id="cash-blotter-tbl"  class="table table-sm table-bordered">
                <thead>
                    <th>Code</th>
                    <th>Branch</th>
                    <th>Transaction Date</th>
                    <th>Total Branch Collection</th>
                    <th>Action</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
	</div>
  </div>



  {{-- MODAL --}}

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


@endsection


@section('footer-scripts')
  @include('scripts.reports.reports')
@endsection
