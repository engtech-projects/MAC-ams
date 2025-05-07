@extends('layouts.app')

@section('content')
    <style type="text/css">
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
                                    @if (checkUserHasAccessModule('sub-module', 'accounting'))
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
                                <div class="tab-pane fade" id="v-pills-JournalBook" role="tabpanel"
                                    aria-labelledby="v-pills-JournalBook-tab">
                                    @include('systemSetup.sections.journalBook')
                                </div>
                                <div class="tab-pane fade" id="v-pills-CategoryFile" role="tabpanel"
                                    aria-labelledby="v-pills-CategoryFile-tab">
                                    @include('systemSetup.sections.categoryFile')
                                </div>
                                <div class="tab-pane fade" id="v-pills-UserMasterFile" role="tabpanel"
                                    aria-labelledby="v-pills-UserMasterFile-tab">
                                    @include('systemSetup.sections.userMasterFile')
                                </div>
                                <div class="tab-pane fade" id="v-pills-CompanySettings" role="tabpanel"
                                    aria-labelledby="v-pills-CompanySettings-tab">
                                    @include('systemSetup.sections.companySettings')
                                </div>
                                <div class="tab-pane fade" id="v-pills-Accounting" role="tabpanel"
                                    aria-labelledby="v-pills-Accounting-tab">
                                    @include('systemSetup.sections.accounting')
                                </div>

                                <div class="tab-pane fade" id="v-pills-posting-period" role="tabpanel"
                                    aria-labelledby="v-pills-Accounting-tab">
                                    <div class="row mb-5">
                                        <div class="col-md-2">
                                            <select class="form-control" v-model="currentYear">
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option value="2023">2023</option>
                                                <option value="2022">2022</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button @click="search()" class="btn btn-primary"> Search</button>
                                        </div>

                                    </div>

                                    <div v-if="postingPeriods.length === 0" class="alert alert-success" role="alert">
                                        <h4 class="alert-heading text-white">No data found</h4>
                                        <p>You wish to create posting periods for the year of @{{ currentYear }}?</p>
                                        <hr>
                                        <p class="mb-0">Click <span class="text-blue text-bold">CREATE</span> to
                                            proceed.</p>
                                        <div class="d-flex justify-content-end">
                                            <div class="mr-auto p-2"></div>
                                            <div class="p-2"></div>
                                            <div class="p-2">
                                                <div class="container">

                                                    <button class="btn btn-sm btn-primary"
                                                        @click="createPostingPeriod()">Create</button>
                                                    <button class="btn btn btn-default" @click="reload()">Cancel</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <table v-if="postingPeriods.length >=1" class="table table-striped">
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
                                                    <input class="form-control" v-if="editIndex === index" type="text"
                                                        v-model="editRow.posting_period" />
                                                    <span v-else>@{{ row.posting_period }}</span>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-if="editIndex === index" type="date"
                                                        v-model="editRow.start_date" />
                                                    <span v-else>@{{ row.start_date }}</span>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-if="editIndex === index" type="date"
                                                        v-model="editRow.end_date" />
                                                    <span v-else>@{{ row.end_date }}</span>
                                                </td>
                                                <td>
                                                    <select class="form-control" v-if="editIndex === index"
                                                        v-model="editRow.status">
                                                        <option value="Closed">Closed</option>
                                                        <option value="Open">Open</option>
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
                                <div class="tab-pane fade" id="v-pills-Currency" role="tabpanel"
                                    aria-labelledby="v-pills-Currency-tab">
                                    @include('systemSetup.sections.currency')
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <script>
        new Vue({
            el: '#app',
            data: {
                postingPeriods: {},
                title: 'Hello World',
                isEdit: false,
                currentYear: new Date().getFullYear(),
                editIndex: null,

                rows: [{
                        posting_date: '2025-05-01',
                        start_date: '2025-05-05',
                        end_date: '2025-05-10',
                        status: 'active'
                    },
                    {
                        posting_date: '2025-06-01',
                        start_date: '2025-06-03',
                        end_date: '2025-06-08',
                        status: 'inactive'
                    }
                ],
                editIndex: null,
                editRow: {}
            },
            methods: {
                search() {
                    this.fetchPostingPeriods();
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
                createPostingPeriod() {
                    axios.post('/MAC-ams/posting-period', {
                        year: this.currentYear
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                    }).then(response => {
                        this.postingPeriods = response.data.data
                        toastr.success(response.data.message);
                    }).catch(err => {
                        console.error(err)
                    })
                },
                saveEdit: function(id, index) {
                    axios.put('/MAC-ams/posting-period/' + id, this.editRow, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        console.log(this.rows[index])
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
                fetchPostingPeriods: function() {
                    axios.get('/MAC-ams/posting-period', {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        params: {
                            year: this.currentYear
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
            }

        });
    </script>
    <!-- /.content -->
@endsection


@section('footer-scripts')
    @include('scripts.systemSetup.systemSetup')
@endsection
