<form method="POST" action="{{ route('payment.store') }}" id="frm-payment">
  <input type="hidden" name="transaction_type_id" value="{{ $transactionType->transaction_type_id }}">
  <input type="hidden" name="transaction_type" value="{{ $transactionType->transaction_type }}">
  <input type="hidden" name="transaction" value="{{ $transaction->transaction_type }}">
  <input type="hidden" name="default_account" value="{{ $transactionType->account_id }}">
  @csrf
</form>

  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="" class="label-normal">Customer <i class="fa fa-asterisk fa-xs text-red" aria-hidden="true"></i> </label>
        <select class="select2 form-control form-control-sm rounded-0" disabled>
          @foreach ($customers as $customer)
              @if( $customer->customer_id == $transaction->invoice->customer_id )
                <option value="{{ $customer->customer_id }}">{{ ucwords($customer->displayname) }}</option>
              @else
                <option value="{{ $customer->customer_id }}">{{ ucwords($customer->displayname) }}</option>
              @endif
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="" class="label-normal">Deposit to </label>
        <select class="select2 form-control form-control-sm rounded-0" name="account_id" form="frm-payment" required>
          <optgroup label="Assets">
          @foreach ($assets as $asset)
            <option value="{{ $asset->account_id }}">{{ $asset->account_name }}</option>
          @endforeach
        </select>
        </optgroup>
      </div>

    </div>

    <div class="col-md-2">

      <div class="form-group">
        <label for="" class="label-normal">Payment date</label>
        <input type="date" class="form-control form-control-sm rounded-0" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="payment_date" form="frm-payment">
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-12 col-md-12 label-normal">Payment method</label>
        <div class="col-sm-12 col-md-12">
          <select class="form-control form-control-sm rounded-0" name="payment_method_id" form="frm-payment">
            @foreach ($paymentMethod as $method)
              <option value="{{ $method->payment_method_id }}">{{ ucfirst($method->method) }}</option>
            @endforeach
          </select>
        </div>
      </div>

    </div>

    <div class="col-md-2">

      <div class="form-group">
        <label for="" class="label-normal">Reference no.</label>
        <input type="text" class="form-control form-control-sm rounded-0" name="reference_no" form="frm-payment">
      </div>

    </div>

    <div class="col-md-4">
      <div class="small-box bg-default text-right">
        <div class="inner">
          <h3 id="amount-received" class="amnt-rcv">{{  $transaction->invoice->balance }}</h3>
          <span class="text-muted">AMOUNT RECEIVED</span>
        </div>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="callout callout-success">
          <h6>Outstanding Transactions</h6>
      </div>
    </div>
    <div class="col-md-12">

      <table class="table table-bordered table-sm" id="tbl-expense-details">
        <thead>
          <tr>
            <th class="text-center">
             <!--  <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox">
                </div>
              </div> -->
            </th>
            <th>Description</th>
            <th>Due Date</th>
            <th class="text-right">Original Amount</th>
            <th class="text-right">Balance</th>
            <th class="text-right">Payment</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center">

              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input select-invoice" type="checkbox" checked="true">
                </div>
              </div>

            </td>
            <td><span class="text-blue" >{{ $transaction->invoice->description }}</span> <span>{{ $transaction->invoice->due_date }}</span></td>
            <td>{{ $transaction->invoice->due_date }}</td>
            <td class="text-right amount"> {{  $transaction->invoice->total_amount }} </td>
            <td class="text-right invoice-balance"> {{  $transaction->invoice->balance }} </td>
            <td class="text-right payment">
              <input type="hidden" value="{{ $transaction->invoice->invoice_id }}" name="reference_id" form="frm-payment">
              <input type="text" class="form-control form-control-sm rounded-0 text-right txt-payment" form="frm-payment" name="amount" value="{{  $transaction->invoice->balance }}">
            </td>
          </tr>
          <tr style="background-color: #f1f1f1;" id="footer-row">
            <td colspan="6">&nbsp;</td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>

  <div class="col-md-4">

      <div class="form-group">
        <label for="" class="label-normal">Note</label>
        <textarea class="form-control form-control-sm rounded-0" style="resize: none" rows="3" name="note" form="frm-payment"></textarea>
      </div>
    </div>

  <div class="col-md-4"></div>

  <div class="row" style="border-top: 1px solid #f1f1f1; padding: 10px; margin-top:50px;">

    <div class="col-md-6">
      <small class="form-text">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit....</small>
    </div>
    <div class="col-md-6 text-right">
      <button type="button" class="btn btn-flat btn-default btn-sm" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-flat bg-gradient-success btn-sm" form="frm-payment">Save and Close</button>
    </div>

  </div>

  <script>

if ($('body').find('.modal.show').length) {
    let rcv = $('.amnt-rcv').text();
    let inv_blnc = $('.invoice-balance').text();
    let amount = $('.amount').text();

    let payment_amount = $('.txt-payment').val();

    console.log(payment_amount);


    $('.txt-payment').val(amountConverter(payment_amount))
    $('.amount').text(amountConverter(amount))
    $('.invoice-balance').text(amountConverter(inv_blnc))
    $('.amnt-rcv').text(amountConverter(rcv))



    function amountConverter(amount) {
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP',

    });

    return formatter.format(amount)
    }
}




  </script>
