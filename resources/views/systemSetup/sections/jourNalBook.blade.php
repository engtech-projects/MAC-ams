<form id="bookJournalForm" method="post">
	@csrf
	<input type="hidden" class="form-control form-control-sm rounded-0" name="bookId" id="bookId"  placeholder="" >
	<div class="row">
		<div class="col-md-12 frm-header">
			<h3 class="card-title"><b>Journal Book Settings</b></h3>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="book_code">Book Code</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="book_code" id="book_code"  placeholder="Book Code" required>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="book_name">Book Name</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="book_name" id="book_name"  placeholder="Book Name" required>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="book_src">Book Source</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="book_src" id="book_src"  placeholder="Book Source" required>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="book_ref">Book Reference</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="book_ref" id="book_ref"  placeholder="Book Reference" required>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="book_head">Book Head</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="book_head" id="book_head"  placeholder="Print Voucher" required>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="printVoucher">Book Flag</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="book_flag" id="book_flag"  placeholder="Book Flag" required>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4" style="padding-bottom:10px;">
				<div class="box">
					<label class="label-normal" for="">&nbsp;</label>
					<div class="input-group">
						<input type="submit"  class="btn btn-success form-control-sm form-control" value="UPDATE / SAVE">
					</div>
				</div>
		</div>
		<div class="col-md-12">
			<!-- Table -->
			<section class="content">
				<div class="container-fluid">
					<div class="row" >
						<div class="col-md-12">
							<table id="journalBookTble"  class="table table-bordered">
								<thead>
									<th>Code</th>
									<th>Name</th>
									<th>Src</th>
									<th>Ref</th>
									<th>Flag</th>
									<th>Head</th>
									<th>Action</th>
								</thead>
								<tbody>
									@foreach($journalBookList as $journalbook)
										<tr>
											<td class="font-weight-bold">{{$journalbook->book_code;}}</td>
											<td>{{$journalbook->book_name;}}</td>
											<td>{{$journalbook->book_src;}}</td>
											<td>{{$journalbook->book_ref;}}</td>
											<td>{{$journalbook->book_flag;}}</td>
											<td>{{$journalbook->book_head;}}</td>
											<td>
												<div class="row">
													<div class="col-md-4">
														<button vtype="edit" value="{{$journalbook->book_id}}" class="btn btn-bookA btn-info btn-sm"><i class="fa  fa-pen"></i></button>
													</div>
													<div class="col-md-4">
														<button vtype="delete" value="{{$journalbook->book_id}}" class="btn btn-bookA btn-danger btn-sm"><i class="fa fa-trash"></i></button>
													</div>
												</div>
											</td>
										</tr>
									@endforeach
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
			<!-- /.Table -->
		</div>
		
	</div>
</form>