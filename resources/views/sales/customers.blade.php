@extends('layouts.app')

@section('content')

<style type="text/css">
  .dataTables_filter {
    float: left !important;
  }
  .col-sm-6.col-md-6.text-left{
	  text-align: right !important;
  }
</style>

<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
  	<div class="row">
		<div class="col-md-12">
			<div style="margin-bottom:24px;display:flex;justify-content:space-between;align-items:center;">
				<h3>List of Customers</h3>
				<a href="{{route('customer.create')}}" class="btn btn-success btn-sm"><span class="fa fa-plus" style="font-size:11px;margin-right:5px;"></span> New Customer</a>
			</div>

			<table class="table table-bordered table-sm table-hover" id="tbl-customer-list">
				<thead>
					<th>Customer/Company</th>
					<th>Contact</th>
					<th class="text-right">Open Balance</th>
					<th>Action</th>
				</thead>
				<tbody>
				</tbody>
			</table>
			
		</div>
	</div>
  </div>
</section>
<!-- /.content -->
@endsection

@section('footer-scripts')
  @include('scripts.sales.customer')
@endsection