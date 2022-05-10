<form action="{{route('SystemSetupController.currency.update')}}" method="post">
	@csrf
	<div class="row">
		<div class="col-md-12 frm-header">
			<h3 class="card-title"><b>Category File Settings</b></h3>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="currency">Code</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="Code1" id="Code"  placeholder="Code" required>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="Category">Category</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="Category" id="Category"  placeholder="Category" required>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<!-- Table -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<table id="categoryFileTbl" class="table table-bordered">
							<thead>
								<th width="20%">Code</th>
								<th width="62%">Category</th>
								<th width="13%">Action</th>
							</thead>
							<tbody>
								<tr>
									<td class="font-weight-bold">10001-ButuanCity</td>
									<td>10001-ButuanCityCateogry</td>
									<td>
										<div class="row">
											<div class="col-md-4">
												<button class="btn btn-info btn-sm"><i class="fa  fa-pen"></i></button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="font-weight-bold">10001-ButuanCity</td>
									<td>10001-ButuanCityCateogry</td>
									<td>
										<div class="row">
											<div class="col-md-4">
												<button class="btn btn-info btn-sm"><i class="fa  fa-pen"></i></button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="font-weight-bold">10001-ButuanCity</td>
									<td>10001-ButuanCityCateogry</td>
									<td>
										<div class="row">
											<div class="col-md-4">
												<button class="btn btn-info btn-sm"><i class="fa  fa-pen"></i></button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="font-weight-bold">10001-ButuanCity</td>
									<td>10001-ButuanCityCateogry</td>
									<td>
										<div class="row">
											<div class="col-md-4">
												<button class="btn btn-info btn-sm"><i class="fa  fa-pen"></i></button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="font-weight-bold">10001-ButuanCity</td>
									<td>10001-ButuanCityCateogry</td>
									<td>
										<div class="row">
											<div class="col-md-4">
												<button class="btn btn-info btn-sm"><i class="fa  fa-pen"></i></button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="font-weight-bold">10001-ButuanCity</td>
									<td>10001-ButuanCityCateogry</td>
									<td>
										<div class="row">
											<div class="col-md-4">
												<button class="btn btn-info btn-sm"><i class="fa  fa-pen"></i></button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</section>
			<!-- /.Table -->
		</div>
		<div class="col-md-12 col-xs-12 ">
			<div class="col-md-4">
				<div class="box">
					<label class="label-normal" for="">&nbsp;</label>
					<div class="input-group">
						<input type="submit"  class="btn btn-success form-control-sm form-control" value="UPDATE / SAVE">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>