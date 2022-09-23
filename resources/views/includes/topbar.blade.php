<style>
	.cDate{
		padding-left:20px;
		font-size:1.3rem;
	}
	.buttons-colvis, .buttons-colvis:hover, .buttons-colvis:active{
		background:#28a745;
		color:white;
	}
</style>
<nav class="main-header navbar navbar-expand navbar-light">
<!-- Left navbar links -->
	<ul class="navbar-nav">
	  <li class="nav-item">
	    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
	  </li>
	
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<li class="nav-item cDate">
			<div class="d-inline p-4 "><font id="currentDate"></font></div>
			<div class="d-inline p-4" >Time : <font id="currentTime"></font> </div>
	  	</li>
		  
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fa fa-bell"></i>
				<!-- <span class="badge badge-warning navbar-badge">15</span> -->
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header">Notifications</span>
				<div class="dropdown-divider"></div>
			<a href="#" class="dropdown-item">
				<i class="fas fa-chart-line mr-2"></i>Sales
				<span class="float-right text-muted text-sm">0</span>
			</a>
			<div class="dropdown-divider"></div>
			<a href="{{ route('logout') }}" class="dropdown-item">
				<i class="fas fa-money-check mr-2"></i> Expenses
				<span class="float-right text-muted text-sm">0</span>
			</a>
		</li>
	  <li class="nav-item dropdown">
	    <a class="nav-link" data-toggle="dropdown" href="#">
	      <i class="fa fa-ellipsis-v"></i>
	      <!-- <span class="badge badge-warning navbar-badge">15</span> -->
	    </a>
	    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
	      <div class="dropdown-divider"></div>
	      <a href="{{route('user.profile')}}" class="dropdown-item">
	        <i class="fas fa-user mr-2"></i> Profile
	        <span class="float-right text-muted text-sm">View/Edit User Profile</span>
	      </a>
	      <div class="dropdown-divider"></div>
	      <a href="{{ route('logout') }}" class="dropdown-item">
	        <i class="fas fa-sign-out-alt mr-2"></i> Logout
	        <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
	      </a>
	  </li>
	</ul>
</nav>