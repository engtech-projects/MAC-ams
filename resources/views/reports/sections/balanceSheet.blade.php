@extends('layouts.app')

@section('content')
    <style type="text/css">
        .title-header {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4ec891;
        }

        .indent-1 {
            padding-left: 20px !important;
        }

        .indent-1-r {
            padding-right: 20px !important;
        }

        .indent-2 {
            padding-left: 40px !important;
        }

        .border-0,
        .border-0 td {
            border: 0;
        }
    </style>

    <!-- Main content -->
    <section class="content" id="app">
        <div v-if="isLoading" class="loading-overlay">
            <p>Loading... </p>
            <div class="spinner"></div>
        </div>
        <div class="container-fluid" style="padding:32px;background-color:#fff;min-height:900px;">
            <div class="row">
                <div class="col-md-12 title-header">
                    <h4><b>Balance Sheet</b></h4>
                </div>

                <div class="col-12">
                    <div class="col-md-2 col-xs-12">
                        <div class="box">
                            <div class="form-group">
                                <label class="label-normal" for="">AS OF</label>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input class="form-control form-control-sm rounded-0" type="date"
                                                v-model="date" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <button @click="generate()" class="btn-sm btn-success">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-start">
                <div class="col-md-8">
                    <table class="table table-sm border">
                        <template v-for="(type, category) in balance_sheet?.accounts">
                            <thead>
                                <tr>
                                    <th class="indent-1" width="50%">@{{ category.toUpperCase() }}</th>
                                    <th width="25%"></th>
                                    <th width="25%"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <template v-for="(data, group) in type.types">
                                    <tr class="border-0">
                                        <td class="indent-1">@{{ toTitleCase(data.name) }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr v-for="(account, key) in data.accounts" :key="key" class="border-0">
                                        <td class="indent-2">@{{ toTitleCase(account.account_name) }}</td>
                                        <td class="text-right">@{{ formatNumber(account.total) }}</td>
                                        <td></td>
                                    </tr>
                                    <tr class="border-0">
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                    <tr style="border-style: double;">
                                        <td class="indent-1">Total @{{ toTitleCase(data.name) }}</td>
                                        <td></td>
                                        <td class="text-bold text-right indent-1-r">
                                            @{{ formatNumber(data.total) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                </template>
                                <tr style="border-style: double;">
                                    <td class="indent-1 text-bold">Total @{{ toTitleCase(category) }}</td>
                                    <td></td>
                                    <td class="text-bold text-right indent-1-r">
                                        @{{ formatNumber(type.total) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                            </tbody>
                        </template>
                        <thead>
                            <tr v-if="balance_sheet?.total_asset">
                                <th class="indent-1" width="50%">@{{ balance_sheet.total_asset.title }}</th>
                                <th width="25%"></th>
                                <th width="25%" class="text-right indent-1-r">
                                    @{{ formatNumber(balance_sheet.total_asset.value) }}
                                </th>
                            </tr>
                            <tr v-if="balance_sheet?.total_liabilities">
                                <th class="indent-1" width="50%">@{{ balance_sheet.total_liabilities.title }}</th>
                                <th width="25%"></th>
                                <th width="25%" class="text-right indent-1-r">
                                    @{{ formatNumber(balance_sheet.total_liabilities.value) }}
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script>
        new Vue({
            el: '#app',
            data: {
                date: '',
                isLoading: false,
                balance_sheet: null,

            },
            computed: {},
            methods: {
                toTitleCase(str) {
                    if (!str) return "";
                    return str.replace(/\w\S*/g, w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase());
                },
                formatNumber(value) {
                    const number = Number(value) || 0;
                    return number.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },
                generate: function() {
                    this.isLoading = true;
                    axios.post('balance-sheet/generate', {
                        date: this.date
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector(
                                    'meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                        this.balance_sheet = response.data.data.balanceSheet;
                    }).catch(err => {
                        console.error(err)
                    }).finally(() => {
                        this.isLoading = false;
                    });
                }

            },
            created() {
                this.generate()
            },
        });
    </script>
@endsection


@section('footer-scripts')
    @include('scripts.reports.reports')
@endsection
