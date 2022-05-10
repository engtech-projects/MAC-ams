<form id="frm-create-account" method="POST" action="{{ route('accounts.store') }}">
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="" class="label-normal">Account Type</label>
        <select class="form-control form-control-sm rounded-0" name="account_type_id">
          @foreach ($accountTypes as $accountType)
            <option value="{{ $accountType->account_type_id }}">{{ ucfirst($accountType->account_type) }}</option>
          @endforeach
        </select>              
      </div>
      <div class="form-group">
        <label for="" class="label-normal">Description</label>
        <textarea style="resize: none;" name="account_description" class="form-control form-control-sm rounded-0" rows="3"></textarea>
      </div>
      <div class="form-group clearfix">
        <div><label for="" class="label-normal">Cash Flow</label></div>
        @foreach ($cashFlows as $cashFlow)
          <div class="icheck-success d-inline">
            <input type="radio" id="{{ $cashFlow }}" name="statement" value="{{ $cashFlow }}">
            <label for="{{ $cashFlow }}" class="label-normal"> {{ ucfirst($cashFlow) }}
            </label>
          </div>
        @endforeach
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="" class="label-normal">Account Number</label>
        <input type="text" class="form-control form-control-sm rounded-0" id="" name="account_number" >
      </div>
      <div class="form-group">
        <label for="" class="label-normal">Account Name <i class="fa fa-asterisk fa-xs text-red" aria-hidden="true"></i> </label>
        <input type="text" class="form-control form-control-sm rounded-0" id="" name="account_name" required>
      </div>

       <div class="form-group clearfix">
        <div class="icheck-success d-inline">
          <input type="checkbox" id="chkSubAccount">
          <label for="chkSubAccount" class="label-normal">
            Sub-Account
          </label>
        </div>
      </div>
      <div class="form-group">
        <select class="select2 form-control form-control-sm rounded-0" name="parent_account" id="sltParentAccount" disabled>
          <option selected disabled>Parent Account</option>
          @foreach ($accounts as $account)
          <option value="{{ $account->account_id }}">{{ ucwords($account->account_name) }}</option>
          @endforeach
        </select>
      </div>
       
      <div><label for="" class="label-normal">Opening Balance</label></div>
      <div class="form-group row">
        <div class="col-sm-4">
          <input type="text" name="opening_balance" class="form-control form-control-sm rounded-0 text-right" placeholder="0.00">
        </div>
        <label class="col-sm-2 col-form-label label-normal text-center">as of</label>
        <div class="col-sm-6">
          <input type="date" name="starting_date" class="form-control form-control-sm rounded-0">
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