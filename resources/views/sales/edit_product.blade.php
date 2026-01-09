@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<form action="{{route('product.update',['item_id'=>$product->item_id])}}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<h3 style="margin-bottom:32px;">Edit Product Information</h3>
				<div class="row">
					<div class="col-md-6">
						<div style="display:flex;align-items:center;">
							<div style="display:flex;flex-direction:column;flex:1;margin-right:32px;">
								<div class="form-group">
									<label class="label-normal" for="exampleInputPassword1"><span style="color:#e74c3c;">*</span>Name</label>
									<div class="input-group">
										<input name="name" id="name" value="{{$product->name}}" class="form-control form-control-sm rounded-0">
									</div>
								</div>
								<div class="form-group">
									<label class="label-normal" for="exampleInputPassword1"><span style="color:#e74c3c;">*</span>SKU</label>
									<div class="input-group">
										<input name="sku" id="sku" value="{{$product->sku}}" class="form-control form-control-sm rounded-0">
									</div>
								</div>
							</div>

							<div style="display:flex;flex-direction:column">
								<img id="productImage" src="{{productImage($product->image_path)}}" alt="" style="width:105px;height:auto;margin-bottom:5px;cursor:pointer;">
								<input type="file" name="file" id="imageInput" style="display:none;">
								<div style="display:flex;justify-content:space-around;align-items:center">
									<i style="color:#aaa;cursor:pointer" class="fa fa-edit"></i>
									<span style="color:#aaa;cursor:pointer">|</span>
									<i style="color:#aaa;cursor:pointer" id="clearImage" class="fa fa-trash"></i>
								</div>
							</div>
						</div>

						<div>
							<div class="form-group">
								<label class="label-normal" for="category"><span style="color:#e74c3c;">*</span>Category</label>
								<div class="input-group">
									<select name="category" id="category" class="form-control form-control-sm rounded-0 mr-2">
										@foreach($categories as $category)
										<option value="{{$category->ps_category_id}}" {{selected($category->ps_category_id, $product->ps_category_id, 'selected')}}>{{$category->category_name}}</option>
										@endforeach
									</select>
									<a class="btn btn-success" id="newCategoryBtn">+ New Category</a>
								</div>
							</div>
						</div>

						<div style="display:flex;flex-direction:column;margin-bottom:16px;padding:24px;background-color:#f2f2f2;">
							<div style="display:flex;margin-bottom:16px;">
								<span style="flex:2">Initial quantity on hand</span>
								<input type="number" style="flex:1" name="q_onhand" id="qOnhand" value="{{$product->qty_on_hand}}" class="form-control form-control-sm rounded-0">
							</div>
							<div style="display:flex;margin-bottom:16px;">
								<span style="flex:2">As of date</span>
								<input style="flex:1" type="date" name="asofdate" id="asOfDate" value="{{date('Y-m-d')}}" class="form-control form-control-sm rounded-0">
							</div>
							<div style="display:flex;">
								<span style="flex:2">Reorder point</span>
								<input type="number" style="flex:1" name="reorder_point" id="reorderPoint" value="{{$product->reorder_point}}" class="form-control form-control-sm rounded-0">
							</div>
						</div>

						<div>
							<div class="form-group">
								<label class="label-normal" for="exampleInputPassword1">Inventory asset account</label>
								<div class="input-group">
									<select name="inventory_asset_account" id="" class="form-control form-control-sm rounded-0">
										<option value="inventory 1">Inventory Account 1</option>
										<option value="inventory 2">Inventory Account 2</option>
										<option value="inventory 3">Inventory Account 3</option>
									</select>
								</div>
							</div>
						</div>
					</div>


					<div class="col-md-6">
						<div style="display:flex;">
							<div class="form-group" style="flex:1">   
								<label class="label-normal" for="exampleInputPassword1">Description</label>
								<div class="input-group">
									<textarea class="form-control form-control-sm rounded-0" name="description" id="description" cols="30" rows="3" placeholder="Description on sales forms" value="{{$product->description}}">{{$product->description}}</textarea>
								</div>
							</div>
						</div>
						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Sales price/rate</label>
								<div class="input-group">
									<input type="number" name="sales_price_rate" value="{{$product->sales_price}}" class="form-control form-control-sm rounded-0" id="salesPriceRate" placeholder="">
								</div>
							</div>
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">income Account</label>
								<div class="input-group">
									<select name="income_account" id="" class="form-control form-control-sm rounded-0">
										<option value="1">Income Account 1</option>
										<option value="2">Income Account 2</option>
										<option value="3">Income Account 3</option>
									</select>
								</div>
							</div>
						</div>
						<div style="display:flex;">
							<div class="form-group" style="flex:1">   
								<label class="label-normal" for="exampleInputPassword1">Purchasing Information</label>
								<div class="input-group">
									<textarea class="form-control form-control-sm rounded-0" name="purchase_info" id="purchaseinfo" cols="30" rows="3" placeholder="Description on purchase forms" value="{{old('item_description')}}">{{$product->description}}</textarea>
								</div>
							</div>
						</div>

						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Cost</label>
								<div class="input-group">
									<input type="number" name="cost" value="" class="form-control form-control-sm rounded-0" id="costValue" placeholder="">
								</div>
							</div>
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Expense account</label>
								<div class="input-group">
									<select name="expense_account" id="" class="form-control form-control-sm rounded-0">
										<option value="expense account 1">Expense Account 1</option>
										<option value="expense account 2">Expense Account 2</option>
										<option value="expense account 3">Expense Account 3</option>
									</select>
								</div>
							</div>
							
						</div>

						<div class="form-group" style="margin-right:10px;flex:1;">
							<label class="label-normal" for="exampleInputPassword1">Preferred Supplier</label>
							<div class="input-group">
								<select name="preferred_supplier" id="" class="form-control form-control-sm rounded-0">
									<option value=""></option>
								</select>
							</div>
						</div>
						
						<div style="display:flex;justify-content:flex-end">
							<div class="form-group" style="margin-right:16px;">   
								<a href="{{route('products_services')}}" class="btn btn-default" style="padding-left:24px;padding-right:24px;">Cancel</a>
							</div>
							<div class="form-group">   
								<button class="btn btn-success" style="padding-left:24px;padding-right:24px;">Save</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
    
  </div>
</section>
<!-- /.content -->
@endsection


@section('js')
<script>
	jQuery(document).ready(function() {  
		$('#productImage').click(function(){
			document.getElementById('imageInput').click();
		});

		$('#imageInput').change(function(e){
			var files = e.target.files || e.dataTransfer.files;
			setImage(files[0]);
		});

		$('#clearImage').click(function(e){
			$('#imageInput').val('');
			$('#productImage').attr('src', "{{asset('img/img_temp.png')}}");
		});

		function setImage(file) {
			var image = new Image();
			var reader = new FileReader();
			
			reader.onload = (e) => {
				$('#productImage').attr('src', e.target.result);
			};
			reader.readAsDataURL(file);
		}

		$('#newCategoryBtn').click(function(e){
			var categoryModal = new GlobalWidget();
			categoryModal.setTitle('Categories')
						.setRoute("{{route('product.category.create')}}")
						.setCallback(fetchCategories)
						.init();
		});

		function fetchCategories(){
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type:'GET',
				url:"{{route('product.categories.fetch')}}",
				data:null,
				success:function(data) {
					updateCategories(data.data);
				}
			});
		}

		function updateCategories(data){
			let html = '';
			for(i in data){
				html += `<option value="` + data[i].ps_category_id + `">` + data[i].category_name + `</option>`
			}
			$('#categoriesSelect').html(html);
		}
	});
</script>
@endsection