@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
  	<div class="row">
		<div class="col-md-12">
			<div style="margin-bottom:24px;display:flex;justify-content:space-between;align-items:center;">
				<h3>User Profile</h3>
			</div>
			<div class="row">
					<div class="col-md-6">
					<div class="accordion" id="faq">
                    <div class="card">
                        <div class="card-header" style="display:flex;align-items:center;" id="faqhead1">
                            <a href="#" style="flex:1;" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1"
                            aria-expanded="true" aria-controls="faq1">
								<div class="row">
									<div class="col-md-4">
										<span class="font-weight-bold">Username</span> 
									</div>
									<div class="col-md-7">
										{{Auth::user()->username}} 
									</div>
									<div class="col-md-1" style="text-align:right;">
									<span class="arrow fa fa-chevron-right"></span> 
									<span class="arrow2 fa fa-chevron-down"></span> 
									</div>
								</div>
							</a>
							
                        </div>

                        <div id="faq1" class="collapse" aria-labelledby="faqhead1" data-parent="#faq">
                            <div class="card-body">
							<form action="{{route('username.update')}}" method="post">
								@csrf
								<div class="row">
									<div class="col-md-11">
										<input type="text" class="form-control" name="username" placeholder="Username" value="{{Auth::user()->username}}">
									</div>
									<div class="col-md-1">
										<!-- <a href="" class="btn btn-success">Save</a> -->
										<input type="submit" class="btn btn-success" value="Save">
									</div>
								</div>
							</form>  
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="faqhead2">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq2"
                            aria-expanded="true" aria-controls="faq2">
								<div class="row">
									<div class="col-md-4">
										<span class="font-weight-bold">Password</span> 
									</div>
									<div class="col-md-7">
										***** 
									</div>
									<div class="col-md-1" style="text-align:right;">
									<span class="arrow fa fa-chevron-right"></span> 
									<span class="arrow2 fa fa-chevron-down"></span> 
									</div>
								</div>
							</a>
                        </div>

                        <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                            <div class="card-body">
								<form action="{{route('password.update')}}" method="post">
									@csrf
									<span>Change Password</span>
									<div class="mb-3">
										<input type="password" name="current" class="form-control" placeholder="Current Password" value="" required>
										@if(Session::has('password_error'))
											<span class="text-danger">{{Session::get('password_error')}}</span>
										@endif
									</div>
													
									<input type="password" name="new" class="form-control mb-3" placeholder="New Password" value="" required> 
									
									<div class="mb-3">
										<input type="password" name="confirm" class="form-control mb-3" placeholder="Confirm Password" value="" required>
										@if(Session::has('confirm_error'))
											<span class="text-danger">{{Session::get('confirm_error')}}</span>
										@endif
									</div>
									<div style="display:flex;justify-content:flex-end"><input type="submit" value="Save" class="btn btn-success pull-right" style="padding-left:25px;padding-right:25px;"></div>
								</form>
                            </div>
                        </div>
                    </div>
                </div>
					</div>
				</div>
		</div>
	</div>
  </div>
</section>
<!-- /.content -->
@endsection