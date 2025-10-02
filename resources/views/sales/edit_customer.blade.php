@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
	<form action="{{route('customer.update',['customer_id'=>$customer->customer_id])}}" method="post">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<h3 style="margin-bottom:32px;">Edit Customer Information</h3>
				<div class="row">
					<div class="col-md-6">
						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1">
								<label class="label-normal" for="exampleInputPassword1">Title</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="title" id="titleInput" value="{{$customer->title}}" placeholder="">
								</div>
							</div>
							<div class="form-group" style="margin-right:10px;flex:2">
								<label class="label-normal" for="exampleInputPassword1">First Name</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="firstname" id="firstnameInput" value="{{$customer->firstname}}" placeholder="">
								</div>
							</div>
							<div class="form-group" style="margin-right:10px;flex:2">
								<label class="label-normal" for="exampleInputPassword1">Middle Name</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="middlename" id="middlenameInput" value="{{$customer->middlename}}" placeholder="">
								</div>
							</div>
							<div class="form-group" style="margin-right:10px;flex:2">
								<label class="label-normal" for="exampleInputPassword1">Last Name</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="lastname" id="lastnameInput" value="{{$customer->lastname}}" placeholder="">
								</div>
							</div>
							<div class="form-group" style="flex:1">
								<label class="label-normal" for="exampleInputPassword1">Suffix</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="suffix" id="suffixInput" value="{{$customer->suffix}}" placeholder="">
								</div>
							</div>
						</div>

						<div>
							<div class="form-group">
								<label class="label-normal" for="exampleInputPassword1"><span style="color:#e74c3c;">*</span>Display name as</label>
								<div class="input-group">
									<input name="displayname" id="displayname" value="{{$customer->displayname}}" class="form-control form-control-sm rounded-0" required>
								</div>
							</div>
						</div>

						<div>
							<div class="form-group">
								<label class="label-normal" for="exampleInputPassword1">Company</label>
								<div class="input-group">
									<input name="company" id="companyInput" value="{{$customer->company}}" class="form-control form-control-sm rounded-0">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="label-normal" for="exampleInputPassword1">Billing Address</label>
							<div class="input-group">
								<textarea class="form-control form-control-sm rounded-0" name="bstreet" id="bstreetInput" cols="30" rows="3" placeholder="Street">{{$customer->billingAddress()->street}}</textarea>
							</div>
						</div>

						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="bcity" id="bcityInput" value="{{$customer->billingAddress()->city}}" placeholder="City">
								</div>
							</div>
							<div class="form-group" style="flex:1">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="btown" value="{{$customer->billingAddress()->province}}" id="btownInput" placeholder="Town">
								</div>
							</div>
						</div>

						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="bpostal_code" value="{{$customer->billingAddress()->zip_code}}" id="bpostalInput" placeholder="Postal Code">
								</div>
							</div>
							<div class="form-group" style="flex:1">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="bcountry" value="{{$customer->billingAddress()->country}}" id="bcountryInput" placeholder="Country">
								</div>
							</div>
						</div>
					</div>


					<div class="col-md-6">
						<div style="display:flex;">
							<div class="form-group" style="flex:1">   
								<label class="label-normal" for="exampleInputPassword1">Email</label>
								<div class="input-group">
									<input type="email" class="form-control form-control-sm rounded-0" name="email_address" value="{{$customer->email_address}}" id="emailInput" placeholder="">
								</div>
							</div>
						</div>

						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Phone</label>
								<div class="input-group">
									<input type="text" name="phone_number" value="{{$customer->phone_number}}" class="form-control form-control-sm rounded-0" id="phoneInput" placeholder="">
								</div>
							</div>
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Mobile</label>
								<div class="input-group">
									<input type="text" name="mobile_number" value="{{$customer->mobile_number}}" class="form-control form-control-sm rounded-0" id="mobileInput" placeholder="">
								</div>
							</div>
							<div class="form-group" style="flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Tin</label>
								<div class="input-group">
									<input type="text" name="tin" value="{{$customer->tin}}" class="form-control form-control-sm rounded-0" id="mobileInput" placeholder="">
								</div>
							</div>
						</div>

						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<label class="label-normal" for="exampleInputPassword1">Gender</label>
								<div class="input-group">
									<select name="gender" id="genderSelect" class="form-control form-control-sm rounded-0">
										<option value="" disabled {{ (!$customer->gender) ? 'selected' : '' }}></option>
										<option value="male" {{ ($customer->gender == 'male') ? 'selected' : '' }}>Male</option>
										<option value="female" {{ ($customer->gender == 'female') ? 'selected' : '' }}>Female</option>
									</select>
								</div>
							</div>
							<div class="form-group" style="flex:1">   
								<label class="label-normal" for="exampleInputPassword1">Date of birth</label>
								<div class="input-group">
									<input type="date" name="birthdate" value="{{$customer->birth_date}}" class="form-control form-control-sm rounded-0" id="birthDate" placeholder="">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="label-normal" style="display:flex;align-items:center;" for="exampleInputPassword1">Shipping Address <span style="margin-left:10px;display:flex;align-items:center;color:#aaa;"><input id="addressCB" style="margin-right:5px;" type="checkbox"> Same as billing address</span></label>
							<div class="input-group">
								<textarea class="form-control form-control-sm rounded-0" name="sstreet" id="sstreetInput" cols="30" rows="3" placeholder="Street">{{$customer->shippingAddress()->street}}</textarea>
							</div>
						</div>

						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="scity" id="scityInput" value="{{$customer->shippingAddress()->city}}" placeholder="City">
								</div>
							</div>
							<div class="form-group" style="flex:1">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="stown" value="{{$customer->shippingAddress()->province}}" id="stownInput" placeholder="Town">
								</div>
							</div>
						</div>

						<div style="display:flex;">
							<div class="form-group" style="margin-right:10px;flex:1;">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="spostal_code" value="{{$customer->shippingAddress()->zip_code}}" id="spostalInput" placeholder="Postal Code">
								</div>
							</div>
							<div class="form-group" style="flex:1">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm rounded-0" name="scountry" value="{{$customer->shippingAddress()->country}}" id="scountryInput" placeholder="Country">
								</div>
							</div>
						</div>

						<div style="display:flex;justify-content:flex-end">
							<div class="form-group" style="margin-right:16px;">   
								<a href="{{route('sales.customers')}}" class="btn btn-default" style="padding-left:24px;padding-right:24px;">Cancel</a>
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
		$('#addressCB').change(function(e){
			if(this.checked){
				sameAddress();
			}else{
				clearAddress();
			}
		});

		function sameAddress(){
			$('#sstreetInput').val($('#bstreetInput').val());
			$('#stownInput').val($('#btownInput').val());
			$('#scityInput').val($('#bcityInput').val());
			$('#spostalInput').val($('#bpostalInput').val());
			$('#scountryInput').val($('#bcountryInput').val());
		}

		function clearAddress(){
			$('#sstreetInput').val('');
			$('#stownInput').val('');
			$('#scityInput').val('');
			$('#spostalInput').val('');
			$('#scountryInput').val('');
		}
	});
</script>
@endsection