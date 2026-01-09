@extends('layouts.app')

@section('content')


<!-- Main content -->
<section class="content">
  <div class="container-fluid">
	<!-- <div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-sm table-hover" id="">
				<thead>
				<tr>
					<th>Supplier</th>
					<th>Contact Numbers</th>
					<th>Email</th>
					<th class="text-right">Balance</th>
					<th class="text-right" width="100">Action</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div> -->
    <div class="row">
      <div class="col-12">
        <!-- Default box -->
        <div class="spacer" style="margin-top:20px;"></div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> Suppliers </h3>
              <div class="card-tools">
                <div class="col-md-12 text-right">
				  <button class="btn btn-default no-print" id="printBtn"><i class="fa fa-print"></i> Print</button>
                  <button type="submit" data-title="Supplier Information" class="btn btn-flat bg-gradient-success btn-sm create-supplier no-print" data-remote="{{ route('supplier.create') }}">New Supplier</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-sm table-hover" id="tbl-supplier-list">
                  <thead>
                    <tr>
                      <th>Supplier</th>
                      <th>Contact Numbers</th>
                      <th>Email</th>
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
<div class="modal" id="modal-create-supplier">
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
  @include('scripts.suppliers.suppliers')
@endsection