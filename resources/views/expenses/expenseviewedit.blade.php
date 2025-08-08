<foexpense" method="POST" action="">
  @csrf
</form>
<form id="frm-add-expense-details"></form>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="" class="label-normal">Payee <i class="fa fa-asterisk fa-xs text-red" aria-hidden="true"></i> </label>
        <select class="select2 form-control form-control-sm rounded-0" name="payee" required>
          <option></option>
          <optgroup label="Supplier">
          @foreach ($suppliers as $supplier)
            @if ( $supplier->supplier_id == $expenseItem['payee'] )
              <option value="{{ $supplier->supplier_id }}" data-type="supplier" selected>{{ ucwords($supplier->displayname) }}</option>
            @else
              <option value="{{ $supplier->supplier_id }}" data-type="supplier">{{ ucwords($supplier->displayname) }}</option>
            @endif
            
          @endforeach
          </optgroup>
        </select>
      </div>

      <div class="form-group">
        <label for="" class="label-normal">Account [<small>payment</small>]</label>
        <select class="select2 form-control form-control-sm rounded-0" name="account_id">
            <optgroup label="Assets">
            @foreach ($assets as $asset)
              @if ( $asset->account_id == $expenseItem['account_id'] )
                <option value="{{ $asset->account_id }}" selected>{{ ucwords($asset->account_name) }}</option>
              @else
                <option value="{{ $asset->account_id }}">{{ ucwords($asset->account_name) }}</option>
              @endif
              
            @endforeach
            </optgroup>
        </select>
      </div>
    </div>

    <div class="col-md-2">

      <div class="form-group row">
        <label for="" class="col-sm-12 col-md-12 label-normal">Payment method</label>
        <div class="col-sm-12 col-md-12">
          <select class="form-control form-control-sm rounded-0" name="payment_method_id">
            @foreach ($paymentMethod as $method)
              @if ( $method->payment_method_id == $expenseItem['payment_method_id'] )
                <option value="{{ $method->payment_method_id }}" selected>{{ ucwords($method->method) }}</option>
              @else
                <option value="{{ $method->payment_method_id }}">{{ ucwords($method->method) }}</option>
              @endif
              
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="" class="label-normal">Reference no.</label>
        <input type="text" class="form-control form-control-sm rounded-0" name="reference_no" value="{{ $expenseItem['reference_no'] }}">
      </div>
    </div>

    <div class="col-md-2">

      <div class="form-group">
        <label for="" class="label-normal">Payment date</label>
        <input type="date" class="form-control form-control-sm rounded-0" value="{{ $expenseItem['payment_date'] }}" name="payment_date">
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
          <h6>EXPENSE DETAILS</h6>
      </div>
    </div>
    <div class="col-md-12">
        
      <table class="table table-bordered table-sm" id="tbl-expense-details">
        <thead>
          <tr>
            <th width="70">#</th>
            <th width="300">Account</th>
            <th width="300">Description</th>
            <th class="text-right" width="200">Amount</th>
            <th width="70"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td>
              <select class="expense-details-select2 form-control form-control-sm rounded-0" id="select-expense-account" name="account_id" required>
                  <option></option>
                  <optgroup label="Expense">
                  @foreach ($expense as $ex)
                    <option value="{{ $ex->account_id }}">{{ ucwords($ex->account_name) }}</option>
                  @endforeach
                  </optgroup>
              </select>
            </td>
            <td>
              <input type="text" class="form-control form-control-sm rounded-0" id="input-description" name="description" placeholder="Add a description">
            </td>
            <td>
              <input type="text" class="form-control form-control-sm rounded-0 text-right" placeholder="0.00" name="amount" required>
            </td>
            <td class="text-center">
              <button type="submit" class="btn btn-sm btn-flat btn-default btn-add-expense-details">
                Add
              </button>
            </td>
          </tr>
          @foreach ($expenseItem['details'] as $items )
          <tr class="transaction-items">
            <td></td>
            <td>{{ $items['account_name'] }}</td>
            <td>{{ $items['description'] }}</td>
            <td class="text-right">{{ $items['amount'] }}</td>
            <td></td>
          </tr>
          @endforeach
          <tr style="background-color: #f1f1f1;" id="footer-row">
           
          </tr>
        </tbody>
      </table>

    </div>
  </div>

  <div class="col-md-4">

      <div class="form-group">
        <label for="" class="label-normal">Note</label>
        <textarea class="form-control form-control-sm rounded-0" style="resize: none" rows="3" name="note" value="{{ $expenseItem['note'] }}"></textarea>
      </div>
    </div>

  <div class="col-md-4"></div>

  <div class="row" style="border-top: 1px solid #f1f1f1; padding: 10px; margin-top:50px;">

    <div class="col-md-6">
      <small class="form-text">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit....</small>
    </div>
    <div class="col-md-6 text-right">
      <button type="button" class="btn btn-flat btn-default btn-sm" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-flat bg-gradient-success btn-sm">Save and Close</button>
    </div>

  </div>