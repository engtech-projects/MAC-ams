
<form action="{{route('SystemSetupController.company.update')}}" method="POST">
	@csrf
	<div class="row">
		<div class="col-md-12 frm-header">
			<h3 class="card-title"><b>Company Settings Setup</b></h3>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="box" style="margin-bottom:24px;">
				<h4 style="font-size:16px;text-transform:uppercase;margin-bottom:24px;">Company Information</h4>
				<div class="form-group" style="">
					<label class="label-normal" for="exampleInputPassword1">Company Name</label>
					<div class="input-group">
						<input type="text" class="form-control form-control-sm rounded-0" name="company_name" id="company_nameInput" value="{{isset($company->company_name) ? $company->company_name:''}}" placeholder="" required>
					</div>
				</div>
				<div class="form-group" style="">
					<label class="label-normal" for="exampleInputPassword1">Company Email</label>
					<div class="input-group">
						<input type="email" class="form-control form-control-sm rounded-0" name="company_email" id="company_emailInput" value="{{isset($company->company_email) ? $company->company_email:''}}" placeholder="" required>
					</div>
				</div>
				<div style="display:flex;">
					<div class="form-group" style="margin-right:10px;flex:1;">
						<label class="label-normal" for="exampleInputPassword1">Phone</label>
						<div class="input-group">
							<input type="text" name="phone_number" value="{{isset($company->phone_number) ? $company->phone_number:''}}" class="form-control form-control-sm rounded-0" id="phoneInput" placeholder="">
						</div>
					</div>
					<div class="form-group" style="flex:1;">
						<label class="label-normal" for="exampleInputPassword1">Mobile</label>
						<div class="input-group">
							<input type="text" name="contact_number" value="{{isset($company->contact_number) ? $company->contact_number:''}}" class="form-control form-control-sm rounded-0" id="mobileInput" placeholder="">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="box">
				<h4 style="font-size:16px;text-transform:uppercase;margin-bottom:24px;">Company Address</h4>
				<div class="form-group">
					<div class="input-group">
						<textarea class="form-control form-control-sm rounded-0" name="address" id="" cols="30" rows="3" placeholder="Street" value="{{isset($company->address->street) ? $company->address->street:''}}">{{isset($company->address->street) ? $company->address->street:''}}</textarea>
					</div>
				</div>
				<div style="display:flex;">
					<div class="form-group" style="margin-right:10px;flex:1;">
						<div class="input-group">
							<input type="text" class="form-control form-control-sm rounded-0" name="city" id="cityInput" value="{{isset($company->address->city) ? $company->address->city:''}}" placeholder="City">
						</div>
					</div>
					<div class="form-group" style="flex:1">
						<div class="input-group">
							<input type="text" class="form-control form-control-sm rounded-0" name="town" value="{{isset($company->address->province) ? $company->address->province:''}}" id="townInput" placeholder="Town">
						</div>
					</div>
				</div>
				<div style="display:flex;">
					<div class="form-group" style="margin-right:10px;flex:1;">
						<div class="input-group">
							<input type="text" class="form-control form-control-sm rounded-0" name="postal_code" value="{{isset($company->address->zip_code) ? $company->address->zip_code:''}}" id="postalInput" placeholder="Postal Code">
						</div>
					</div>
					<div class="form-group" style="flex:1">
						<div class="input-group">
							<input type="text" class="form-control form-control-sm rounded-0" name="country" value="{{isset($company->address->country) ? $company->address->country:''}}" id="countryInput" placeholder="Country">
						</div>
					</div>
				</div>
				<div style="display:flex;margin-top:16px;">
					<input type="submit" class="btn btn-success" value="UPDATE" style="flex:1">
				</div>
			</div>
		</div>
	</div>
</form>