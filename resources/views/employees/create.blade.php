@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<form action="{{route('employee.store')}}" method="post">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<h3 style="margin-bottom:32px;">Employee Information</h3>
				<div class="row">
					<div class="col-md-6">
						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;">
								<label class="label-normal" for="exampleInputPassword1"><span style="color:#e74c3c;">*</span>First Name</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="firstname" id="firstnameInput" value="{{old('firstname')}}" placeholder="" required>
								</div>
							</div>
							<div class="form-group" style="margin-right:10px;">
								<label class="label-normal" for="exampleInputPassword1"><span style="color:#e74c3c;">*</span>Middle Name</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="middlename" id="middlenameInput" value="{{old('middlename')}}" placeholder="" required>
								</div>
							</div>
							<div class="form-group">
								<label class="label-normal" for="exampleInputPassword1"><span style="color:#e74c3c;">*</span>Last Name</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="lastname" id="lastnameInput" value="{{old('lastname')}}" placeholder="" required>
								</div>
							</div>
						</div>

						<div>
							<div class="form-group">
								<label class="label-normal" for="exampleInputPassword1"><span style="color:#e74c3c;">*</span>Display name as</label>
								<div class="input-group">
									<input name="displayname" id="displayname" value="{{old('displayname')}}" class="form-control form-control-sm rounded-0">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="label-normal" for="exampleInputPassword1">Address</label>
							<div class="input-group">
								<textarea class="form-control form-control-sm rounded-0" name="address" id="" cols="30" rows="3" placeholder="Street" value="{{old('address')}}"></textarea>
							</div>
						</div>

						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="city" id="cityInput" value="{{old('city')}}" placeholder="City">
								</div>
							</div>
							<div class="form-group" style="flex:1">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="town" value="{{old('town')}}" id="townInput" placeholder="Town">
								</div>
							</div>
						</div>

						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="postal_code" value="{{old('postal_code')}}" id="postalInput" placeholder="Postal Code">
								</div>
							</div>
							<div class="form-group" style="flex:1">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="country" value="{{old('country')}}" id="countryInput" placeholder="Country">
								</div>
							</div>
						</div>
					</div>


					<div class="col-md-6">
						<div style="display:flex;">
							<div class="form-group" style="flex:1">   
								<label class="label-normal" for="exampleInputPassword1">Email</label>
								<div class="input-group">
									<input type="email" class="form-control form-control-sm rounded-0" name="email_address" value="{{old('email_address')}}" id="emailInput" placeholder="">
								</div>
							</div>
						</div>

						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Phone</label>
								<div class="input-group">
									<input type="text" name="phone_number" value="{{old('phone_number')}}" class="form-control form-control-sm rounded-0" id="phoneInput" placeholder="">
								</div>
							</div>
							<div class="form-group" style="flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Mobile</label>
								<div class="input-group">
									<input type="text" name="mobile_number" value="{{old('mobile_number')}}" class="form-control form-control-sm rounded-0" id="mobileInput" placeholder="">
								</div>
							</div>
						</div>

						<div style="display:flex;margin-bottom:24px;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Employee ID</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="employee_id_no" value="{{old('employee_id_no')}}" id="firstnameInput" placeholder="">
								</div>
							</div>
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Gender</label>
								<div class="input-group">
									<select name="gender" id="genderSelect" class="form-control form-control-sm rounded-0">
										<option value="" disabled selected></option>
										<option value="male">Male</option>
										<option value="female">Female</option>
									</select>
								</div>
							</div>
							<div class="form-group" style="flex:1">   
								<label class="label-normal" for="exampleInputPassword1">Date of birth</label>
								<div class="input-group">
									<input type="date" name="birthdate" value="{{old('birthdate')}}" class="form-control form-control-sm rounded-0" id="birthDate" placeholder="">
								</div>
							</div>
						</div>

						<div style="display:flex;justify-content:flex-end">
							<div class="form-group" style="margin-right:16px;">   
								<a href="{{route('employees')}}" class="btn btn-default" style="padding-left:24px;padding-right:24px;">Cancel</a>
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