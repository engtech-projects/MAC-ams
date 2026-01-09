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
        <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
            <div v-if="isLoading" class="loading-overlay">
                <p>Loading... </p>
                <div class="spinner"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" class="form-control form-control-sm rounded-0" name="bookId" id="bookId"
                        placeholder="">
                    <div class="row">
                        <div class="col-md-8 frm-header">
                            <h4><b>Trial Balance</b></h4>
                        </div>

                        <div class="col-md-12" style="height:20px;"></div>
                        <div class="col-md-2 col-xs-12">
                            <div class="box">
                                <div style="display:flex;align-items:center">
                                    <div class="form-group" style="flex:1">
                                        <label class="label-normal" for="book_ref">As of</label>
                                        <div class="input-group">
                                            <input v-model="filter.asof" value="{{ $transactionDate }}" type="date"
                                                class="form-control form-control-sm rounded-0" name="date" id="book_ref"
                                                placeholder="Book Reference" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            <div class="box">
                                <div class="form-group">
                                    <!-- <label class="label-normal" for="book_ref">To</label> -->
                                    <div class="input-group" style="padding-top:30px">
                                        <button @click="search()" style="max-width:150px"
                                            class="form-control form-control-sm rounded-0 btn btn-success btn-sm">
                                            Generate</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" style="height:20px;"></div>
                </div>
                <div class="co-md-12" style="height:10px;"></div>
                <div class="col-md-12">
                    <!-- Table -->
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <table class="table table-bordered">
                                    <template v-for="(category, categoryIndex) in trialBalance.accounts">
                                        <!-- Account Rows -->
                                        <template v-for="(type, typeIndex) in category.types">

                                            <tr v-for="(account, accountIndex) in type.accounts">
                                                <td>@{{ account.account_number }}</td>
                                                <td>@{{ account.account_name }}</td>
                                                <!-- Debit -->
                                                <td v-if="['assets', 'expense'].includes(categoryIndex)">
                                                    @{{ formatNumber(account.total) }}
                                                </td>
                                                <td v-else></td>
                                                <!-- Credit -->
                                                <td v-if="['liabilities', 'equity', 'revenue'].includes(categoryIndex)">
                                                    @{{ formatNumber(account.total) }}
                                                </td>
                                                <td v-else></td>

                                            </tr>
                                        </template>
                                    </template>
                                    <tr class="font-weight-bold table-success">
                                        <td colspan="2" class="text-right">GRAND TOTAL</td>
                                        <td>@{{ formatNumber(grandTotalDebit) }}</td>
                                        <td>@{{ formatNumber(grandTotalCredit) }}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </section>
                    <!-- /.Table -->
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
                isLoading: false,
                filter: {
                    asof: @json($transactionDate),
                },
                trialBalance: @json($trialBalance),

            },
            computed: {
                grandTotalDebit() {
                    let total = 0;
                    const accounts = this.trialBalance && this.trialBalance.accounts ? this.trialBalance.accounts :
                    {};

                    Object.keys(accounts).forEach(categoryKey => {
                        if (['assets', 'expense'].includes(categoryKey)) {
                            const category = accounts[categoryKey];
                            const types = Array.isArray(category.types) ? category.types : Object.values(
                                category.types || {});
                            types.forEach(type => {
                                const accs = Array.isArray(type.accounts) ? type.accounts : Object
                                    .values(type.accounts || {});
                                accs.forEach(acc => {
                                    total += Number(acc.total) || 0;
                                });
                            });
                        }
                    });

                    return total;
                },

                grandTotalCredit() {
                    let total = 0;
                    const accounts = this.trialBalance && this.trialBalance.accounts ? this.trialBalance.accounts :
                    {};

                    Object.keys(accounts).forEach(categoryKey => {
                        if (['liabilities', 'equity', 'revenue'].includes(categoryKey)) {
                            const category = accounts[categoryKey];
                            const types = Array.isArray(category.types) ? category.types : Object.values(
                                category.types || {});
                            types.forEach(type => {
                                const accs = Array.isArray(type.accounts) ? type.accounts : Object
                                    .values(type.accounts || {});
                                accs.forEach(acc => {
                                    total += Number(acc.total) || 0;
                                });
                            });
                        }
                    });

                    return total;
                }
            },
            methods: {
                formatNumber(value) {
                    const number = Number(value) || 0;
                    return number.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },
                search: async function() {
                    this.isLoading = true;
                    await axios.post('trial-balance/search', this.filter, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector(
                                    'meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                        this.trialBalance = response.data.data.trialBalance;
                    }).catch(err => {
                        console.error(err)
                    }).finally(() => {
                        this.isLoading = false;
                    });
                },
            },
        });
    </script>
@endsection



@section('footer-scripts')
    @include('scripts.reports.reports')
@endsection
