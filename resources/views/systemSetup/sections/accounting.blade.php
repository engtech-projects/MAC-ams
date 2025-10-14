<form action="{{route('SystemSetupController.accounting.update')}}" method="post">
	@csrf
	<div class="row">
		<div class="col-md-12 frm-header">
			<h3 class="card-title"><b>Accounting Settings</b></h3>
		</div>
		<div class="col-md-6">
			<div class="box" style="margin-bottom:24px;">	
				<div class="form-group" style="">
					<label class="label-normal" for="start_date">Start Date</label>
					<div class="input-group">
						<input type="date" class="form-control form-control-sm rounded-0" name="start_date" value="{{isset($accounting->start_date) ? formatDate('Y-m-d', $accounting->start_date) : ''}}" placeholder="" required>
					</div>
				</div>
				<div class="form-group" style="">
					<label class="label-normal" for="end_date">End Date</label>
					<div class="input-group">
						<input type="date" class="form-control form-control-sm rounded-0" name="end_date" value="{{isset($accounting->end_date) ? formatDate('Y-m-d', $accounting->end_date) : ''}}" placeholder="" required>
					</div>
				</div>
				
			</div>
		</div>

		<div class="col-md-6">
			<div class="box" style="margin-bottom:24px;">	
				<div class="form-group" style="">
					<label class="label-normal" for="method">Method</label>
					<select name="method" class="form-control form-control-sm" id="">
						<option value="" disabled {{ empty($accounting->method) ? 'selected' : '' }}>Select Method</option>
						@if($accounting)
						<option value="accrual" {{$accounting->method == 'accrual' ? 'selected' : ''}}>Accrual</option>
						<option value="cash" {{$accounting->method == 'cash' ? 'selected' : ''}}>Cash</option>
						@else
						<option value="accrual">Accrual</option>
						<option value="cash">Cash</option>
						@endif
					</select>
				</div>
				<div class="form-group" style="">
					<label class="label-normal" for="">&nbsp;</label>
					<div class="input-group">
						<input type="submit" style="flex:1" class="btn btn-success form-control-sm form-control" value="UPDATE">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>