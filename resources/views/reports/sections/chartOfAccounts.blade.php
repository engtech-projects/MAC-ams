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
  .bordered-box-content, .bordered-box-header
  {
	background:#fff;
	border:1px solid gray;
  }
  .bordered-box-header{
	background:#c5c5c5;
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
				<div class="col-md-12 text-right">
                    <a id="printCharOfAccountExcel" type="chart_of_account" class="btn btn-flat btn-sm bg-gradient-success">Print excel</a>
				</div>
               <div class="card-tools">
              </div>
          </div>

          <div class="card-body" style="background:#f5f5f5;">
            <div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-2 col-xs-2 col-sm-2 text-center bordered-box-header">Account Number</div>
						<div class="col-md-6 col-xs-6 col-sm-6 text-center bordered-box-header">Account Name</div>
						<div class="col-md-3 col-xs-3 col-sm-3 text-center bordered-box-header">Bank Reconcillation </div>
						<div class="col-md-1 col-xs-1 col-sm-1 text-center bordered-box-header">Edit</div>
					</div>
					@foreach ($organizedAccount as $key => $accounts)
						<div class="row">
							<div class="col-md-12 text-left " style="font-size:15px; font-weight:bold; border-bottom:1px dashed black; border-top:1px dashed black;">{{strtoupper($key)}}</div>
						</div>
  						@foreach  ($accounts['content'] as $account)
							<div class="row">
								<div class="col-md-1 col-xs-1 col-sm-1 text-left"></div>
								<div class="col-md-2 col-xs-2 col-sm-2 text-left ">{{ ucwords($account['account_number']) }}</div>
								<div class="col-md-5 col-xs-5 col-sm-5 text-left ">{{ ucwords($account['account_name']) }}</div>
								<div class="col-md-3 col-xs-3 col-sm-3 text-cgenter">{{ ucwords($account['bank_reconcillation']) }}</div>
								<div class="col-md-1 col-xs-1 col-sm-1 text-center ">
									<div class="btn-group">
										<button type="button" class="btn btn-xs btn-default btn-flat coa-action">Report</button>
										<a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
										<span class="sr-only">Toggle Dropdown</span>
										</a>
										<div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
										<a class="dropdown-item btn-edit-account" data-remote="{{ route('accounts.show', $account['account_id']) }}" href="#">Edit</a>
										<a class="dropdown-item btn-set-status" data-status="{{$account['status']}}" data-id="{{$account['account_id']}}"  href="#">{{$account['status']}}</a>
										</div>
									</div>
								</div>
							</div>
							@foreach($account["child"] as $child)
								<div class="row">
									<div class="col-md-1 col-xs-1 col-sm-1 text-left"></div>
									<div class="col-md-1 col-xs-1 col-sm-1 text-left"></div>
									<div class="col-md-2 col-xs-2 col-sm-2 text-left ">{{ ucwords($child['account_number']) }}</div>
									<div class="col-md-4 col-xs-4 col-sm-4 text- ">{{ ucwords($child['account_name']) }}</div>
									<div class="col-md-3 col-xs-3 col-sm-3 text-cgenter ">Yes</div>
									<div class="col-md-1 col-xs-1 col-sm-1 text-center ">
										<div class="btn-group">
											<button type="button" class="btn btn-xs btn-default btn-flat coa-action">Report</button>
											<a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
											<span class="sr-only">Toggle Dropdown</span>
											</a>
											<div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
											<a class="dropdown-item btn-edit-account" data-remote="{{ route('accounts.show', $child['account_id']) }}" href="#">Edit</a>
											<a class="dropdown-item btn-set-status" data-status="{{$child['status']}}" data-id="{{$child['account_id']}}"  href="#">{{$child['status']}}</a>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						@endforeach
					@endforeach
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

<div class="modal" id="modal-create-class">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Class</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form id="form-class">
			@csrf
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="" class="label-normal">Class Name</label>
						<input type="text" class="form-control form-control-sm rounded-0" id="class_name" name="class_name" required>
					</div>
				</div>
			</div>
			<div class="col-md-12 text-right">
				<button type="submit" class="btn btn-flat btn-sm bg-gradient-success" >Save and CLose</button>
			</div>
		</form>
	  </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal" id="modal-create-type">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Type</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  		<div class="row">
			  <div class="col-md-12">
			  <form id="form-type">
					@csrf
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="label-normal">Account No.</label>
							<input type="number" class="form-control form-control-sm rounded-0" id="account_number" name="account_number" required >
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="label-normal">Account Type Name.</label>
							<input type="text" class="form-control form-control-sm rounded-0" id="account_type_name" name="account_type_name" required>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="label-normal">Account Category</label>
							<select class="select2 form-control form-control-sm" name="category_type_id">
								<option value="" selected>-Select-</option>
								@foreach($account_category as $category)
									<option value="{{$category->account_category_id}}">{{$category->account_category}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-12 text-right">
						<button type="submit" class="btn btn-flat btn-sm bg-gradient-success" >Save and CLose</button>
					</div>
				</form>
			  </div>
		  </div>
	  </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->







@endsection

@section('footer-scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
  @include('scripts.reports.reports')
@endsection
