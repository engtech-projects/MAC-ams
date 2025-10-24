<style>
    .btn.btn-secondary.buttons-print,
    .btn.btn-secondary.buttons-csv.buttons-html5 {
        display: none;
    }
</style>

@extends('layouts.app')

@section('content')
    <style type="text/css">
        .dataTables_filter {
            float: left !important;
        }

        .bordered-box-content,
        .bordered-box-header {
            background: #fff;
            border: 1px solid gray;
        }

        .bordered-box-header {
            background: #c5c5c5;
        }
    </style>


    <!-- Main content -->
    <section class="content" id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="spacer" style="margin-top:20px;"></div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" style="font-size:22px"><b> Chart of Accounts </b></h4>
                            <div class="col-md-12 text-right">
                                <button @click="openModal('create-class')"
                                    class="btn btn-flat btn-sm bg-gradient-success">New Class</button>
                                <button @click="openModal('create-type')"
                                    class="btn btn-flat btn-sm bg-gradient-success">New Type</button>
                                <button @click="openModal('create-account')"
                                    class="btn btn-flat btn-sm bg-gradient-success">New Account</button>
                            </div>
                            <div class="card-tools">
                            </div>
                        </div>

                        <div class="card-body" style="background:#f5f5f5;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 col-xs-2 col-sm-2 text-center bordered-box-header">Account
                                            Number</div>
                                        <div class="col-md-4 col-xs-6 col-sm-6 text-center bordered-box-header">Account Name
                                        </div>
                                        <div class="col-md-2 col-xs-3 col-sm-3 text-center bordered-box-header">Bank
                                            Reconcillation </div>
                                        <div class="col-md-2 col-xs-1 col-sm-1 text-center bordered-box-header">Edit</div>
                                    </div>

                                    <?php $id = ''; ?>
                                    @foreach ($account_by_type as $key => $accounts)
                                        <div class="row">
                                            <div class="col-md-12 text-left "
                                                style="font-size:25px; font-weight:bold; border-bottom:1px dashed black; border-top:1px dashed black;">
                                                {{ strtoupper($key) }}</div>

                                        </div>
                                        @foreach ($accounts as $key => $account)
                                            <div class="col-md-12 text-left "
                                                style="font-size:15px; font-weight:bold; border-bottom:1px solid black; black;">
                                                {{ strtoupper($key) }}</div>


                                            @foreach ($accounts[$key] as $account)
                                                <div class="row">
                                                    <!-- <div class="col-md-2 col-xs-1 col-sm-1 text-left"></div> -->
                                                    <div class="col-md-4 col-xs-2 col-sm-2 text-center ">
                                                        {{ ucwords($account['account_number']) }}</div>
                                                    <div class="col-md-4 col-xs-5 col-sm-5 text-left ">
                                                        {{ ucwords($account['account_name']) }}</div>
                                                    <div class="col-md-2 col-xs-3 col-sm-3 text-center">
                                                        {{ ucwords($account['bank_reconcillation']) }}</div>
                                                    <div class="col-md-2 col-xs-1 col-sm-1 text-center ">
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-xs btn-default btn-flat coa-action">Report</button>
                                                            <a type="button"
                                                                class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right" role="menu"
                                                                style="left:0;">
                                                                <a class="dropdown-item btn-edit-account"
                                                                    data-remote="{{ route('accounts.show', $account['account_id']) }}"
                                                                    href="#">Edit</a>
                                                                <a class="dropdown-item btn-set-status"
                                                                    data-status="{{ $account['status'] }}"
                                                                    data-id="{{ $account['account_id'] }}"
                                                                    href="#">{{ $account['status'] }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @foreach ($account['child'] as $child)
                                                    <div class="row">
                                                        <div class="col-md-1 col-xs-1 col-sm-1 text-left"></div>
                                                        <div class="col-md-1 col-xs-1 col-sm-1 text-left"></div>
                                                        <div class="col-md-1 col-xs-1 col-sm-1 text-left"></div>
                                                        <div class="col-md-3 col-xs-2 col-sm-2 text-left ">
                                                            {{ ucwords($child['account_number']) }}</div>
                                                        <div class="col-md-3 col-xs-4 col-sm-4 text-left">
                                                            {{ ucwords($child['account_name']) }}</div>
                                                        <div class="col-md-2 col-xs-3 col-sm-3 text-center">Yes</div>
                                                        <div class="col-md-1 col-xs-1 col-sm-1 text-center ">
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                    class="btn btn-xs btn-default btn-flat coa-action">Report</button>
                                                                <a type="button"
                                                                    class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right"
                                                                    role="menu" style="left:0;">
                                                                    <a class="dropdown-item btn-edit-account"
                                                                        data-remote="{{ route('accounts.show', $child['account_id']) }}"
                                                                        href="#">Edit</a>
                                                                    <a class="dropdown-item btn-set-status"
                                                                        data-status="{{ $child['status'] }}"
                                                                        data-id="{{ $child['account_id'] }}"
                                                                        href="#">{{ $child['status'] }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>

        <div class="modal fade" id="create-account">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Account</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="label-normal">Account Type</label>
                                    <select class="select2 form-control" v-model="account.account_type_id">
                                        <option disabled value="" selected>Account Type</option>
                                        <option v-for="type in account_types" :value="type.account_type_id"
                                            v-text="type.account_type"></option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="label-normal">Account No.</label>
                                    <input type="text" class="form-control rounded-0" v-model="account.account_number"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="" class="label-normal">Account Name</label>
                                    <input type="text" class="form-control" v-model="account.account_name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="label-normal">Bank Reconciliation</label>
                                    <select class="form-control" v-model="account.bank_reconcillation">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="" class="label-normal">Sub Account</label>
                                    <input type="checkbox" class="form-control form-control-sm" v-model="account.is_sub">
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="" class="label-normal">Parent Account</label>
                                    <select class="select2 form-control" v-model="account.account_id"
                                        :disabled="!account.is_sub">
                                        <option value="" selected>Select Parent Account</option>
                                        <option v-for="account in accounts" :value="account.account_id">
                                            @{{ account.account_name }}</option>

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="label-normal">Account Description</label>
                                    <textarea rows="3" class="form-control form-control-sm" v-model="account.account_description" required>
                                </textarea>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="label-normal">Opening Balance</label>
                                    <input type="number" class="form-control form-control"
                                        v-model="account.opening_balance" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="label-normal">As Of</label>
                                    <input type="date" class="form-control form-control"
                                        v-model="account.starting_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">

                            </div>
                            <div class="col-md-3">
                                <div class="form-group float-right">
                                    <button class="btn btn-warning">
                                        Cancel
                                    </button>
                                    <button @click="createAccount()" class="btn btn-success">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="create-class">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Class</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-class">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="label-normal">Class Name</label>
                                        <input type="text" class="form-control form-control-sm rounded-0"
                                            id="class_name" name="class_name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-flat btn-sm bg-gradient-success">Save and
                                    CLose</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal" id="create-type">
            <div class="modal-dialog modal-xs">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Type</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="form-type">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="label-normal">Account No.</label>
                                            <input type="number" class="form-control form-control-sm rounded-0"
                                                id="account_number" name="account_number" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="label-normal">Account Type Name.</label>
                                            <input type="text" class="form-control form-control-sm rounded-0"
                                                id="account_type_name" name="account_type_name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="label-normal">Account Category</label>
                                            <select class="select2 form-control form-control-sm" name="category_type_id">
                                                <option value="" selected>-Select-</option>
                                                @foreach ($account_category as $category)
                                                    <option value="{{ $category->account_category_id }}">
                                                        {{ $category->account_category }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-flat btn-sm bg-gradient-success">Save and
                                            CLose</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
    <!-- /.content -->


    <script>
        new Vue({
            el: '#app',
            data: {
                account: {
                    account_name: "",
                    account_id: "",
                    account_number: null,
                    account_description: '',
                    parent_account: "",
                    bank_reconcilliation: "no",
                    account_type_id: "",
                    opening_balance: null,
                    starting_date: '',
                    is_sub: false,
                },
                accounts: [],
                account_types: []

            },
            methods: {
                search: function() {},
                openModal: function(transaction) {
                    if (transaction == 'create-account') {
                        $('#create-account').modal('show')
                    } else if (transaction == 'create-type') {
                        $('#create-type').modal('show')
                    } else if (transaction == 'create-class') {
                        $('#create-class').modal('show')
                    }
                },
                createAccount: async function() {
                    axios.post('accounts/create-account', this.account, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector(
                                    'meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                    }).catch(err => {
                        toastr.error(err.response.data.message);
                        console.error(err.response.data.error_msg)
                    }).finally(() => {
                        $('#create-account').modal('hide')
                        this.formReset()
                    })
                },
                formReset: function() {
                    this.account = {
                        account_name: "",
                        account_id: "",
                        account_number: null,
                        account_description: '',
                        parent_account: "",
                        bank_reconcilliation: "no",
                        account_type_id: "",
                        opening_balance: null,
                        starting_date: '',
                        is_sub: false,
                    }
                },
                accountList: async function() {
                    axios.get('/accounts')
                        .then(res => {
                            this.accounts = res.data.data;
                        })
                        .catch(err => {
                            toastr.error("Failed to load accounts.");
                        });
                },
                accountTypeList: async function() {
                    axios.get('/account-type').then(res => {
                        this.account_types = res.data.data
                    }).catch(err => {
                        toastr.error("Failed to load accounts.");
                    })
                }

            },
            mounted() {
                this.accountList()
                this.accountTypeList()
            }
        });
    </script>
@endsection

@section('footer-scripts')
    <script src="{{ asset('js/xlsx.full.min.js') }}"></script>
    @include('scripts.chartofaccounts.chartofaccounts')
@endsection
