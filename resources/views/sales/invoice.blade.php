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
            <h3 class="card-title"> Invoices </h3>
              <div class="card-tools">
                <div class="col-md-12 text-right">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-default btn-flat" disabled>Select Transaction</button>
                      <a type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
                        <a class="dropdown-item invoice-create-transaction" data-title="Invoice" data-remote="{{ route('sales.create', 'invoice') }}" href="#">Invoice</a>
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
              <div class="col-md-4">
                <div class="form-group">
                  <label class="label-normal"> Date </label>
                  <div id="salesDateRange" style="background: #fff; cursor: pointer; padding: 4px 10px; border: 1px solid #ccc; width: 100%">
                      <i class="fa fa-calendar"></i>&nbsp;
                      <span id="flt-dates">Dates</span>
                  </div>
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group">
                  <label class="label-normal"> &nbsp; </label>

                  <div class="input-group">
                    <button type="button" class="btn btn-sm btn-success btn-apply-filters" data-type="invoice">
                      Apply Filters
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-sm table-hover" id="tbl-invoice-list">
                  <thead>
                    <tr>
                      <th width="100">Date</th>
                      <th>No</th>
                      <th>Customer</th>
                      <th class="text-right">Amount</th>
                      <th class="text-right">Balance</th>
                      <th>Due Date</th>
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
@endsection

@section('footer-scripts')
  @include('scripts.sales.sales')
@endsection