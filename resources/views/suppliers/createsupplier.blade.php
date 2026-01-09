<form id="frm-create-supplier" action="{{ route('supplier.store') }}">
  @csrf

<div class="row">

	<div class="col-md-1">
		<div class="form-group">
		    <label for="" class="label-normal">Title</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="title">
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		    <label for="" class="label-normal">First name</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="firstname">
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		    <label for="" class="label-normal">Middle name</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="middlename">
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		    <label for="" class="label-normal">Last name</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="lastname">
		</div>
	</div>

	<div class="col-md-1">
		<div class="form-group">
		    <label for="" class="label-normal">Suffix</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="suffix">
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
		    <label for="" class="label-normal">Email</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="email_address">
		</div>
	</div>
</div>

<div class="row">
	
	<div class="col-sm-3">
		<div class="form-group">
		    <label for="" class="label-normal">Display name <i class="fa fa-asterisk fa-xs text-red" aria-hidden="true"></i> </label>
		    <input type="text" class="form-control form-control-sm rounded-0" required name="displayname">
		</div>
	</div>

	<div class="col-sm-3">
		<div class="form-group">
		    <label for="" class="label-normal">Company</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="company">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
		    <label for="" class="label-normal">Tin number</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="tin_number">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
		    <label for="" class="label-normal">Phone</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="phone_number">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
		    <label for="" class="label-normal">Mobile</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="mobile_number">
		</div>
	</div>
</div>

<div class="row">
	
	<div class="col-sm-2">
		<div class="form-group">
		    <label for="" class="label-normal">Street</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="street">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
		    <label for="" class="label-normal">City</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="city">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
		    <label for="" class="label-normal">Province</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="province">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
		    <label for="" class="label-normal">Zip Code</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="zip_code">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
		    <label for="" class="label-normal">Country</label>
		    <input type="text" class="form-control form-control-sm rounded-0" name="country">
		</div>
	</div>
</div>

<div class="row" style="border-top: 1px solid #f1f1f1; padding: 10px; margin-top:50px;">

	<div class="col-md-6">
	  <small class="form-text">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit....</small>
	</div>
	<div class="col-md-6 text-right">
	  <button type="button" class="btn btn-flat btn-default btn-sm" data-dismiss="modal">Cancel</button>
	  <button type="submit" class="btn btn-flat bg-gradient-success btn-sm">Save</button>
	</div>
</div>

</form>
