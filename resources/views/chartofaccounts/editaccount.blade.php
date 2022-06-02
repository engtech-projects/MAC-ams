<form id="frm-update-account" method="POST" action="{{ route('accounts.update', $account->account_id) }}" >
  @csrf
  @method('put')
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="" class="label-normal">Account Type</label>
        <select class="form-control form-control-sm rounded-0" name="account_type_id">
          @foreach ($accountTypes as $accountType)

            @if ($account->account_type_id == $accountType->account_type_id)
              <option value="{{ $accountType->account_type_id }}" selected>{{ ucfirst($account->account_type) }}</option>
            @else
              <option value="{{ $accountType->account_type_id }}">{{ ucfirst($accountType->account_type) }}</option>
            @endif
              
          @endforeach
        </select>              
      </div>
      <div class="form-group">
        <label for="" class="label-normal">Description</label>
        <textarea style="resize: none;" name="account_description" class="form-control form-control-sm rounded-0" rows="3">{{ $account->account_description }}</textarea>
      </div>

	  <div class="form-group">
		<div><label for="" class="label-normal">Bank Reconcillation ? </label></div>
		<div class="icheck-success d-inline">
			<input type="radio" id="reconcillation_yes" name="bank_reconcillation" value="Yes" checked="checked">
			<label for="reconcillation_yes" class="label-normal"> Yes
			</label>
		</div>
		<div class="icheck-success d-inline">
			<input type="radio" id="reconcillation_no" name="bank_reconcillation" value="No">
			<label for="reconcillation_no" class="label-normal"> No
			</label>
		</div>
	  </div>
      <div class="form-group clearfix">
        <div><label for="" class="label-normal">Cash Flow</label></div>
        @foreach ($cashFlows as $cashFlow)

          @if ($account->statement == $cashFlow)
            <div class="icheck-success d-inline">
                <input type="radio" id="{{ $cashFlow }}" name="statement" value="{{ $cashFlow }}" checked="">
                <label for="{{ $cashFlow }}" class="label-normal"> {{ ucfirst($cashFlow) }}
                </label>
            </div>
          @else
            <div class="icheck-success d-inline">
                <input type="radio" id="{{ $cashFlow }}" name="statement" value="{{ $cashFlow }}">
                <label for="{{ $cashFlow }}" class="label-normal"> {{ ucfirst($cashFlow) }}
                </label>
            </div>
          @endif

         
        @endforeach
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="" class="label-normal">Account Number</label>
        <input type="text" class="form-control form-control-sm rounded-0" name="account_number" value="{{ $account->account_number }}">
      </div>
      <div class="form-group">
        <label for="" class="label-normal">Account Name <i class="fa fa-asterisk fa-xs text-red" aria-hidden="true"></i> </label>
        <input type="text" class="form-control form-control-sm rounded-0" name="account_name" value="{{ $account->account_name }}" required>
      </div>

       <div class="form-group clearfix">
        <div class="icheck-success d-inline">
          <input type="checkbox" id="chkSubAccount" {{ ($account->parent_account) ? 'checked' : '' }}>
          <label for="chkSubAccount" class="label-normal">
            Sub-Account
          </label>
        </div>
      </div>
      <div class="form-group">
        <select class="select2 form-control form-control-sm rounded-0" id="sltParentAccount" {{ ($account->parent_account) ? '' : 'disabled' }}>
          <option selected disabled>Parent Account</option>
          @foreach ($accounts as $acc)

              @if ($account->parent_account == $acc->account_id)
                <option value="{{ $acc->account_id }}" selected>{{ ucwords($acc->account_name) }}</option>
              @else
                <option value="{{ $acc->account_id }}">{{ ucwords($acc->account_name) }}</option>
              @endif

          @endforeach
        </select>
      </div>
       
      <div><label for="" class="label-normal">Balance</label></div>
      <div class="form-group row">
        <div class="col-sm-4">
          <input type="text" class="form-control form-control-sm rounded-0 text-right" disabled>
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="border-top: 1px solid #f1f1f1; padding: 10px; margin-top:50px;">
    <div class="col-md-6">
      <small class="form-text">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit....</small>
    </div>
    <div class="col-md-6 text-right">
      <button type="button" class="btn btn-flat btn-default btn-sm" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-flat bg-gradient-success btn-sm">Save and Close</button>
    </div>

  </div>
</form>