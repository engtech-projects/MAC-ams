<form action="{{route('SystemSetupController.currency.update')}}" method="post">
	@csrf
	<div class="row">
		<div class="col-md-12 frm-header">
			<h3 class="card-title"><b>Currency Settings</b></h3>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="box">
				<div class="form-group">
					<label class="label-normal" for="currency">Currency</label>
					<div class="input-group">
						<select name="currency" class="form-control form-control-sm" id="" required>
							<option value="" disabled {{ empty($currency->currency_id) ? 'selected' : '' }}>Select Currency</option>
							@foreach($currencies as $currency)
							<option value="{{$currency->currency_id}}" {{$currency->status == 'active' ? 'selected' : ''}}>{{$currency->abbreviation . ' - ' . $currency->currency}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="box">
				<label class="label-normal" for="">&nbsp;</label>
				<div class="input-group">
					<input type="submit"  class="btn btn-success form-control-sm form-control" value="UPDATE">
				</div>
			</div>
		</div>
	</div>
</form>