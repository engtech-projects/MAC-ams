@extends('layouts.app')

@section('content')
    <style type="text/css">
        .select2-container {
            position: relative;
            width: 250px;
        }

        .select2-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .select2-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ccc;
            overflow-y: auto;
            z-index: 1000;
            border-radius: 4px;
            list-style: none;
            padding: 0;
            margin-top: 2px;
        }

        .select2-option {
            padding: 8px;
            cursor: pointer;
        }

        .select2-option:hover {
            background-color: #f0f0f0;
        }

        .no-results {
            padding: 8px;
            color: #888;
        }

        .dataTables_filter {
            float: left !important;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            background-color: #3d9970 !important;
            color: #fff !important;
            border-radius: 0px;
        }

        .nav-link:hover,
        .nav-link:focus {
            background-color: #4ec891 !important;
            color: #fff !important;
            border-radius: 0px;

        }

        .frm-header {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4ec891;
        }

        .search-custom {
            display: block;
            position: absolute;
            z-index: 999;
            width: 100%;
            margin: 0px !important;
            color: #3d9970 !;
            font-weight: bold;
            font-size: 14px;
        }

        .dataTables_filter {
            float: right !important;
        }
    </style>

    <!-- Main content -->
    <section class="content" id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="spacer" style="margin-top:10px;"></div>
                    <div class="card">
                        <div class="row">
                            <div class="card-body" style="padding:0.4em;">
                                <div class="nav  nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @if (checkUserHasAccessModule('sub-module', 'companySettings'))
                                        <a class="nav-link sysnav" id="v-pills-CompanySettings-tab" data-toggle="pill"
                                            href="#v-pills-CompanySettings" role="tab"
                                            aria-controls="v-pills-CompanySettings" aria-selected="false"><i
                                                class="nav-icon fas fa-building"></i> Company Settings</a>
                                    @endif
                                    @if (checkUserHasAccessModule('sub-module', 'JournalBook'))
                                        <a class="nav-link sysnav" id="v-pills-JournalBook-tab" data-toggle="pill"
                                            href="#v-pills-JournalBook" role="tab" aria-controls="v-pills-JournalBook"
                                            aria-selected="false"><i class="nav-icon fas fa-book"></i> Journal Book</a>
                                    @endif
                                    @if (checkUserHasAccessModule('sub-module', 'CategoryFile'))
                                        <a class="nav-link sysnav" id="v-pills-CategoryFile-tab" data-toggle="pill"
                                            href="#v-pills-CategoryFile" role="tab" aria-controls="v-pills-CategoryFile"
                                            aria-selected="false"><i class="nav-icon fas fa-tachometer-alt"></i> Category
                                            File</a>
                                    @endif
                                    @if (checkUserHasAccessModule('sub-module', 'system-setup/activity-logs'))
                                        <a class="nav-link sysnav" id="v-pills-activity-logs-tab" data-toggle="pill"
                                            href="#v-pills-activity-logs" role="tab"
                                            aria-controls="v-pills-activity-logs" aria-selected="false" @click="fetchActivityLogs"><i
                                                class="nav-icon fas fa-tachometer-alt"></i> Activity
                                            Logs</a>
                                    @endif
                                    @if (checkUserHasAccessModule('sub-module', 'UserMasterFile'))
                                        <a class="nav-link sysnav" id="v-pills-UserMasterFile-tab" data-toggle="pill"
                                            href="#v-pills-UserMasterFile" role="tab"
                                            aria-controls="v-pills-UserMasterFile" aria-selected="false"><i
                                                class="nav-icon fas fa-user"></i> User Master File</a>
                                    @endif
                                    @if (checkUserHasAccessModule('sub-module', 'accounting'))
                                        <a class="nav-link sysnav" id="v-pills-Accounting-tab" data-toggle="pill"
                                            href="#v-pills-Accounting" role="tab" aria-controls="v-pills-Accounting"
                                            aria-selected="false"><i class="nav-icon fas fa-cash-register"></i>
                                            Accounting</a>
                                    @endif
                                    @if (checkUserHasAccessModule('sub-module', 'system-setup/posting-periods'))
                                        <a class="nav-link sysnav" id="v-pills-posting-period-tab" data-toggle="pill"
                                            href="#v-pills-posting-period" role="tab"
                                            aria-controls="v-pills-posting-period" aria-selected="false"><i
                                                class="nav-icon fas fa-calendar"></i> Posting
                                            Period</a>
                                    @endif
                                    @if (checkUserHasAccessModule('sub-module', 'currency'))
                                        <a class="nav-link sysnav" id="v-pills-Currency-tab" data-toggle="pill"
                                            href="#v-pills-Currency" role="tab" aria-controls="v-pills-Currency"
                                            aria-selected="false"><i class="nav-icon fas fa-dollar-sign"></i> Currency</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="v-pills-tabContent">
                                <!----------------------------------------- J O U R N A L B O O K M O D U L E ------------------------------------------->
                                <div class="tab-pane fade" id="v-pills-JournalBook" role="tabpanel"
                                    aria-labelledby="v-pills-JournalBook-tab">
                                    @include('systemSetup.sections.journalBook')
                                </div>
                                <!-----------------------------------------/ END J O U R N A L B O O K M O D U L E ------------------------------------------->


                                <!----------------------------------------- C A T E G O R Y F I L E M O D U L E ------------------------------------------->
                                <div class="tab-pane fade" id="v-pills-CategoryFile" role="tabpanel"
                                    aria-labelledby="v-pills-CategoryFile-tab">
                                    <form id="categoryFileForm" method="post">
                                    @csrf
                                        <input type="hidden" class="form-control form-control-sm rounded-0" name="catId" id="catId" placeholder="">
                                        <div class="row">
                                            <div class="col-md-12 frm-header">
                                                <h3 class="card-title"><b>Category File Settings</b></h3>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <div class="box">
                                                    <div class="form-group">
                                                        <label class="label-normal" for="sub_cat_code">Category Code</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm rounded-0"
                                                                name="sub_cat_code" id="sub_cat_code"
                                                                placeholder="Category Code" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <div class="box">
                                                    <div class="form-group">
                                                        <label class="label-normal" for="sub_cat_name">Category Name</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm rounded-0"
                                                                name="sub_cat_name" id="sub_cat_name"
                                                                placeholder="Category Name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="box">
                                                    <div class="form-group">
                                                        <label class="label-normal" for="sub_cat_type">Category Type</label>
                                                        <div class="input-group">
                                                            <select class="select2 form-control form-control-sm rounded-0"
                                                                name="sub_cat_type" id="sub_cat_type">
                                                                <option value="" selected disabled hidden></option>
                                                                <option value="depre">Depreciation</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="box">
                                                    <div class="form-group">
                                                        <label class="label-normal" for="cat_description">Description</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm rounded-0"
                                                                name="cat_description" id="cat_description"
                                                                placeholder="Description">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <div class="box">
                                                    <div class="form-group">
                                                        <label class="label-normal" for="select-account-credit">Account (Credit)</label>
                                                        <select name="account_id" ref="credit"
                                                            class="select2 form-control form-control-sm"
                                                            id="select-account-credit" value="" required>
                                                            <option value="">Select Account</option>
                                                            <option v-for="account in accounts" :key="account.account_id"
                                                                :value="account.account_id">
                                                                @{{ account.account_name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <div class="box">
                                                    <div class="form-group">
                                                        <label class="label-normal" for="select-account-debit">Account (Debit)</label>
                                                        <select name="account_id_debit" ref="debit"
                                                            class="select2 form-control form-control-sm" 
                                                            id="select-account-debit" required>
                                                            <option value="">Select Account</option>
                                                            <option v-for="account in accounts" :key="account.account_id"
                                                                :value="account.account_id">
                                                                @{{ account.account_name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-9 col-xs-12"></div>
                                            <div class="col-md-3" style="padding-bottom:20px;">
                                                <div class="box">
                                                    <div class="input-group">
                                                        <input type="submit" id="submitCatBtn" class="btn btn-success form-control" value="SAVE">
                                                        <input type="button" id="cancelCatBtn" class="btn btn-danger" style="display: none; margin-left: 10px;" value="CANCEL">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <!-- Table -->
                                                <section class="content">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table id="categoryFileTbl" class="table table-bordered">
                                                                    <thead>
                                                                        <th>Code</th>
                                                                        <th>Name</th>
                                                                        <th>Type</th>
                                                                        <th>Description</th>
                                                                        <th>Account (Credit)</th>
                                                                        <th>Account (Debit)</th>
                                                                        <th>Action</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($subsidiaryCategories as $subsidiaryCategory)
                                                                        @php
                                                                            $creditAccount = $subsidiaryCategory->accounts()
                                                                                ->wherePivot('transaction_type', 'credit')
                                                                                ->first();
                                                                            $debitAccount = $subsidiaryCategory->accounts()
                                                                                ->wherePivot('transaction_type', 'debit')
                                                                                ->first();
                                                                        @endphp
                                                                            <tr>
                                                                                <td class="font-weight-bold">
                                                                                    {{ $subsidiaryCategory->sub_cat_code }}</td>
                                                                                <td>{{ $subsidiaryCategory->sub_cat_name }}</td>
                                                                                <td>{{ $subsidiaryCategory->sub_cat_type == 'depre' ? 'Depreciation' : '' }}</td>
                                                                                <td>{{ $subsidiaryCategory->description }}</td>
                                                                                <td>{{ $creditAccount->account_name ?? 'N/A' }}</td>
                                                                                <td>{{ $debitAccount->account_name ?? 'N/A' }}</td>
                                                                                <td>
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <button
                                                                                                value="{{ $subsidiaryCategory->sub_cat_id }}"
                                                                                                vtype="edit"
                                                                                                class="btn btn-categoryA btn-info btn-sm"><i
                                                                                                    class="fa  fa-pen"></i></button>
                                                                                        </div>
                                                                                        @if (isDeletable('subsidiary', 'sub_cat_id', $subsidiaryCategory->sub_cat_id))
                                                                                            <div class="col-md-4">
                                                                                                <button
                                                                                                    value="{{ $subsidiaryCategory->sub_cat_id }}"
                                                                                                    vtype="delete"
                                                                                                    class="btn btn-categoryA btn-danger btn-sm"><i
                                                                                                        class="fa fa-trash"></i></button>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="col-md-4">
                                                                                                <button
                                                                                                    class="btn btn-danger btn-sm disabled"
                                                                                                    onclick="alert('This category is already used in other field')"><i
                                                                                                        class="fa fa-trash"></i></button>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                                <!-- /.Table -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-----------------------------------------/ END C A T E G O R Y F I L E M O D U L E ----------------------------------------->


                                <!----------------------------------------- A C T I V I T Y L O G S M O D U LE ---------------------------------------------------------------->
                                <div class="tab-pane fade" id="v-pills-activity-logs" role="tabpanel"
                                    aria-labelledby="v-pills-activity-logs-tab">


                                    <div class="row">
                                        <div class="col-md-12 frm-header">
                                            <h3 class="card-title"><b>Activity Logs</b></h3>
                                        </div>
                                        <div class="col-md-12 ml-3 mb-3">
                                            <form>
                                                <div class="row align-items-center">
                                                    <div class="col-md-2.5">
                                                        <select class="form-control"
                                                            v-model="filter.log_name">
                                                            <option value="" disabled selected>Module Name</option>
                                                            <option value="">All Modules</option>
                                                            <option value="Journal Entry">Journal Entry</option>
                                                            <option value="Journal Entry List">Journal Entry List</option>
                                                            <option value="Subsidiary Ledger">Subsidiary Ledger</option>
                                                            <option value="General Ledger">General Ledger</option>
                                                            <option value="Income Statement">Income Statement</option>
                                                            <option value="Cashier's Transaction Blotter">Cashier's Transaction Blotter</option>
                                                            <option value="System Setup">System Setup</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select class="form-control"
                                                            v-model="filter.event">
                                                            <option value="" disabled selected>Event</option>
                                                            <option value="">All Events</option>
                                                            <option value="created">Created</option>
                                                            <option value="updated">Updated</option>
                                                            <option value="deleted">Deleted</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 d-flex align-items-center">
                                                        <label class="mb-0 mr-2">From:</label>
                                                        <input type="date" v-model="filter.date_from" class="form-control">
                                                        <label class="mb-0 ml-2 mr-2">To:</label>
                                                        <input type="date" v-model="filter.date_to" class="form-control">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="button" @click="searchActivityLog()"
                                                            class="btn btn-success" value="Search">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-md-12">
                                            <!-- Table -->
                                            <section class="content">
                                                <div class="container-fluid">
                                                    <div class="col-md-12">
                                                        <table id="categoryFileTbl" class="table table-sm table-striped ">
                                                            <thead>
                                                                <th width="15%">Module Name</th>
                                                                <th>Description</th>
                                                                <th>Subject Type</th>
                                                                <th>Log By</th>
                                                                <th>Role</th>
                                                                <th>Event</th>
                                                                <th>Date & Time</th>
                                                                <th>Action</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="activityLog in activityLogs"
                                                                    :key="activityLog.id" style="vertical-align: middle;">
                                                                    <td>@{{ activityLog.log_name }}</td>
                                                                    <td>@{{ activityLog.description }}</td>
                                                                    <td>@{{ activityLog.subject_type }}</td>
                                                                    <td width="17%">@{{ activityLog.causer }}</td>
                                                                    <td>@{{ activityLog.user_role.role_name }}</td>
                                                                    <td width="7%" style="text-transform: capitalize;">@{{ activityLog.event }}</td>
                                                                    <td width="9%">@{{ activityLog.created_at }}</td>
                                                                    <td width="1%" class="text-center">

                                                                        <button type="button"
                                                                            class="btn btn-xs btn-success"
                                                                            @click="viewActivityLog(activityLog.id)"
                                                                            data-toggle="modal"
                                                                            data-target="#view-activity">
                                                                            <i class="fa fa-eye"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        <nav v-if="pagination.last_page > 1" aria-label="Page navigation">
                                                            <ul class="pagination justify-content-center">
                                                                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                                                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1)">
                                                                        Prev
                                                                    </a>
                                                                </li>
                                                                
                                                                <li v-for="page in visiblePages" 
                                                                    :key="page" 
                                                                    class="page-item" 
                                                                    :class="{ active: page === pagination.current_page }">
                                                                    <a class="page-link" href="#" @click.prevent="changePage(page)">
                                                                        @{{ page }}
                                                                    </a>
                                                                </li>
                                                                
                                                                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                                                                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1)">
                                                                        Next
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </nav>

                                                        <!-- Pagination Info -->
                                                        <div class="text-center" v-if="pagination.total">
                                                            <p class="text-muted">
                                                                Showing @{{ pagination.from }} to @{{ pagination.to }} of @{{ pagination.total }} entries
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- /.Table -->
                                        </div>
                                    </div>
                                </div>
                                <!-----------------------------------------/ END A C T I V I T Y L O G S M O D U L E ------------------------------------------->


                                <!----------------------------------------- U S E R M A S T E R F I L E M O D U L E ------------------------------------------->
                                <div class="tab-pane fade" id="v-pills-UserMasterFile" role="tabpanel"
                                    aria-labelledby="v-pills-UserMasterFile-tab">
                                    @include('systemSetup.sections.userMasterFile')

                                </div>
                                <!-----------------------------------------/END U S E R M A S T E R F I L E M O D U L E ------------------------------------------->

                                <!-----------------------------------------C O M P A N Y S E T T I N G S M O D U L E ------------------------------------------->
                                <div class="tab-pane fade" id="v-pills-CompanySettings" role="tabpanel"
                                    aria-labelledby="v-pills-CompanySettings-tab">
                                    @include('systemSetup.sections.companySettings')
                                </div>
                                <!-----------------------------------------/END C O M P A N Y S E T T I N G S M O D U L E ------------------------------------------->
                                <div class="tab-pane fade" id="v-pills-Accounting" role="tabpanel"
                                    aria-labelledby="v-pills-Accounting-tab">
                                    @include('systemSetup.sections.accounting')
                                </div>

                                <!-----------------------------------------P O S T I N G P E R I O D M O D U L E ------------------------------------------->
                                <div class="tab-pane fade" id="v-pills-posting-period" role="tabpanel"
                                    aria-labelledby="v-pills-Accounting-tab">
                                    <div class="row mb-5">

                                        <div class="col-md-4 select2-container">
                                            <div>
                                                <select ref="year"
                                                    class="select2 select-year form-control form-control-sm"
                                                    v-model="postingPeriodYear">
                                                    <option v-for="year in postingPeriodYears" :key="year">
                                                        @{{ year }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button @click="searchPostingPeriod()" class="btn btn-primary">
                                                Search</button>
                                        </div>

                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Posting Period</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(row, index) in postingPeriods" :key="index">
                                                <td>

                                                    <span>@{{ formatPostingPeriod(row.posting_period) }}</span>
                                                </td>
                                                <td>

                                                    <input class="form-control" v-if="editIndex === index" type="date"
                                                        v-model="editRow.start_date"
                                                        :min="getStartMonth(editRow.start_date)"
                                                        :max="getEndMonth(row.end_date)" />
                                                    <span v-else>@{{ row.start_date }}</span>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-if="editIndex === index" type="date"
                                                        v-model="editRow.end_date" :min="getStartMonth(editRow.start_date)"
                                                        :max="getEndMonth(editRow.end_date)">
                                                    <span v-else>@{{ row.end_date }}</span>
                                                </td>
                                                <td>
                                                    <select class="form-control" v-if="editIndex === index"
                                                        v-model="editRow.status">
                                                        <option value="closed">closed</option>
                                                        <option value="open">open</option>
                                                    </select>
                                                    <span v-else>@{{ row.status }}</span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-xs btn-success" v-if="editIndex === index"
                                                        @click="saveEdit(editRow.id,index)">Save</button>
                                                    <button class="btn btn-xs btn-danger" v-if="editIndex === index"
                                                        @click="cancelEdit">Cancel</button>
                                                    <button class="btn btn-xs btn-primary" v-else
                                                        @click="startEdit(index)">Edit</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-----------------------------------------/END P O S T I N G P E R I O D M O D U L E ------------------------------------------->

                                <!-----------------------------------------C U R R E N C Y M O D U L E ------------------------------------------->
                                <div class="tab-pane fade" id="v-pills-Currency" role="tabpanel"
                                    aria-labelledby="v-pills-Currency-tab">
                                    @include('systemSetup.sections.currency')
                                </div>
                                <!-----------------------------------------/ END C U R R E N C Y M O D U L E ------------------------------------------->

                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="view-activity" tabindex="-1" role="dialog" aria-labelledby="viewActivityLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="viewActivityLabel">
                            Activity Log - @{{ activityLog.log_name }}
                        </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-bold">
                                        Log Info
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    Description:
                                                </div>
                                                <div class="col-md-6">
                                                    @{{ activityLog.description }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    Log by:
                                                </div>
                                                <div class="col-md-6">
                                                    @{{ activityLog.causer }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    Event:
                                                </div>
                                                <div class="col-md-6" style="text-transform: capitalize;">
                                                    @{{ activityLog.event }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    Subject:
                                                </div>
                                                <div class="col-md-8">
                                                    <ul>
                                                        <li v-for="key in Object.keys(activityLog.subject?.data || {}).sort()" :key="key">
                                                            @{{ key }} : @{{ activityLog.subject.data[key] }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-bold">
                                        Properties
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header text-bold">
                                                    New Values
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <ul>
                                                        <li v-for="key in Object.keys(activityLog.properties?.attributes || {}).sort()" :key="key">
                                                            @{{ key }} : @{{ activityLog.properties.attributes[key] }}
                                                        </li>
                                                    </ul>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header text-bold">
                                                    Old Values
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <ul>
                                                        <li v-for="key in Object.keys(activityLog.properties?.old || {}).sort()" :key="key">
                                                            @{{ key }} : @{{ activityLog.properties.old[key] }}
                                                        </li>
                                                    </ul>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        new Vue({
            el: '#app',
            data: {
                filter: {
                    'log_name': '',
                    'event': '',
                    'date_from': '',
                    'date_to': ''
                },
                activityLogs: [],
                activityLog: {},
                postingPeriods: [],
                year: null,
                postingPeriodYears: null,
                isCreate: false,
                dateRange: null,
                minYear: 2000,
                error: '',
                maxYear: new Date().getFullYear(),
                postingPeriodYear: "", //new Date().getFullYear(),
                selectedYear: null,
                open: false,
                open_period: {},
                allYears: [],
                filteredYears: [],
                postingPeriod: {
                    posting_period: null,
                    start_date: null,
                    end_date: null,
                    status: null,
                },
                isEdit: false,
                currentYear: new Date().getFullYear(),
                editIndex: null,
                editIndex: null,
                editRow: {},
                isValidYear: false,
                accounts: {},
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 15,
                    total: 0,
                    from: 0,
                    to: 0
                },
            },
            computed: {
                visiblePages() {
                    const pages = [];
                    const current = this.pagination.current_page;
                    const last = this.pagination.last_page;
                    
                    let start = Math.max(1, current - 2);
                    let end = Math.min(last, current + 2);
                    
                    if (current <= 3) {
                        end = Math.min(5, last);
                    }
                    if (current >= last - 2) {
                        start = Math.max(1, last - 4);
                    }
                    
                    for (let i = start; i <= end; i++) {
                        pages.push(i);
                    }
                    
                    return pages;
                }
            },
            created() {
                for (let y = this.currentYear; y >= 1900; y--) {
                    this.allYears.push(y);
                }
                this.filteredYears = this.allYears;
            },
            watch: {

                postingPeriodYear(newVal) {
                    if (!newVal) this.filteredYears = this.allYears;
                }
            },
            methods: {
                focusFilter() {
                    this.open = true;
                },
                isObject(val) {
                    return val?.attributes !== null && typeof val?.attributes === 'object' && !Array.isArray(val);
                },
                searchActivityLog() {
                    this.fetchActivityLogs(1);
                },
                fetchActivityLogs(page = 1) {
                    axios.get('system-setup/activity-logs', {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                        },
                        params: {
                            'event': this.filter.event,
                            'log_name': this.filter.log_name,
                            'date_from': this.filter.date_from,
                            'date_to': this.filter.date_to,
                            'page': page
                        }
                    }).then(response => {
                        this.activityLogs = response.data.data;
                        this.pagination = {
                            current_page: response.data.current_page,
                            last_page: response.data.last_page,
                            per_page: response.data.per_page,
                            total: response.data.total,
                            from: response.data.from,
                            to: response.data.to
                        };
                    }).catch(err => {
                        console.error(err)
                        toastr.error('Failed to load activity logs.');
                    })
                },
                changePage(page) {
                    if (page >= 1 && page <= this.pagination.last_page) {
                        this.fetchActivityLogs(page);
                    }
                },
                viewActivityLog(id) {
                    axios.get('system-setup/activity-logs/' + id, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        this.activityLog = response.data.data;
                    }).catch(err => {
                        console.error(err)
                    })
                },
                fetchAccounts() {
                    axios.get('accounts').then(res => {
                            this.accounts = res.data.data;
                        })
                        .catch(err => {
                            toastr.error("Failed to load subsidiaries.");
                        });

                },
                filterOptions() {
                    return this.postingPeriodYear.years;
                    const term = this.postingPeriodYear.toLowerCase();
                    this.filteredYears = this.postingPeriodYears.filter(year =>
                        year.toString().includes(term)
                    );
                },
                selectYear(year) {
                    this.selectedYear = year;
                    this.postingPeriodYear = year.toString();
                    this.open = false;
                },
                handleClickOutside(event) {
                    const dropdown = this.$el.querySelector('.select2-container');
                    if (!dropdown.contains(event.target)) {
                        this.open = false;
                    }
                },
                filterYears() {
                    const term = this.postingPeriodYear.toLowerCase();
                    this.filteredYears = this.allYears.filter(year =>
                        year.toString().includes(term)
                    );
                },
                selectYear(year) {
                    this.selectedYear = year;
                    this.postingPeriodYear = year.toString();
                    this.open = false;
                },
                validateYear() {
                    if (this.year < this.minYear) {
                        this.error = `Year must be at least ${this.minYear}.`;
                    } else if (this.year > this.maxYear) {
                        this.error = `Year must be no later than ${this.maxYear}.`;
                    } else {
                        this.error = '';
                    }
                },
                handleChange(event) {
                    if (this.postingPeriodYear != "") {
                        this.year = "";
                    }
                },
                getMinYear(period) {
                    return `${period}-01`;
                },
                getMaxYear(period) {
                    return `${period}-31`;
                },
                searchPostingPeriod() {
                    this.postingPeriodYear = this.$refs.year.options[this.$refs.year.selectedIndex].text
                    if (this.postingPeriodYear) {
                        axios.get('system-setup/posting-periods/posting-period', {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                            },
                            params: {
                                year: this.postingPeriodYear
                            }
                        }).then(response => {
                            this.postingPeriods = response.data.data
                            if (response.data.was_created) {
                                toastr.success(response.data.message);
                                this.fetchPostingPeriodYears();
                            }
                        }).catch(err => {
                            console.error(err)
                            toastr.error('Failed to fetch posting periods.');
                        })
                    }
                },
                getStartMonth(date) {
                    var date = date.split("-");
                    return date[0] + "-" + date[1] + "-01";
                },
                getEndMonth(date) {
                    var date = date.split("-");
                    return date[0] + "-" + date[1] + "-31";
                },
                startEdit(index) {
                    this.editIndex = index

                    this.editRow = {
                        ...this.postingPeriods[index]
                    }

                },
                cancelEdit() {
                    this.editIndex = null
                    this.editRow = {}
                },
                saveEdit(index) {
                    this.rows[index] = {
                        ...this.editRow
                    }
                    this.cancelEdit()
                },
                reload() {
                    location.reload();
                },
                formatPostingPeriod(monthVal) {
                    if (!monthVal) return '';
                    const [year, month] = monthVal.split('-');
                    const date = new Date(year, month - 1);
                    return date.toLocaleString('default', {
                        month: 'long',
                        year: 'numeric'
                    });
                },
                createPostingPeriod() {
                    axios.post('system-setup/posting-periods/posting-period', {
                        year: this.postingPeriodYear
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                    }).then(response => {
                        toastr.success(response.data.message);
                        window.location.reload();
                    }).catch(err => {
                        console.error(err)
                    })
                },
                saveEdit: function(id, index) {
                    axios.put('system-setup/posting-periods/posting-period/' + id, this.editRow, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        this.postingPeriods[index] = {
                            ...this.editRow
                        }
                        toastr.success(response.data.message);
                        this.cancelEdit()
                    }).catch(err => {
                        console.error(err)
                    })
                },
                processEdit(index) {
                    this.editIndex = index
                    this.postingPeriods = {
                        ...this.postingPeriods[index]
                    }
                },

                fetchPostingPeriodYears: function() {
                    axios.get('system-setup/posting-periods/years', {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        this.postingPeriodYears = response.data.data.years
                        this.open_period = response.data.data.open_period
                    }).catch(err => {
                        console.error(err)
                    })
                },

                fetchPostingPeriods: function() {
                    axios.get('system-setup/posting-periods/posting-period', {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        params: {
                            year: this.postingPeriodYear
                        }
                    }).then(response => {
                        this.postingPeriods = response.data.data
                    }).catch(err => {
                        console.error(err)
                    })
                },
            },
            mounted() {
                this.fetchPostingPeriods();
                this.fetchPostingPeriodYears();
                this.fetchAccounts();
                document.addEventListener('click', this.handleClickOutside);
                this.fetchActivityLogs();


            },
            beforeDestroy() {
                document.removeEventListener('click', this.handleClickOutside);
            }

        });
    </script>
    <!-- /.content -->
@endsection


@section('footer-scripts')
    @include('scripts.systemSetup.systemSetup')
@endsection
