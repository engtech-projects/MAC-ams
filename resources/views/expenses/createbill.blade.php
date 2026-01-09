<!--  -->
<style type="text/css">
  
  .remove-items:hover {
    cursor: pointer;
  }  

</style>


<form id="frm-create-bill" method="POST" action="{{ route('expenses.store') }}">
  <input type="hidden" name="transaction_type_id" value="{{ $transactionType->transaction_type_id }}">
  <input type="hidden" name="transaction_type" value="{{ $transactionType->transaction_type }}">
  <input type="hidden" name="account_id" value="{{ $transactionType->account_id }}">
  <input type="hidden" name="status" value="{{ $transactionStatus->status }}">
  @csrf
</form>

<form id="frm-add-expense-details"></form>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="" class="label-normal">Supplier <i class="fa fa-asterisk fa-xs text-red" aria-hidden="true"></i> </label>
        <select class="select2 form-control form-control-sm rounded-0" form="frm-create-bill" name="payee" required>
          <option></option>
          <optgroup label="Supplier">
          @foreach ($suppliers as $supplier)
              <option value="{{ $supplier->supplier_id }}" data-type="supplier">{{ ucwords($supplier->displayname) }}</option>
          @endforeach
          </optgroup>
        </select>
      </div>

      <div class="form-group">
        <label for="" class="label-normal">Bill no.</label>
        <input type="text" class="form-control form-control-sm rounded-0" name="bill_no" form="frm-create-bill">
      </div>

    </div>

    <div class="col-md-2">

      <div class="form-group">
        <label for="" class="label-normal">Bill date</label>
        <input type="date" class="form-control form-control-sm rounded-0" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" form="frm-create-bill" name="bill_date">
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-12 col-md-12 label-normal">Terms</label>
        <div class="col-sm-12 col-md-12">
          <select class="form-control form-control-sm rounded-0" form="frm-create-bill" name="term_id">
            <option></option>
            @foreach ($terms as $term)
              <option value="{{ $term->term_id }}">{{ ucwords($term->term) }}</option>
            @endforeach
          </select>
        </div>
      </div>

    </div>

    <div class="col-md-2">
      
      <div class="form-group">
        <label for="" class="label-normal">Due date</label>
        <input type="date" class="form-control form-control-sm rounded-0" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" form="frm-create-bill" name="due_date">
      </div>

    </div>

    <div class="col-md-4">
      <div class="small-box bg-default text-right">
        <div class="inner">
          <h3 id="total-amount">0.00</h3>
          <span class="text-muted">AMOUNT</span>
        </div>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="callout callout-success">
          <h6>BILL DETAILS</h6>
      </div>
    </div>
    <div class="col-md-12">
        
      <table class="table table-bordered table-sm" id="tbl-expense-details">
        <thead>
          <tr>
            <th>#</th>
            <th width="300">Account</th>
            <th width="300">Description</th>
            <th class="text-right" width="200">Amount</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td>
              <select class="expense-details-select2 form-control form-control-sm rounded-0" id="select-expense-account" name="account_id" form="frm-add-expense-details" required>
                  <option></option>
                  <optgroup label="Expense">
                  @foreach ($expense as $ex)
                    <option value="{{ $ex->account_id }}">{{ ucwords($ex->account_name) }}</option>
                  @endforeach
                  </optgroup>
              </select>
            </td>
            <td>
              <input type="text" class="form-control form-control-sm rounded-0" id="input-description" name="description" form="frm-add-expense-details" placeholder="Add a description">
            </td>
            <td>
              <input type="text" class="form-control form-control-sm rounded-0 text-right" placeholder="0.00" name="amount" form="frm-add-expense-details" required>
            </td>
            <td class="text-center">
              <button type="submit" form="frm-add-expense-details" class="btn btn-sm btn-flat btn-default btn-add-expense-details">
                Add
              </button>
            </td>
          </tr>
          <tr style="background-color: #f1f1f1;" id="footer-row">
            <td colspan="5">&nbsp;</td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>

  <div class="col-md-4">

      <div class="form-group">
        <label for="" class="label-normal">Note</label>
        <textarea class="form-control form-control-sm rounded-0" style="resize: none" rows="3" name="note" form="frm-create-bill"></textarea>
      </div>
  </div>

  <div class="col-md-4"></div>

  <div class="row" style="border-top: 1px solid #f1f1f1; padding: 10px; margin-top:50px;">

    <div class="col-md-6">
      <small class="form-text">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit....</small>
    </div>
    <div class="col-md-6 text-right">
      <button type="button" class="btn btn-flat btn-default btn-sm" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-flat bg-gradient-success btn-sm" form="frm-create-bill">Save and Close</button>
    </div>

  </div>