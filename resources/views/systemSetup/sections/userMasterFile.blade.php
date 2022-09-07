<div class="row">
	<div class="col-md-6 col-xs-12">
		<div class="input-group" style="padding-bottom:20px;">
			<input style="padding:20px;" type="Search" class="form-control form-control-sm rounded-0" id="searchBarUser"  placeholder="Search Name" autocomplete="off">
			<div class="col-md-12">
				<div class="row">
					<ul class="list-group search-custom" id="searchContent">
						
					</ul>
				</div>
			</div>
		</div>
	</div>
	
</div>

	<div class="row">
		<div class="col-md-12 frm-header">
			<h3 class="card-title"><b>User Master File </b></h3>
		</div>
	
		<div class="col-md-4 col-xs-12">
			<form id="userMasterFileForm" method="POST">
				@csrf
				<div class="box" style="margin-bottom:24px;">
					<input type="hidden" class="form-control form-control-sm rounded-0" name="userId" id="userId">
					<h4 style="font-size:16px;text-transform:uppercase;margin-bottom:24px;">User Information</h4>
					<div class="form-group" style="">
						<label class="label-normal" for="fname">First Name</label>
						<div class="input-group">
							<input type="text" class="form-control form-control-sm rounded-0" name="fname" id="fname"  placeholder="First Name" required>
						</div>
					</div>
					<div class="form-group" style="">
						<label class="label-normal" for="mname">Middle Name</label>
						<div class="input-group">
							<input type="text" class="form-control form-control-sm rounded-0" name="mname" id="mname"  placeholder="Middle Name">
						</div>
					</div>

					<div class="form-group" style="">
						<label class="label-normal" for="lname">Last Name</label>
						<div class="input-group">
							<input type="text" class="form-control form-control-sm rounded-0" name="lname" id="lname"  placeholder="Last Name" required>
						</div>
					</div>
					<div style="display:flex;">
						<div class="form-group" style="margin-right:10px;flex:1;">
							<label class="label-normal" for="gender">Gender</label>
							<div class="input-group">
								<select name="gender" class="form-control form-control-sm" id="gender">
									<option value="" disabled selected>-select Gender-</option>
									<option value="male">male</option>
									<option value="female">female</option>
								</select>
							</div>
						</div>
						<div class="form-group" style="flex:1;">
							<label class="label-normal" for="email">Nickname</label>
							<div class="input-group">
								<input type="text" class="form-control form-control-sm rounded-0" name="displayname" id="displayname" placeholder="Display Name" required>
							</div>
						</div>
					</div>
					<div style="display:flex;">
						<div class="form-group" style="margin-right:10px;flex:1;">
							<label class="label-normal" for="email">Email</label>
							<div class="input-group">
								<input type="email"  class="form-control form-control-sm rounded-0" name="email" id="email" placeholder="Email" required>
							</div>
						</div>
						<div class="form-group" style="flex:1;">
							<label class="label-normal" for="phone_number">Phone number</label>
							<div class="input-group">
								<input type="text" name="phone_number" class="form-control form-control-sm rounded-0" id="phone_number" placeholder="Phone Number">
							</div>
						</div>
					</div>
					
					<div class="form-group" style="">
						<label class="label-normal" for="username">Username</label>
						<div class="input-group">
							<input type="text" class="form-control form-control-sm rounded-0" name="username" id="username"  placeholder="Username" required>
						</div>
					</div>
					<div class="form-group" style="">
						<label class="label-normal" for="password">Password</label>
						<div class="input-group">
							<input type="password" class="form-control form-control-sm rounded-0" name="password" id="password"  placeholder="Password" required>
						</div>
					</div>
					<div class="input-group">
						<input type="submit" style="flex:1" class="btn btn-success form-control-sm form-control" value="SAVE/UPDATE">
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-8 col-xs-12">
			<div class="box">
				<h4 style="font-size:16px;text-transform:uppercase;margin-bottom:24px;">ACCESSIBILITY</h4>
				<div class="col-md-12" style="min-height:560px; max-height:560px; overflow:auto;">
					<table class="table table-bordered"  id="systemSetupAccessibility">
						<thead>
							<tr>
								<th>Module</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody >
							@foreach ($accessLists as $accessList)
								@foreach($accessList->subModuleList as $subModuleList)
									<tr>
										<th style="vertical-align : middle;text-align:center;" scope="row" rowspan="">{{$accessList->module_name}}</th>
										<td >{{$subModuleList['description']}}</td>
										<td >
											<button id="btn_plus_{{$subModuleList['sml_id']}}"  value="{{$subModuleList['sml_id']}}" class="d-none  btn_plus  btn-subModuleList btn btn-success btn-xs"><i class="fa fa-plus"></i></button>
											<button id="btn_minus_{{$subModuleList['sml_id']}}"  value="{{$subModuleList['sml_id']}}" class="d-none btn_minus btn-subModuleList  btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
										</td>
									</tr>
								@endforeach
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>