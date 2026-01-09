<html>
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		@include('includes.styles')
	</head>
	<body>
		
			<div class="row">
				<table class="table table-stripped">
					<thead>
						<th style="width:60px;">#</th>
						<th>Category Name</th>
						<th style="width:150px;">Actions</th>
					</thead>
					<tbody id="categoriesPanel">
						<tr style="background-color:#eee;">
							<td></td>
							<td>
								<input type="text" name="category_name" value="" class="form-control form-control-sm rounded-0" id="categoryName" placeholder="Category Name" required>
							</td>
							<td>
								<button class="btn btn-success" id="addCategoryBtn" style="padding-left:25px;padding-right:25px;">ADD</button>
							</td>
						</tr>
						@foreach($categories as $ckey => $category)
						<tr class="row{{$ckey + 1}}" data-count="{{$ckey + 1}}">
							<td>{{$ckey + 1}}</td>
							<td>{{$category->category_name}}</td>
							<td>
								<a href="#" class="fa fa-edit" style="margin-right:18px;color:#2ecc71"></a>
								<a href="#" class="fa fa-trash" data-id="{{$category->ps_category_id}}" style="color:#e74c3c"></a>
							</td>
						</tr>
						<tr class="editRow{{$ckey + 1}} hide" data-count="{{$ckey + 1}}">
							<td>{{$ckey + 1}}</td>
							<td><input type="text" class="form-control" value="{{$category->category_name}}"></td>
							<td>
								<a href="#" class="fa fa-check" data-id="{{$category->ps_category_id}}" style="margin-right:18px;color:green"></a>
								<a href="#" class="fa fa-times" style="color:red"></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<!-- <div class="col-md-12">
					<div class="form-group" style="flex:1;">
						<label class="label-normal" for="exampleInputPassword1">Category Name</label>
						<div class="input-group">
							<input type="text" name="category_name" value="" class="form-control form-control-sm rounded-0" id="" placeholder="Category Name" required>
						</div>
					</div>
				</div>
				<div style="display:flex;justify-content:flex-end;width:100%;">
					<button class="btn btn-default" data-dismiss="modal" style="padding-left:25px;padding-right:25px;margin-right:12px;">CANCEL</button>
					<button class="btn btn-success" style="padding-left:25px;padding-right:25px;">SAVE</button>
				</div> -->
			</div>
		@include('includes.scripts')
		<script>
			jQuery(document).ready(function() {  
				$('#categoriesPanel').click(function(e){
					if(e.target.id == 'addCategoryBtn'){
						let categoryName = $('#categoryName').val();
						$.ajax({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							type:'POST',
							url:"{{route('product.category.store')}}",
							data:{'category_name':categoryName},
							success:function(data) {
								$('#categoriesPanel').html(updateCategories(data.data));
							}
						});
					}
				});
			});

			function updateCategories(data){
				let html = `<tr style="background-color:#eee;">
							<td></td>
							<td>
								<input type="text" name="category_name" value="" class="form-control form-control-sm rounded-0" id="categoryName" placeholder="Category Name" required>
							</td>
							<td>
								<button class="btn btn-success" id="addCategoryBtn" style="padding-left:25px;padding-right:25px;">ADD</button>
							</td>
						</tr>`
				for(i in data){
					let count = Math.abs(i) + Math.abs(1);
					html += `<tr class="row` + count + `" data-count="` + count + `">
								<td>` + count + `</td>
								<td>` + data[i].category_name + `</td>
								<td>
									<a href="#" class="fa fa-edit" style="margin-right:18px;color:#2ecc71"></a>
									<a href="#" class="fa fa-trash" data-id="` + data[i].ps_category_id + `" style="color:#e74c3c"></a>
								</td>
							</tr>
							<tr class="editRow` + count + ` hide" data-count="` + count + `">
								<td>` + count + `</td>
								<td><input type="text" class="form-control" value="` + data[i].category_name + `"></td>
								<td>
									<a href="#" class="fa fa-check" data-id="` + data[i].ps_category_id + `" style="margin-right:18px;color:green"></a>
									<a href="#" class="fa fa-times" style="color:red"></a>
								</td>
							</tr>`
				}
				return html;
			}

			$('#categoriesPanel').click(function(e){
				if(e.target.className == 'fa fa-trash'){
					let id = e.target.getAttribute('data-id');
					var dialog = confirm('Do you want to remove this category?');
					if(dialog) {
						removeCategory(id);
					}
				}
			});

			function removeCategory(id){
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type:'POST',
					url:"{{route('product.category.delete')}}",
					data:{'id':id},
					success:function(data) {
						$('#categoriesPanel').html(updateCategories(data.data));
					}
				});
			}

			$('#categoriesPanel').click(function(e){
				if(e.target.className == 'fa fa-edit'){
					let count = e.target.parentNode.parentNode.getAttribute('data-count');
					let editRow = $('#categoriesPanel').find('.editRow' + count)[0];
					editRow.className = 'editRow' + count;
					e.target.parentNode.parentNode.className = 'hide row' + count;
				}
			});

			$('#categoriesPanel').click(function(e){
				if(e.target.className == 'fa fa-times'){
					let count = e.target.parentNode.parentNode.getAttribute('data-count');
					let row = $('#categoriesPanel').find('.row' + count)[0];
					row.className = 'row' + count;
					e.target.parentNode.parentNode.className = 'hide editRow' + count;
				}
			});

			$('#categoriesPanel').click(function(e){
				if(e.target.className == 'fa fa-check'){
					let id = e.target.getAttribute('data-id');
					let category = $(e.target.parentNode.parentNode).find('.form-control')[0];
					editCategory(id, category.value);
				}
			});

			function editCategory(id,categoryName){
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type:'POST',
					url:"{{route('product.category.update')}}",
					data:{'id':id, 'category_name':categoryName },
					success:function(data) {
						$('#categoriesPanel').html(updateCategories(data.data));
					}
				});
			}
		</script>
	</body>
</html>

