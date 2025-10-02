@extends('layouts.app')

@section('content')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- Default box -->
        <div class="spacer" style="margin-top:20px;"></div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> Journal Entry </h3>
          </div>

          <div class="card-body">

            <form id="frm-create-journal" method="POST" action="{{ route('journal.store') }}">
              <input type="hidden" name="transaction_type_id" value="{{ $transactionType->transaction_type_id }}">
              <input type="hidden" name="transaction_type" value="{{ $transactionType->transaction_type }}">
              <input type="hidden" name="status" value="open">
              @csrf
            </form>

            <form id="frm-journal-entry"></form>

            <div class="row">
                
              <div class="col-md-3">

                <div class="form-group">
                  <label for="" class="label-normal">Journal no.</label>
                  <input type="text" class="form-control form-control-sm rounded-0" name="journal_no" form="frm-create-journal">
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group">
                  <label for="" class="label-normal">Journal date</label>
                  <input type="date" class="form-control form-control-sm rounded-0" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" form="frm-create-journal" name="journal_date">
                </div>

              </div>

              <div class="col-md-6"></div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-sm" id="tbl-create-journal">
                  <thead>
                      <tr>
                        <th width="50" class="text-right">#</th>
                        <th width="200">Account</th>
                        <th width="150">Debits</th>
                        <th width="150">Credits</th>
                        <th width="200">Description</th>
                        <th width="200">Name</th>
                        <th class="text-right" width="50">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr class='editable-table-row'>
                          <td></td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td>
                            <button class="btn btn-secondary btn-flat btn-sm btn-default">
                              <span>
                                <i class="fas fa-trash" aria-hidden="true"></i>
                              </span>
                            </button>
                          </td>
                      </tr>
                      <tr class='editable-table-row'>
                          <td></td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td>
                            <button class="btn btn-secondary btn-flat btn-sm btn-default">
                              <span>
                                <i class="fas fa-trash" aria-hidden="true"></i>
                              </span>
                            </button>
                          </td>
                      </tr>
                      <tr class='editable-table-row'>
                          <td></td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td><a href="#" class="editable-row-item"></a> </td>
                          <td>
                            <button class="btn btn-secondary btn-flat btn-sm btn-default">
                              <span>
                                <i class="fas fa-trash" aria-hidden="true"></i>
                              </span>
                            </button>
                          </td>
                      </tr>
                  </tbody>
              </table>
              </div>
            </div>

            <div class="row">
              
              <div class="col-md-12">
              
                <table class="table table-bordered table-sm" id="">
                  <thead>
                    <tr>
                      <th width="50" class="text-right">#</th>
                      <th width="200">Account</th>
                      <th width="150">Debits</th>
                      <th width="150">Credits</th>
                      <th width="200">Description</th>
                      <th width="200">Name</th>
                      <th class="text-right" width="50">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td>
                         <select class="select2 form-control form-control-sm rounded-0" name="account_id" form="frm-journal-entry" required>
                            <option value="" disabled selected></option>
                            <optgroup label="Assets">
                            @foreach ($assets as $asset)
                              <option value="{{ $asset->account_id }}">{{ ucwords($asset->account_name) }}</option>
                            @endforeach
                            <optgroup label="Liabilities">
                            @foreach ($liabilities as $liability)
                              <option value="{{ $liability->account_id }}">{{ ucwords($liability->account_name) }}</option>
                            @endforeach
                            </optgroup>
                            <optgroup label="Equity">
                            @foreach ($equity as $eq)
                              <option value="{{ $eq->account_id }}">{{ ucwords($eq->account_name) }}</option>
                            @endforeach
                            </optgroup>
                            <optgroup label="Income">
                            @foreach ($income as $inc)
                              <option value="{{ $inc->account_id }}">{{ ucwords($inc->account_name) }}</option>
                            @endforeach
                            </optgroup>
                            <optgroup label="Expenses">
                            @foreach ($expenses as $expense)
                              <option value="{{ $expense->account_id }}">{{ ucwords($expense->account_name) }}</option>
                            @endforeach
                            </optgroup>
                          </select>
                      </td>
                      <td>
                         <input type="text" class="form-control form-control-sm rounded-0 text-right" name="debit" form="frm-journal-entry">
                      </td>
                      <td>
                         <input type="text" class="form-control form-control-sm rounded-0 text-right" name="credit" form="frm-journal-entry">
                      </td>
                      <td>
                         <input type="text" class="form-control form-control-sm rounded-0" name="description" form="frm-journal-entry">
                      </td>
                      <td>
                        <select class="select2 form-control form-control-sm rounded-0" name="person" form="frm-journal-entry">
                            <option value="" disabled selected></option>
                            <optgroup label="Customers">
                            @foreach ($customers as $customer)
                                <option data-type="customer" value="{{ $customer->customer_id }}">{{ ucwords($customer->displayname) }}</option>
                            @endforeach
                            </optgroup>
                            <optgroup label="Suppliers">
                            @foreach ($suppliers as $supplier)
                                <option data-type="supplier" value="{{ $supplier->supplier_id }}">{{ ucwords($supplier->displayname) }}</option>
                            @endforeach
                            </optgroup>
                            <optgroup label="Employees">
                            @foreach ($employees as $employee)
                                <option data-type="employee" value="{{ $employee->employee_id }}">{{ ucwords($employee->displayname) }}</option>
                            @endforeach
                            </optgroup>
                          </select>
                      </td>
                      <td class="text-center">
                        <button type="submit" class="btn btn-sm btn-flat btn-default" form="frm-journal-entry">
                          Add
                        </button>
                      </td>
                    </tr>
                    <tr style="background-color: #f1f1f1;" id="footer-row">
                      <td colspan="2" class="text-right">Total</td>
                      <td class="text-right">0.00</td>
                      <td class="text-right">0.00</td>                     
                      <td colspan="3"></td>
                    </tr>
                  </tbody>
                </table>
              </div>  
            </div>

            <div class="row">
              
              <div class="col-md-4">
                <div class="form-group">
                  <label for="" class="label-normal">Note</label>
                  <textarea class="form-control form-control-sm rounded-0" style="resize: none" rows="3" name="note" form="frm-create-journal"></textarea>
                </div>
              </div>

              <div class="col-md-4"></div>
              <div class="col-md-4"></div> 
            </div>
            
            <div class="row" style="border-top: 1px solid #f1f1f1; padding: 10px; margin-top:50px;">

              <div class="col-md-6">
                <small class="form-text">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit....</small>
              </div>
              <div class="col-md-6 text-right">
                <button type="submit" class="btn btn-flat bg-gradient-success btn-sm" form="frm-create-journal">Save</button>
              </div>
            </div>

          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>
<!-- /.content -->


@endsection

@section('footer-scripts')
  @include('scripts.journal.journal')
@endsection