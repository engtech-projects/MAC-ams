<style>
	.btn.btn-secondary.buttons-print, .btn.btn-secondary.buttons-csv.buttons-html5 {
		display:none;
	}
</style>

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
            <h3 class="card-title"> Chart of Accounts </h3>
              <div class="card-tools">
                <div class="col-md-12 text-right">
                    <a href="#" class="btn btn-flat btn-sm bg-gradient-success btn-create-account" data-remote="{{ route('accounts.create') }}">New Account</a>
                  </div>
              </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
				<form action="" id="importForm" enctype='multipart/form-data'>
					<input class="hide" name="import" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="import">
				</form>
                <table class="table table-bordered table-sm table-hover" id="tbl-chart-of-accounts">
                  <thead>
                    <tr>
                      <th width="100">Number</th>
                      <th>Account Name</th>
                      <th>Type</th>
                      <th>Description</th>
                      <th class="text-right">Balance</th>
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
<div class="modal" id="modal-create-account">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Account</h4>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
  @include('scripts.chartofaccounts.chartofaccounts')
@endsection