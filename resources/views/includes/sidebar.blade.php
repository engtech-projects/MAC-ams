<aside class="main-sidebar elevation-4 sidebar-light-olive">
	<!-- Brand Logo -->
	<a href="{{route('dashboard')}}" class="brand-link elevation-4">
		<span class="brand-text font-weight-bold" style="font-size:1em; padding-left:2px;">Micro Access Loan Corporation</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar" style="overflow-y: auto;">
		<!-- Sidebar user (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image" style="line-height:50px;">
				<img src="{{ asset('img/default_user.fw.png') }}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				Welcome
				<a href="#" class="d-block"><b>{{ ucwords(Auth::user()->personal_info->fname)}} {{ ucwords(Auth::user()->personal_info->lname)}}</b></a>
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

			@if(checkUserHasAccessModule('module','journal'))
			<li class="nav-item {{ (request()->is('journal') || request()->is('journal/journalEntry') || request()->is('journal/journalEntryList')) ? 'menu-open' : '' }}">
				<a href="{{ route('sales') }}" class="nav-link {{ (request()->is('journal') || request()->is('journal/journalEntry') || request()->is('journal/journalEntryList')) ? '' : '' }}">
					<i class="nav-icon fas fa-address-book"></i>
					<p>
					Journal
					<i class="right fas fa-angle-left"></i>
					</p>
				</a>
			<ul class="nav nav-treeview">

				@if(checkUserHasAccessModule('sub-module','journal/journalEntry'))
				<li class="nav-item">
					<a href="{{route('journal.journalEntry')}}" class="nav-link {{ request()->is('journal/journalEntry') ? 'active' : '' }}">
						<i class="far fa-circle nav-icon"></i>
						<p>Journal Entry</p>
					</a>
				</li>
				@endif
				@if(checkUserHasAccessModule('sub-module','journal/journalEntryList'))
				<li class="nav-item">
					<a href="{{route('journal.journalEntryList')}}" class="nav-link {{ request()->is('journal/journalEntryList') ? 'active' : '' }}" class="nav-link">
						<i class="far fa-circle nav-icon"></i>
						<p>Journal Entry List</p>
					</a>
				</li>
				@endif
			</ul>
			</li>
			@endif
			@if(checkUserHasAccessModule('module','Disbursement'))
			<li class="nav-item {{ (request()->is('disbursement')) ? 'menu-open' : '' }} {{ (request()->is('supplier')) ? 'menu-open' : '' }}">
			<a href="#" class="nav-link {{ (request()->is('disbursement')) ? 'active' : '' }} {{ (request()->is('supplier')) ? 'active' : '' }}">
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

			@if(checkUserHasAccessModule('module','reports'))
			<li class="nav-item {{ (isset($nav) && $nav[0] == 'reports') ? 'menu-open' : '' }} {{ (request()->is('reports') || request()->is('reports/journalledger') || request()->is('reports/subsidiary-ledger') || request()->is('reports/generalLedger') || request()->is('reports/trialBalance') || request()->is('reports/incomeStatement') || request()->is('reports/cashTransactionBlotter')
					|| request()->is('reports/bankReconcillation') || request()->is('reports/cashPosition') || request()->is('reports/cheque') || request()->is('reports/postDatedCheque')|| request()->is('reports/chartOfAccounts')) ? 'menu-open' : '' }}">
			<a href="{{ route('sales') }}" class="nav-link {{  (request()->is('reports/subsidiary-ledger')) ? 'active' : '' }}">
				<i class="nav-icon fas fa-clipboard-list"></i>
				<p>
				Reports
				<i class="right fas fa-angle-left"></i>
				</p>
			</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="{{ route('reports.journalLedger') }}" class="nav-link {{ (request()->is('reports/journalledger')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Journal Ledger</p>
						</a>
					</li>
					@if(checkUserHasAccessModule('sub-module','reports/subsidiary-ledger'))
                    <form id="subsidiary-ledger" action="{{ route('reports.subsidiary-ledger') }}" method="POST" style="display: none;">
                        <input type="hidden" name="type" value="subsidiary-ledger">
                        @csrf
                    </form>
					<li class="nav-item">
						<a
                        onclick="event.preventDefault(); document.getElementById('subsidiary-ledger').submit();"
                        href="{{ route('reports.subsidiary-ledger') }}"
                        class="nav-link {{ (request()->is('reports/subsidiary-ledger')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Subsidiary Ledger</p>
						</a>
					</li>
					@endif
					@if(checkUserHasAccessModule('sub-module','reports/journal_entry'))
					<li class="nav-item">
						<a href="{{ route('reports.journal_entry') }}" class="nav-link {{ (request()->is('reports/journal_entry')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Journal Entry</p>
						</a>
					</li>
					@endif
					@if(checkUserHasAccessModule('sub-module','reports/generalLedger'))
					<li class="nav-item">
						<a href="{{ route('reports.generalLedger') }}" class="nav-link {{ (request()->is('reports/generalLedger')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>General Ledger</p>
						</a>
					</li>
					@endif
					@if(checkUserHasAccessModule('sub-module','reports/trialBalance'))
					<li class="nav-item">
						<a href="{{ route('reports.trialBalance') }}" class="nav-link {{ (request()->is('reports/trialBalance')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Trial Balance</p>
						</a>
					</li>
					@endif
					@if(checkUserHasAccessModule('sub-module','reports/incomeStatement'))
					<li class="nav-item">
						<a href="{{ route('reports.incomeStatement') }}" class="nav-link {{ (request()->is('reports/incomeStatement')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Income Statement</p>
						</a>
					</li>
					@endif
					@if(checkUserHasAccessModule('sub-module','reports/bankReconcillation'))
					<li class="nav-item">
						<a href="{{ route('reports.bankReconcillation') }}" class="nav-link {{ (request()->is('reports/bankReconcillation')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Bank Reconciliation</p>
						</a>
					</li>
					@endif
					@if(checkUserHasAccessModule('sub-module','reports/cashPosition'))
					<li class="nav-item">
						<a href="{{ route('reports.cashPosition') }}" class="nav-link {{ (request()->is('reports/cashPosition')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Cash Position</p>
						</a>
					</li>
					@endif
					@if(checkUserHasAccessModule('sub-module','reports/cashTransactionBlotter'))
					<li class="nav-item">
						<a href="{{ route('reports.cashTransactionBlotter') }}"  class="nav-link {{ (request()->is('reports/cashTransactionBlotter')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Cashier's Transaction Blotter</p>
						</a>
					</li>
					@endif
					@if(checkUserHasAccessModule('sub-module','reports/cheque'))
					<li class="nav-item">
						<a href="{{ route('reports.cheque') }}" class="nav-link {{ (request()->is('reports/cheque')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Cheque</p>
						</a>
					</li>
					@endif
					@if(checkUserHasAccessModule('sub-module','reports/postDatedCheque'))
					<li class="nav-item">
						<a href="{{ route('reports.postDatedCheque') }}" class="nav-link {{ (request()->is('reports/postDatedCheque')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Post-Dated Cheque</p>
						</a>
					</li>
					@endif
					@if(checkUserHasAccessModule('sub-module','reports/chartOfAccounts'))
					<li class="nav-item">
						<a href="{{route('reports.chartOfAccounts')}}" class="nav-link {{ (request()->is('reports/chartOfAccounts')) ? 'active' : '' }}">
							<i class="far fa-circle nav-icon"></i>
							<p>Chart Of Accounts</p>
						</a>
					</li>
					@endif

				</ul>
			</li>
			@endif

			@if(checkUserHasAccessModule('module','Chart of Accounts'))
			<li class="nav-item ">
			<a href="{{url('accounts')}}" class="nav-link {{ (request()->is('accounts')) ? 'active' : '' }}">
				<i class="nav-icon fas fa fa-book"></i>
				<p>
					Chart of Accounts
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
	</div>
	<div class="col-md-12">

		<img src="{{ asset('img/mac_logo.fw.png') }}" alt="mac_logo" class="img-fluid">
	</div>

</aside>

