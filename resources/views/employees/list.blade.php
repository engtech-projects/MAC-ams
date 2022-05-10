@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
  	<div class="row">
		<div class="col-md-12">
			<div style="margin-bottom:24px;display:flex;justify-content:space-between;align-items:center;">
				<h3>List of Employees</h3>
				<a href="{{route('employee.create')}}" class="btn btn-success btn-sm"><span class="fa fa-plus" style="font-size:11px;margin-right:5px;"></span> New Employee</a>
			</div>

			<table id="employeeTable" class="table table-stripped">
				<thead>
					<th>ID NO.</th>
					<th>DISPLAY NAME</th>
					<th>GENDER</th>
					<th>AGE</th>
					<th>EMAIL</th>
					<th>MOBILE NO.</th>
					<th>TEL NO.</th>
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
			$('#employeeTable').DataTable({
				autoWidth: false,
				dom: "<'row'<'col-sm-6 col-md-6'f><'col-sm-6 col-md-6 text-right'B>>",
				bLengthChange: false,
				oLanguage: {"sSearch": "<i>Filter</i> : "},
				ajax: {url:'{{route("employees.datatable")}}', dataSrc:""},
				columns: [
					{ data: 'employee_id_no'},
					{ data: 'displayname'},
					{ data: 'gender'},
					{ data: 'age'},
					{ data: 'email_address'},
					{ data: 'mobile_number'},
					{ data: 'phone_number'},
					{ data: 'edit', 
						render: function(data,type,row){
							return '<a href="' + data + '">Edit<a/>';
					}},
				]
			});
		});
	</script>
@stop