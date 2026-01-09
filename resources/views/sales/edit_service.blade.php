@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<form action="{{route('service.update',['item_id'=>$service->item_id])}}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<h3 style="margin-bottom:32px;">Edit Service Information</h3>
				<div class="row">
					<div class="col-md-6">
						<div style="display:flex;align-items:center;">
							<div style="display:flex;flex-direction:column;flex:1;margin-right:32px;">
								<div class="form-group">
									<label class="label-normal" for="exampleInputPassword1"><span style="color:#e74c3c;">*</span>Name</label>
									<div class="input-group">
										<input name="name" id="name" value="{{$service->name}}" class="form-control form-control-sm rounded-0" required>
									</div>
								</div>
								<div class="form-group">
									<label class="label-normal" for="exampleInputPassword1">SKU</label>
									<div class="input-group">
										<input name="sku" id="sku" value="{{$service->sku}}" class="form-control form-control-sm rounded-0">
									</div>
								</div>
							</div>

							<div style="display:flex;flex-direction:column">
								<img id="productImage" src="{{productImage($service->image_path)}}" alt="" style="width:105px;height:auto;margin-bottom:5px;cursor:pointer;">
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
								<label class="label-normal" for="category">Category</label>
								<div class="input-group">
									<select name="category" id="category" class="form-control form-control-sm rounded-0">
										@foreach($categories as $category)
										<option value="{{$category->ps_category_id}}" {{selected($category->ps_category_id, $service->ps_category_id, 'selected')}}>{{$category->category_name}}</option>
										@endforeach
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
									<textarea class="form-control form-control-sm rounded-0" style="height:107px" name="description" id="description" cols="30" rows="4" placeholder="Description on sales forms" value="{{old('item_description')}}">{{$service->description}}</textarea>
								</div>
							</div>
						</div>
						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Sales price/rate</label>
								<div class="input-group">
									<input type="number" name="sales_price_rate" value="{{$service->sales_price}}" class="form-control form-control-sm rounded-0" id="salesPriceRate" placeholder="">
								</div>
							</div>
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Income Account</label>
								<div class="input-group">
									<select name="income_account" id="" class="form-control form-control-sm rounded-0">
										<option value="1">Income Account 1</option>
										<option value="2">Income Account 2</option>
										<option value="3">Income Account 3</option>
									</select>
								</div>
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
	});
</script>
@endsection