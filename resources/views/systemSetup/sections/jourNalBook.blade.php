<form action="{{route('SystemSetupController.currency.update')}}" method="post">
	@csrf
	<div class="row">
		<div class="col-md-12 frm-header">
			<h3 class="card-title"><b>Journal Book Settings</b></h3>
		</div>
		<div class="col-md-3 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="currency">Code</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="Code1" id="Code"  placeholder="Code" required>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="bookName">Book Name</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="bookName" id="bookName"  placeholder="Book Name" required>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="refTtle">Ref Title</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="refTtle" id="refTtle"  placeholder="Reference Title" required>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="printVoucher">Print Voucher</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="printVoucher" id="printVoucher"  placeholder="Print Voucher" required>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<!-- Table -->
			<section class="content">
				<div class="container-fluid">
					<div class="row" style="overflow-x:auto;">
						<table id="journalBookTble" class="table table-bordered">
							<thead>
								<th>Code</th>
								<th>Book Name</th>
								<th>Ref Title</th>
								<th>Source Document</th>
								<th>Voucher</th>
								<th>Action</th>
							</thead>
							<tbody>
								<tr>
									<td class="font-weight-bold">Code1</td>
									<td>Book Name1</td>
									<td>Ref.Title1</td>
									<td>SourceDocument</td>
									<td>voucher1</td>
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