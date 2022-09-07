@extends('layouts.app')

@section('content')

<style type="text/css">
	.dataTables_filter {
		float: left !important;
	}
	.nav-pills .nav-link.active, .nav-pills .show>.nav-link{
		background-color: #3d9970!important;
  		color: #fff!important;
		border-radius:0px;
	}
	.nav-link:hover, .nav-link:focus{
		background-color: #4ec891!important;
  		color: #fff!important;
		border-radius:0px;
		
	}
	.frm-header{
		margin-bottom:10px;
		padding-bottom:10px;
		border-bottom:2px solid #4ec891;
	}
	.search-custom{
		display:block;
		position:absolute;
		z-index:999;
		width:100%;
		margin:0px!important;
		color:#3d9970!;
		font-weight:bold;
		font-size:14px;
	}
	.dataTables_filter{
		float:right!important;
	}
</style>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="spacer" style="margin-top:10px;"></div>
				<div class="card">
					<div class="row">
						<div class="card-body" style="padding:0.4em;">
							<div class="nav  nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								@if(checkUserHasAccessModule('sub-module','companySettings'))
								<a class="nav-link sysnav" id="v-pills-CompanySettings-tab" data-toggle="pill" href="#v-pills-CompanySettings" role="tab" aria-controls="v-pills-CompanySettings" aria-selected="false"><i class="nav-icon fas fa-building"></i> Company Settings</a>
								@endif
								@if(checkUserHasAccessModule('sub-module','JournalBook'))
								<a class="nav-link sysnav" id="v-pills-JournalBook-tab" data-toggle="pill" href="#v-pills-JournalBook" role="tab" aria-controls="v-pills-JournalBook" aria-selected="false"><i class="nav-icon fas fa-book"></i> Journal Book</a>
								@endif
								@if(checkUserHasAccessModule('sub-module','CategoryFile'))
								<a class="nav-link sysnav" id="v-pills-CategoryFile-tab" data-toggle="pill" href="#v-pills-CategoryFile" role="tab" aria-controls="v-pills-CategoryFile" aria-selected="false"><i class="nav-icon fas fa-tachometer-alt"></i> Category File</a>
								@endif
								@if(checkUserHasAccessModule('sub-module','UserMasterFile'))
								<a class="nav-link sysnav" id="v-pills-UserMasterFile-tab" data-toggle="pill" href="#v-pills-UserMasterFile" role="tab" aria-controls="v-pills-UserMasterFile" aria-selected="false"><i class="nav-icon fas fa-user"></i> User Master File</a>
								@endif
								@if(checkUserHasAccessModule('sub-module','accounting'))
								<a class="nav-link sysnav" id="v-pills-Accounting-tab" data-toggle="pill" href="#v-pills-Accounting" role="tab" aria-controls="v-pills-Accounting" aria-selected="false"><i class="nav-icon fas fa-cash-register"></i> Accounting</a>
								@endif
								@if(checkUserHasAccessModule('sub-module','currency'))
								<a class="nav-link sysnav" id="v-pills-Currency-tab" data-toggle="pill" href="#v-pills-Currency" role="tab" aria-controls="v-pills-Currency" aria-selected="false"><i class="nav-icon fas fa-dollar-sign"></i> Currency</a>
								@endif
							</div>
						</div>
					</div>
				</div>
				<!-- /.card -->
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<!-- Default box -->
			<div class="card">
				<div class="card-body">
					<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade" id="v-pills-JournalBook" role="tabpanel" aria-labelledby="v-pills-JournalBook-tab">
							@include('systemSetup.sections.journalBook')
						</div>
						<div class="tab-pane fade" id="v-pills-CategoryFile" role="tabpanel" aria-labelledby="v-pills-CategoryFile-tab">
							@include('systemSetup.sections.categoryFile')
						</div>
						<div class="tab-pane fade" id="v-pills-UserMasterFile" role="tabpanel" aria-labelledby="v-pills-UserMasterFile-tab">
							@include('systemSetup.sections.userMasterFile')
						</div>
						<div class="tab-pane fade" id="v-pills-CompanySettings" role="tabpanel" aria-labelledby="v-pills-CompanySettings-tab">
							@include('systemSetup.sections.companySettings')
						</div>
						<div class="tab-pane fade" id="v-pills-Accounting" role="tabpanel" aria-labelledby="v-pills-Accounting-tab">
							@include('systemSetup.sections.accounting')
						</div>
						<div class="tab-pane fade" id="v-pills-Currency" role="tabpanel" aria-labelledby="v-pills-Currency-tab">
							@include('systemSetup.sections.currency')
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
  @include('scripts.systemSetup.systemSetup')
@endsection