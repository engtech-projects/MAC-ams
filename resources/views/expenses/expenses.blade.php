@extends('layouts.app')

@section('content')

<style type="text/css">
  .dataTables_filter {
    float: left !important;
  }

</style>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- Default box -->
        <div class="spacer" style="margin-top:20px;"></div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> Expenses </h3>
              <div class="card-tools">
                <div class="col-md-12 text-right">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-default btn-flat" disabled>Select Transaction</button>
                      <a type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
                        <a class="dropdown-item expense-create-transaction" data-title="Bill" data-remote="{{ route('expenses.create', 'bill') }}" href="#">Bill</a>
                        <a class="dropdown-item expense-create-transaction" data-title="Expense" data-remote="{{ route('expenses.create', 'expense') }}" href="#">Expense</a>
                      </div>
                    </div>
                  </div>
              </div>
          </div>

          <div class="card-body">

             <div class="row">
              
              <div class="col-md-3">
                <div class="form-group">
                  <label for="" class="label-normal">Status </label>
                  <select class="form-control form-control-sm rounded-0" id="flt-status">
                    <option value="all" selected>All Status</option>
                    @foreach ($transactionStatus as $status)
                      <option value="{{ $status->status }}">{{ ucwords($status->status) }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="" class="label-normal">Payee </label>
                  <select class="form-control form-control-sm rounded-0 select2" id="flt-payee">
                    <option value="all" selected>All</option>
                    <optgroup label="Suppliers">
                    @foreach ($suppliers as $supplier)
                      <option value="{{ $supplier->supplier_id }}" payee-type="supplier">{{ ucwords($supplier->displayname) }}</option>
                    @endforeach
                    <optgroup label="Customers">
                    @foreach ($customers as $customer)
                      <option value="{{ $customer->customer_id }}" payee-type="customer">{{ ucwords($customer->displayname) }}</option>
                    @endforeach
                     <optgroup label="Employees">
                    @foreach ($employees as $employee)
                      <option value="{{ $employee->employee_id }}" payee-type="employee">{{ ucwords($employee->displayname) }}</option>
                    @endforeach
                  </select>
                  </optgroup>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="label-normal"> Date </label>
                  <div id="expenses-daterange" style="background: #fff; cursor: pointer; padding: 4px 10px; border: 1px solid #ccc; width: 100%">
                      <i class="fa fa-calendar"></i>&nbsp;
                      <span id="flt-dates">Dates</span>
                  </div>
                </div>
              </div>

              <div class="col-md-2">
                 <div class="form-group">
                  <label class="label-normal"> &nbsp; </label>

                  <div class="input-group">
                    <button type="button" class="btn btn-sm btn-success btn-apply-filters" data-type="expenses">
                      Apply Filters
                    </button>
                  </div>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-sm table-hover" id="tbl-expenses-list">
                  <thead>
                    <tr>
                      <th width="100">Date</th>
                      <th>Type</th>
                      <th>No</th>
                      <th>Payee</th>
                      <th>Due Date</th>
                      <th class="text-right">Balance</th>
                      <th class="text-right">Total</th>
                      <th>Status</th>
                      <th class="text-right" width="100">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
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

<!-- modal create/edit account -->
<div class="modal" id="modal-create-expenses">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@section('footer-scripts')
  @include('scripts.expenses.expenses')
@endsection