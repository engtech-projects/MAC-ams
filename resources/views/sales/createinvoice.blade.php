<!--  -->
<style type="text/css">
  
  .remove-items:hover {
    cursor: pointer;
  }  

</style>


<form id="frm-create-invoice" method="POST" action="{{ route('sales.store') }}"> 
  <input type="hidden" name="transaction_type_id" value="{{ $transactionType->transaction_type_id }}">
  <input type="hidden" name="transaction_type" value="{{ $transactionType->transaction_type }}">
  <input type="hidden" name="account_id" value="{{ $transactionType->account_id }}">
  <input type="hidden" name="counter_account_id" value="{{ $transactionType->counter_account_id }}">
  <input type="hidden" name="status" value="{{ $transactionStatus->status }}">
  @csrf
</form>

<form id="frm-add-item-details"></form>

  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="" class="label-normal">Customer <i class="fa fa-asterisk fa-xs text-red" aria-hidden="true"></i> </label>
        <select class="select2 form-control form-control-sm rounded-0" form="frm-create-invoice" name="customer_id" required>
          <option value="" disabled selected>Select a customer</option>
          @foreach ($customers as $customer)
              <option value="{{ $customer->customer_id }}" {{isset($invoice->customer)? selected($customer->customer_id, $invoice->customer->customer_id, 'selected') : ''}}>{{ ucwords($customer->displayname) }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="" class="label-normal">Invoice no.</label>
        <input type="text" class="form-control form-control-sm rounded-0" value="{{isset($invoice)? $invoice->invoice_no : ''}}" name="invoice_no" form="frm-create-invoice">
      </div>

    </div>

    <div class="col-md-2">

      <div class="form-group">
        <label for="" class="label-normal">Invoice date</label>
		<input type="date" class="form-control form-control-sm rounded-0" value="{{ isset($invoice)? date('Y-m-d', strtotime($invoice->invoice_date)) : Carbon\Carbon::now()->format('Y-m-d') }}" form="frm-create-invoice" name="invoice_date">
	</div>

      <div class="form-group row">
        <label for="" class="col-sm-12 col-md-12 label-normal">Terms</label>
        <div class="col-sm-12 col-md-12">
          <select class="form-control form-control-sm rounded-0" form="frm-create-invoice" name="term_id">
            <option></option>
            @foreach ($terms as $term)
              <option value="{{ $term->term_id }}" {{isset($invoice->term_id)? selected($term->term_id, $invoice->term_id, 'selected') : ''}}>{{ ucwords($term->term) }}</option>
            @endforeach
          </select>
        </div>
      </div>

    </div>

    <div class="col-md-2">
      
      <div class="form-group">
        <label for="" class="label-normal">Due date</label>
		<input type="date" class="form-control form-control-sm rounded-0" value="{{ isset($invoice)? date('Y-m-d', strtotime($invoice->due_date)) : Carbon\Carbon::now()->format('Y-m-d') }}" form="frm-create-invoice" name="due_date">
	</div>

    </div>

    <div class="col-md-4">
      <div class="small-box bg-default text-right">
        <div class="inner">
          <h3 id="total-amount">{{isset($invoice->transaction->items)? balanceDue($invoice->transaction->items) : '0.00'}}</h3>
          <span class="text-muted">BALANCE DUE</span>
        </div>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="callout callout-success">
          <h6>INVOICE DETAILS</h6>
      </div>
    </div>
    <div class="col-md-12">
        
      <table class="table table-bordered table-sm" id="">
        <thead>
          <tr>
            <th>#</th>
            <th width="300">Product/Service</th>
            <th width="250">Description</th>
            <th class="text-right" width="100">Qty</th>
            <th class="text-right" width="150">Rate</th>
            <th class="text-right" width="150">Amount</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td>
              <select class="product-service-select select2 form-control form-control-sm rounded-0" name="item_id" form="frm-add-item-details" required>
                  <option value="" disabled selected>Select a product/service</option>
                  @foreach ($productsServices as $productService)
                    <option value="{{ $productService->item_id }}" data-rate="{{ $productService->rate }}">{{ ucwords($productService->name) }}</option>
                  @endforeach
              </select>
            </td>
            <td>
              <input type="text" class="form-control form-control-sm rounded-0" name="description" form="frm-add-item-details" placeholder="Add a description">
            </td>
            <td> <input type="text" class="form-control form-control-sm rounded-0 text-right" value="1" name="qty" form="frm-add-item-details" required></td>
            <td> <input type="text" class="form-control form-control-sm rounded-0 text-right" name="rate" form="frm-add-item-details" required></td>
            <td>
              <input type="text" class="form-control form-control-sm rounded-0 text-right" placeholder="0.00" name="amount" form="frm-add-item-details" required>
            </td>
            <td class="text-center">
              <button type="submit" form="frm-add-item-details" class="btn btn-sm btn-flat btn-default btn-add-item-details">
                Add
              </button>
            </td>
          </tr>
		  @if(isset($invoice->transaction->items))
			@foreach($invoice->transaction->items as $item)
				<tr class="transaction-items">
					<td></td>
					<td data-id="{{$item->item_id}}">{{$item->item->name}}</td>
					<td>{{$item->description}}</td>
					<td class="text-right">{{$item->qty}}</td>
					<td class="text-right">{{$item->rate}}</td>
					<td class="text-right">{{$item->amount}}</td>
					<td class="text-center"><i class="fa fa-trash-alt fa-xs text-muted remove-items" aria-hidden="true"></i></td>
				</tr>
			@endforeach
		  @endif
          <tr style="background-color: #f1f1f1;" id="footer-row">
            <td colspan="7">&nbsp;</td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>

  <div class="col-md-4">

      <div class="form-group">
        <label for="" class="label-normal">Note</label>
        <textarea class="form-control form-control-sm rounded-0" style="resize: none" rows="3" name="note" form="frm-create-invoice">{{isset($invoice->transaction->note)? $invoice->transaction->note : ''}}</textarea>
      </div>
    </div>

  <div class="col-md-4"></div>

  <div class="row" style="border-top: 1px solid #f1f1f1; padding: 10px; margin-top:50px;">

    <div class="col-md-6">
      <small class="form-text">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit....</small>
    </div>
    <div class="col-md-6 text-right">
      <button type="button" class="btn btn-flat btn-default btn-sm" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-flat bg-gradient-success btn-sm" form="frm-create-invoice">Save and Close</button>
    </div>

  </div>