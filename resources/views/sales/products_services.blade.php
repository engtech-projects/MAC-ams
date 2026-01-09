@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
  	<div class="row">
		<div class="col-md-12">
			<div style="margin-bottom:24px;display:flex;justify-content:space-between;align-items:center;">
				<h3>List of Products and Services</h3>
				<div class="btn-group">
                    <button type="button" class="btn btn-success">New</button>
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                      <a class="dropdown-item" href="{{route('product.create')}}">Product</a>
                      <a class="dropdown-item" href="{{route('service.create')}}">Service</a>
                    </div>
                  </div>
			</div>
			<table id="productTable" class="table table-stripped">
				<thead>
					<th><input type="checkbox"></th>
					<th>NAME</th>
					<th>SKU</th>
					<th>TYPE</th>
					<th>CATEGORY</th>
					<th>SALES DESCRIPTION</th>
					<th>SALES PRICE</th>
					<th>COST</th>
					<th>QTY ON HAND</th>
					<th>REORDER POINT</th>
					<th>ACTION</th>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
  </div>
</section>
<!-- /.content -->
@endsection

@section('footer-scripts')
	<script>
		$(function() {
			$('#productTable').DataTable({
				autoWidth: false,
				dom: "<'row'<'col-sm-6 col-md-6'f><'col-sm-6 col-md-6 text-right'B>>",
				bLengthChange: false,
				oLanguage: {"sSearch": "<i>Filter</i> : "},
				ajax: {url:'{{route("products_services.datatable")}}', dataSrc:""},
				columns: [
					{ 	data: 'employee_id_no',
						render: function(data, type, row){
							return "<input type='checkbox'>"
						}
					},
					{ 	data: 'name',
						render: function(data, type, row){
							return '<img src="' + row.img + '" style="height:40px;width:auto;margin-right:7px;" alt="">' + data
						}
					},	
					{ 	data: 'sku'},	
					{ 	data: 'type'},	
					{ 	data: 'category.category_name',
						render: function(data,type,row){
							if(!data){
								return 'Uncategorized';
							}
							return data.charAt(0).toUpperCase() + data.slice(1);
						}
					},
					{ 	data: 'description'},
					{ 	data: 'rate'},
					{ 	defaultContent: ''},
					{ 	data: 'qty_on_hand'},	
					{ 	data: 'reorder_point'},
					{ 	data: 'edit',
						render: function(data,type,row){
							return `<div class="btn-group">
										<button type="button" class="btn btn-default btn-sm">...</button>
										<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<span class="sr-only">Toggle Dropdown</span>
										</button>
										<div class="dropdown-menu" role="menu" style="">
										<a class="dropdown-item" href="${row.edit}">Edit</a>
										<a class="dropdown-item" href="${row.copy}">Copy</a>
										</div>
									</div>`
						}
					},
				]
			});
		});
	</script>
@stop