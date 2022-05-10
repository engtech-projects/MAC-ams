<aside class="main-sidebar elevation-4 sidebar-light-olive">
	<!-- Brand Logo -->
	<a href="../../index3.html" class="brand-link elevation-4">
		<img src="{{ asset('img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">JustAccounting</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar" style="overflow-y: auto;">
		<!-- Sidebar user (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">{{ ucwords(Auth::user()->username) }}</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
			<!-- Add icons to the links using the .nav-icon class
				with font-awesome or any other icon font library -->
			<li class="nav-item">
			<a href="{{ route('dashboard') }}" class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}">
				<i class="nav-icon fas fa-tachometer-alt"></i>
				<p>
				Dashboard
				</p>
			</a>
			</li>
			@if(checkUserHasAccessModule('module','sales'))
			<li class="nav-item {{ (isset($nav) && $nav[0] == 'sales') ? 'menu-open' : '' }} {{ (request()->is('sales') || request()->is('sales/invoice') ) ? 'menu-open' : '' }}">
			<a href="{{ route('sales') }}" class="nav-link {{ (request()->is('sales') || (request()->is('sales/invoice')) || (request()->is('sales/customers')) || (request()->is('products_and_services'))) ? 'active' : '' }}">
				<i class="nav-icon fas fa-chart-line"></i>
				<p>
				Sales
				<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">
				@if(checkUserHasAccessModule('sub-module','sales'))
				<li class="nav-item">
				<a href="{{ route('sales') }}" class="nav-link {{ (request()->is('sales')) ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Sales</p>
				</a>
				</li>
				@endif
				@if(checkUserHasAccessModule('sub-module','sales/invoice'))
				<li class="nav-item">
				<a href="{{ route('sales.invoice') }}" class="nav-link {{ (request()->is('sales/invoice')) ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Invoices</p>
				</a>
				</li>
				@endif
				@if(checkUserHasAccessModule('sub-module','sales/customer'))
				<li class="nav-item">
				<a href="{{route('sales.customers')}}" class="nav-link {{ (isset($nav) && $nav[1] == 'customers') ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Customers</p>
				</a>
				</li>
				@endif
				@if(checkUserHasAccessModule('sub-module','products_and_services'))
				<li class="nav-item">
				<a href="{{route('products_services')}}" class="nav-link {{ (isset($nav) && $nav[1] == 'products and services') ? 'active' : '' }}" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>Product and Services</p>
				</a>
				</li>
				@endif
			</ul>
			</li>
			@endif

			@if(checkUserHasAccessModule('module','Expenses'))
			<li class="nav-item {{ (request()->is('expenses')) ? 'menu-open' : '' }} {{ (request()->is('supplier')) ? 'menu-open' : '' }}">
			<a href="#" class="nav-link {{ (request()->is('expenses')) ? 'active' : '' }} {{ (request()->is('supplier')) ? 'active' : '' }}">
				<i class="nav-icon fas fa-money-check"></i>
				<p>
				Expenses
				<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">
				@if(checkUserHasAccessModule('sub-module','expenses'))
				<li class="nav-item">
				<a href="{{ route('expenses') }}" class="nav-link {{ (request()->is('expenses')) ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Expenses</p>
				</a>
				</li>
				@endif
				@if(checkUserHasAccessModule('sub-module','supplier'))
				<li class="nav-item">
				<a href="{{ route('supplier.index') }}" class="nav-link {{ (request()->is('supplier')) ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Suppliers</p>
				</a>
				</li>
				@endif
			</ul>
			</li>
			@endif
			<!-- Employees Menu -->
			
			@if(checkUserHasAccessModule('module','Employees'))
			<li class="nav-item {{ (isset($nav) && $nav[0] == 'employees') ? 'menu-open' : '' }}">
			<a href="#" class="nav-link">
				<i class="nav-icon fas fa fa-users"></i>
				<p>
				Employees
				<i class="right fas fa-angle-left"></i>
				</p>
			</a>
			<ul class="nav nav-treeview">
				@if(checkUserHasAccessModule('sub-module','employees'))
				<li class="nav-item">
				<a href="{{route('employees')}}" class="nav-link {{ (isset($nav) && $nav[1] == 'list') ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>List of Employees</p>
				</a>
				</li>
				@endif
			</ul>
			</li>
			@endif

			@if(checkUserHasAccessModule('module','Reports'))
			<li class="nav-item">
			<a href="{{route('employees')}}" class="nav-link">
				<i class="nav-icon fas fa-list-ul"></i>
				<p>
				Reports
				</p>
			</a>
			</li>
			@endif

			@if(checkUserHasAccessModule('module','Chart of Accounts'))
			<li class="nav-item ">
			<a href="{{url('accounts')}}" class="nav-link {{ (request()->is('accounts')) ? 'active' : '' }}">
				<i class="nav-icon fas fa fa-book"></i>
				<p>
					Chart of accounts
				</p>
			</a>
		
			</li>
			@endif
			@if(checkUserHasAccessModule('module','System Setup'))
			<li class="nav-item">
			<a href="{{route('systemSetup')}}" class="nav-link {{ (request()->is('systemSetup')) ? 'active' : '' }}">
				<i class="nav-icon fas fa-cogs"></i>
				<p>
					System Setup
				</p>
			</a>
			</li>
			@endif
		</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>