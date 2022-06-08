<form id="categoryFileForm" method="post">
	@csrf
	<input type="hidden" class="form-control form-control-sm rounded-0" name="catId" id="catId"  placeholder="" >
	<div class="row">
		<div class="col-md-12 frm-header">
			<h3 class="card-title"><b> Category File Settings</b></h3>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="sub_cat_code"> Category Code</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="sub_cat_code" id="sub_cat_code"  placeholder="Category Code" required>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="sub_cat_name"> Category Name</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="sub_cat_name" id="sub_cat_name"  placeholder="Category Name" required>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="sub_cat_type"> Category Type</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="sub_cat_type" id="sub_cat_type"  placeholder="Category Type" required>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="sub_cat_type">Description</label>
					<div class="input-group">
						<textarea type="text" class="form-control form-control-sm rounded-0" name="cat_description" id="cat_description"  placeholder="Category Type"></textarea>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-xs-12" style="padding-bottom:20px;">
			<div class="col-md-4">
				<div class="box">
					<label class="label-normal" for="">&nbsp;</label>
					<div class="input-group">
						<input type="submit"  class="btn btn-success form-control-sm form-control" value="UPDATE / SAVE">
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<!-- Table -->
			<section class="content">
				<div class="container-fluid">
					<div class="col-md-12">
						<table id="categoryFileTbl" class="table table-bordered">
							<thead>
								<th  width="15%">Category Code</th>
								<th>Category Name</th>
								<th>Category Type</th>
								<th>Description</th>
								<th width="13%">Action</th>
							</thead>
							<tbody>
								@foreach($subsidiaryCategories as $subsidiaryCategory)
								<tr>
									<td class="font-weight-bold">{{$subsidiaryCategory->sub_cat_code}}</td>
									<td>{{$subsidiaryCategory->sub_cat_name}}</td>
									<td>{{$subsidiaryCategory->sub_cat_type}}</td>
									<td>{{$subsidiaryCategory->description}}</td>
									<td>
										<div class="row">
											<div class="col-md-4">
												<button value="{{$subsidiaryCategory->sub_cat_id}}" vType="edit" class="btn btn-categoryA btn-info btn-sm"><i class="fa  fa-pen"></i></button>
											</div>
											@if(isDeletable('subsidiary', 'sub_cat_id', $subsidiaryCategory->sub_cat_id))
											<div class="col-md-4">
												<button value="{{$subsidiaryCategory->sub_cat_id}}" vType="delete" class="btn btn-categoryA btn-danger btn-sm"><i class="fa fa-trash"></i></button>
											</div>
											@else
												<div class="col-md-4">
													<button class="btn  btn-danger btn-sm disabled" onclick="alert('this category is already used in other field')"><i class="fa fa-trash" ></i></button>
												</div>
											@endif
										</div>
									</td>
								</tr>
								@endforeach
								
							</tbody>
						</table>
					</div>
				</div>
			</section>
			<!-- /.Table -->
		</div>
		
	</div>
</form>