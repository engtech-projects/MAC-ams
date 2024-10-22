@extends('layouts.app')

@section('content')
    <style type="text/css">
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

        .buttons-print,
        .buttons-html5 {
            display: none;
        }
    </style>

    <!-- Main content -->
    <section class="content" id="app">
        <?php $url = env('APP_URL'); ?>
        <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
            <div class="row">
                <div class="col-md-12">
                    <form id="" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 frm-header">
                                <h4><b>Monthly Depreciation / Monthly Amortization</b></h4>
                            </div>
                            <div class="row col-md-12">

                                <div class="col-md-9 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="sub_cat_id">Subsidiary Category</label>
                                            <div class="input-group">

                                                <div class='col-md-3'>
                                                    <div class="box">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <select name="sub_cat_id"
                                                                    class="form-control form-control-sm" id="sub_cat_id">
                                                                    <option value="" disabled selected>-Select
                                                                        Category-</option>
                                                                    @foreach ($subsidiary_categories as $sub_category)
                                                                        <option value="{{ $sub_category->sub_cat_id }}">
                                                                            {{ $sub_category->description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class='col-md-3'>
                                                    <div class="box">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <select name="branch_id"
                                                                    class="form-control form-control-sm" id="branch">
                                                                    <option value="" disabled selected>-Select Branch-
                                                                    </option>
                                                                    @foreach ($branches as $branch)
                                                                        <option value="{{ $branch->branch_id }}">
                                                                            {{ $branch->branch_code }} -
                                                                            {{ $branch->branch_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class='col-md-3'>
                                                    <div class="box">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="date" id="sub_month" v-model="sub_month"
                                                                    class="form-control form-control-sm rounded-0"
                                                                    name="sub_date" id="sub_date" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class='btn btn-success'>Search</button>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>

                    </form>
                </div>
                <div class="col-md-12">

                    <!-- Table -->
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th>No.</th>
                                            <th>Particular</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Monthly</th>
                                            <th>Amort.</th>
                                            <th>Used</th>
                                            <th>Expensed</th>
                                            <th>Unexpensed</th>
                                            <th>Due Amort</th>
                                            <th>Salvage</th>
                                            <th>Rem.</th>
                                            <th>Inv.</th>
                                            <th>No.</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $total = [
                                                'grand' => [
                                                    'total_amount' => 0,
                                                    'total_monthly_amort' => 0,
                                                    'total_monthly' => 0,
                                                    'total_no_depre' => 0,
                                                    'total_no_amort' => 0,
                                                    'total_amort' => 0,
                                                    'total_used' => 0,
                                                    'total_expensed' => 0,
                                                    'total_unexpensed' => 0,
                                                    'total_due_amort' => 0,
                                                    'total_sub_salvage' => 0,
                                                    'total_rem' => 0,
                                                    'total_inv' => 0,
                                                ],
                                                'acct' => [
                                                    'total_amount' => 0,
                                                    'total_monthly_amort' => 0,
                                                    'total_monthly' => 0,
                                                    'total_no_depre' => 0,
                                                    'total_no_amort' => 0,
                                                    'total_amort' => 0,
                                                    'total_used' => 0,
                                                    'total_expensed' => 0,
                                                    'total_unexpensed' => 0,
                                                    'total_due_amort' => 0,
                                                    'total_sub_salvage' => 0,
                                                    'total_rem' => 0,
                                                    'total_inv' => 0,
                                                ],
                                            ];
                                            ?>

                                            @foreach ($data as $keyCategory => $row)
                                                <tr>
                                                    <td colspan="4">
                                                        <h5>{{ $keyCategory }}</h5>
                                                    </td>
                                                </tr>
                                                <?php $grandtotal = 0; ?>
                                                @if (count($row) > 0)
                                 
                                                    @foreach ($row as $keyBranch => $dd)
                                                        <tr>
                                                            <td colspan="4">
                                                                <h5>{{ $keyBranch }}</h5>
                                                            </td>
                                                        </tr>

                                                        <?php
                                                        $category_id = null;
                                                        $branch_id = null;
                                                        $branch_code = null;
                                                        $branchTotal = [
                                                            'total_amount' => 0,
                                                            'total_monthly_amort' => 0,
                                                            'total_monthly' => 0,
                                                            'total_no_depre' => 0,
                                                            'total_no_amort' => 0,
                                                            'total_amort' => 0,
                                                            'total_used' => 0,
                                                            'total_expensed' => 0,
                                                            'total_unexpensed' => 0,
                                                            'total_due_amort' => 0,
                                                            'total_sub_salvage' => 0,
                                                            'total_rem' => 0,
                                                            'total_inv' => 0,
                                                        ];
                                                        ?>
                                                        <?php $subIds = []; ?>
                                                        @foreach ($dd as $i => $val)
                                                            @if ($keyBranch === $val['branch'] && $keyCategory === $val['description'])
                                                                <?php $category_id = $val['sub_cat_id'];
                                                                $branch_id = $val['branch_id']; ?>
                                                                <?php $branch_code = $val['branch_code']; ?>
                                                                <?php $subId = $val['sub_id']; $subIds[] = $subId; ?>
                                                                <tr>
                                                                    <td>{{ $i += 1 }}</td>
                                                                    <td>{{ $val->sub_code . '-' . $val->sub_name }}</td>
                                                                    <td>{{ $val->sub_date }}</td>
                                                                    <td>{{ number_format($val->sub_amount, 2, '.', ',') }}
                                                                    </td>
                                                                    <td>{{ number_format($val->monthly_amort, 2, '.', ',') }}
                                                                    </td>
                                                                    <td>{{ number_format($val->sub_no_depre, 2, '.', ',') }}
                                                                    </td>

                                                                    <td>{{ number_format($val->sub_no_amort, 2, '.', ',') }}
                                                                    </td>

                                                                    <td>{{ number_format($val->expensed, 2, '.', ',') }}
                                                                    </td>
                                                                    <td>{{ number_format($val->unexpensed, 2, '.', ',') }}
                                                                    </td>
                                                                    <td>{{ number_format($val->due_amort, 2, '.', ',') }}
                                                                    </td>
                                                                    <td>{{ number_format($val->sub_salvage, 2, '.', ',') }}
                                                                    </td>
                                                                    <td>{{ number_format($val->rem, 2, '.', ',') }}</td>
                                                                    <td>{{ number_format($val->inv, 2, '.', ',') }}</td>
                                                                    <td>{{ number_format($val->no, 2, '.', ',') }}</td>
                                                                    <td>
                                                                        <button class="btn btn-danger btn-xs"
                                                                            @click='deleteSub(@json($subId))'>
                                                                            <i class="fa fa-trash fa-xs"></i>
                                                                        </button>
                                                                    </td>

                                                                </tr>
                                                            @endif
                                                            <?php
                                                            $branchTotal['total_amount'] += $val->sub_amount;
                                                            $branchTotal['total_monthly_amort'] += $val->monthly_amort;
                                                            $branchTotal['total_monthly'] += $val->sub_no_depre;
                                                            $branchTotal['total_no_amort'] += $val->sub_no_amort;
                                                            $branchTotal['total_expensed'] += $val->expensed;
                                                            $branchTotal['total_unexpensed'] += $val->unexpensed;
                                                            $branchTotal['total_due_amort'] += $val->due_amort;
                                                            $branchTotal['total_sub_salvage'] += $val->sub_salvage;
                                                            $branchTotal['total_rem'] += $val->rem;

                                                            ?>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan=3>BRANCH TOTAL</td>
                                                            <td>{{ number_format($branchTotal['total_amount'], 2, '.') }}
                                                            </td>
                                                            <td>{{ number_format($branchTotal['total_monthly_amort'], 2, '.') }}
                                                            </td>
                                                            <td>{{ number_format($branchTotal['total_monthly'], 2, '.') }}
                                                            </td>
                                                            <td>{{ number_format($branchTotal['total_no_amort'], 2, '.') }}
                                                            </td>
                                                            <td>{{ number_format($branchTotal['total_expensed'], 2, '.') }}
                                                            </td>
                                                            <td>{{ number_format($branchTotal['total_unexpensed'], 2, '.') }}
                                                            </td>
                                                            <td>{{ number_format($branchTotal['total_due_amort'], 2, '.') }}
                                                            </td>
                                                            <td>{{ number_format($branchTotal['total_sub_salvage'], 2, '.') }}
                                                            </td>
                                                            <td>{{ number_format($branchTotal['total_rem'], 2, '.') }}</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <?php $data = [
                                                            'sub_ids' => $subIds,
                                                            'total' => $branchTotal,
                                                            'category_id' => $category_id,
                                                            'branch_id' => $branch_id,
                                                            'branch_code' => $branch_code,
                                                            'as_of' => $as_of,
                                                        ]; ?>

                                                        <tr>
                                                            <td colspan="2"><button class='btn btn-primary'
                                                                    @click='post(@json($data))'>Post</button>
                                                                <button type="button" class="btn btn-success"
                                                                    @click='add(@json($val))'
                                                                    data-toggle="modal" data-target="#createSubsidiaryModal"
                                                                    data-whatever="@mdo">Add</button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $total['grand']['total_amount'] += $branchTotal['total_amount'];
                                                        $total['grand']['total_amort'] += $branchTotal['total_monthly_amort'];
                                                        $total['grand']['total_monthly'] += $branchTotal['total_monthly'];
                                                        $total['grand']['total_expensed'] += $branchTotal['total_expensed'];
                                                        $total['grand']['total_unexpensed'] += $branchTotal['total_unexpensed'];
                                                        $total['grand']['total_monthly_amort'] += $branchTotal['total_monthly_amort'];
                                                        $total['grand']['total_used'] += $branchTotal['total_no_amort'];
                                                        $total['grand']['total_due_amort'] += $branchTotal['total_due_amort'];
                                                        $total['grand']['total_sub_salvage'] += $branchTotal['total_sub_salvage'];
                                                        $total['grand']['total_rem'] += $branchTotal['total_rem'];
                                                        $total['acct']['total_amount'] += $branchTotal['total_amount'];
                                                        $total['acct']['total_amort'] += $branchTotal['total_monthly_amort'];
                                                        $total['acct']['total_monthly'] += $branchTotal['total_monthly'];
                                                        $total['acct']['total_expensed'] += $branchTotal['total_expensed'];
                                                        $total['acct']['total_unexpensed'] += $branchTotal['total_unexpensed'];
                                                        $total['acct']['total_monthly_amort'] += $branchTotal['total_monthly_amort'];
                                                        $total['acct']['total_used'] += $branchTotal['total_no_amort'];
                                                        $total['acct']['total_due_amort'] += $branchTotal['total_due_amort'];
                                                        $total['acct']['total_sub_salvage'] += $branchTotal['total_sub_salvage'];
                                                        $total['acct']['total_rem'] += $branchTotal['total_rem'];

                                                        ?>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            @if (count($data) >= 3)
                                                <tr>
                                                    <td colspan=3>ACC. TOTAL</td>
                                                    <td>{{ number_format($total['acct']['total_amount'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['acct']['total_amort'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['acct']['total_monthly'], 2, '.') }}</td>
                                                    <td>{{ number_format($total['acct']['total_used'], 2, '.') }}</td>
                                                    <td>{{ number_format($total['acct']['total_expensed'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['acct']['total_unexpensed'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['acct']['total_due_amort'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['acct']['total_sub_salvage'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['acct']['total_rem'], 2, '.') }}</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td colspan=3>GRAND TOTAL</td>
                                                    <td>{{ number_format($total['grand']['total_amount'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['grand']['total_amort'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['grand']['total_monthly'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['grand']['total_used'], 2, '.') }}</td>
                                                    <td>{{ number_format($total['grand']['total_expensed'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['grand']['total_unexpensed'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['grand']['total_due_amort'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['grand']['total_sub_salvage'], 2, '.') }}
                                                    </td>
                                                    <td>{{ number_format($total['grand']['total_rem'], 2, '.') }}</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                </tr>
                                            @endif


                                        </tbody>
                                    </table>

                                </div>

                            </div>
                    </section>
                    <!-- /.Table -->
                </div>
            </div>
        </div>
        <div class="modal fade" v-show="showModal" id="createSubsidiaryModal" tabindex="-1" role="dialog"
            aria-labelledby="createSubsidiaryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Subsidiary</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Particular Name: </label>
                                        <input type="text" v-model="subsidiary.sub_name" class="form-control"
                                            id="sub_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Inventory Number: </label>
                                        <input type="text" v-model="subsidiary.sub_code" class="form-control"
                                            id="sub_code" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">

                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Date Obtained: </label>
                                        <input type="date" v-model="subsidiary.sub_date" class="form-control"
                                            id="sub_code" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Number of Terms: </label>
                                        <input type="text" v-model="subsidiary.sub_no_depre" class="form-control"
                                            id="sub_address" required>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Amount:</label>
                                        <input type="text" v-model="subsidiary.sub_amount" class="form-control"
                                            id="sub_tel" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Monthly Amortization</label>
                                        <input type="text" disabled v-model="monthlyAmort" class="form-control"
                                            id="sub_acct_no" required>
                                    </div>

                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Rate Percentage(%):</label>
                                        <input type="number" v-model="rate_percentage" class="form-control"
                                            id="sub_salvage" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="message-text" class="col-form-label">Salvage:</label>
                                        <input type="text" disabled v-model="subSalvage" class="form-control"
                                            id="sub_no_depre" required>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button @click="createSubsidiary()" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>
    <!-- /.content -->
    <script>
        new Vue({
            el: '#app',
            data: {
                showModal: true,
                reportType: '',
                sub_month: '',
                monthlyAmortization: 0,
                rate_percentage: 0,
                filter: {
                    subsidiary_id: '',
                    from: '',
                    to: '',
                    account_id: 'all',
                    type: ''
                },
                subsidiary: {
                    sub_name: '',
                    sub_code: null,
                    sub_no_amort:0,
                    sub_amount: 0,
                    sub_no_depre: 0,
                    sub_cat_id: null,
                    sub_per_branch: null,
                    sub_salvage: 0,
                },
                incomeExpense: {
                    income: [],
                    expense: []
                },
                subsidiaryAll: [],
                balance: 0,
                url: "{{ route('reports.post-monthly-depreciation') }}",
            },
            computed: {
                monthlyAmort: function() {
                    this.monthlyAmortization = this.subsidiary.sub_amount / this.subsidiary.sub_no_depre;
                    return isNaN(this.monthlyAmortization) ? 0 : this.monthlyAmortization.toFixed(2);
                },
                subSalvage: function() {
                    this.subsidiary.sub_salvage = (this.rate_percentage * this.subsidiary.sub_amount) / 100
                    return isNaN(this.subsidiary.sub_salvage) ? 0 : this.subsidiary.sub_salvage;
                }
            },
            methods: {

                getDate: function() {
                    const d = new Date();
                    const month = d.getMonth() + 1;
                    const year = d.getFullYear();

                    const current_month = month + "-" + year
                    this.sub_month = current_month;
                    var gfg =
                        document.getElementById(
                            "sub_month").defaultValue;
                    return current_month;
                },
                post: function(data) {
                    console.log(data);
                    axios.post(this.url, data, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);

                    }).catch(err => {
                        console.error(err)
                    })
                },
                add: function(data) {
                    this.subsidiary.sub_cat_id = data.subsidiary_category.sub_cat_id;
                    this.subsidiary.sub_per_branch = data.sub_per_branch
                },
                createSubsidiary: function() {
                    var today = DateTime.Now.ToString("yyyy-MM-dd");
                   // this.subsidiary.sub_no_amort = this.subsidiary.sub_no_depre
                   this.subsidiary.sub_no_amort = 0;
                //    this.subsidiary.sub_date = today;
                    axios.post(@json(env('APP_URL')) + '/subsidiary', this.subsidiary, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                    }).catch(err => {
                        var errors = err.response.data.errors;

                        var messages = [];
                        for( var i in errors) {
                            var error = errors[i];
                            for( var j in error) {
                                var message = error[j];
                                messages.push(message+'<br />');
                            }
                        }
                        toastr.error(messages);
                    })
                },
                deleteSub: function(data) {
                    var url = @json(env('APP_URL'));
                    console.log(url);
                    axios.delete(@json(env('APP_URL')) + '/subsidiary/' + data, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                    }).catch(err => {
                        toastr.success(err);
                    })
                },

                fetchSubAll: function() {
                    this.filter.type = this.reportType;
                    axios.post(this.url, this.filter, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => {
                            console.log(response.data.data[0]);
                            this.subsidiaryAll = response.data.data[0];
                            this.balance = response.data.data[1];
                            // console.log(response.data.data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                },

            },
        });
    </script>
@endsection


@section('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
    @include('scripts.reports.reports')
@endsection
