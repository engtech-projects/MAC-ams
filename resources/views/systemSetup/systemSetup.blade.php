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
            max-height: 150px;
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

                                        <div class="col-md-4 select2-container">
                                            <input type="text" class="form-control" v-model="postingPeriodYear"
                                                @focus="open = true" @input="filterOptions"
                                                placeholder="Select a year..." class="select2-input" />

                                            <ul v-if="open" class="select2-dropdown">
                                                <li v-for="year in postingPeriodYears" :key="year"
                                                    @click="selectYear(year)" class="select2-option">
                                                    @{{ year }}
                                                </li>
                                                <li v-if="filteredYears.length === 0" class="text-red no-results">No
                                                    results
                                                    found, click search to proceed for creating posting period.
                                                    <div class="container">
                                                        <button class="btn btn-sm btn-primary"
                                                            @click="createPostingPeriod()">Create</button>
                                                        <button class="btn btn btn-warning"
                                                            @click="reload()">Cancel</button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        {{-- <input type="number" @change="validateYear()" :min="minYear"
                                                :max="maxYear" v-model="year" class="form-control">
                                            <p v-if="error" class="text-red">@{{ error }}</p> --}}


                                        {{-- <div class="col-md-2">
                                            <select @change="handleChange()" class="form-control"
                                                v-model="postingPeriodYear">
                                                <option value="">Select Year</option>
                                                <option v-for="(postingYear,i) in postingPeriodYears"
                                                    :key="i" :value="postingYear">
                                                    @{{ postingYear }}
                                                </option>
                                            </select>
                                        </> --}} <div class="col-md-2">
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
                isValidYear: false
            },
            computed: {

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
                filterOptions() {
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
                    if (this.postingPeriodYear) {
                        this.fetchPostingPeriods();

                    }

                },
                getStartMonth(date) {
                    var date = date.split("-");
                    /*     console.log(date[0] + "-" + date[1] + "-01"); */
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
                    console.log(this.editRow);
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
                    axios.post('/MAC-ams/posting-period', {
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
                    axios.put('/MAC-ams/posting-period/' + id, this.editRow, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        console.log(this.postingPeriods[index]);
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
                /*                 minYear(postingPeriod) {
                                    const period = postingPeriod.split(" ");
                                    return '01-01-' + period[1]
                                },
                                maxYear(postingPeriod) {
                                    const period = postingPeriod.split(" ");
                                    return '12-31-' + period[1]
                                }, */

                fetchPostingPeriodYears: function() {
                    axios.get('/MAC-ams/posting-period-years', {
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
                    axios.get('/MAC-ams/posting-period', {
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

                document.addEventListener('click', this.handleClickOutside);
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
