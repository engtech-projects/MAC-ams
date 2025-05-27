@extends('layouts.app')

@section('content')

    <style type="text/css">
        a {
            color: black !important;
            font-style: normal !important;
        }

        .textarea {
            border: 1px solid #ccc;
            font-family: inherit;
            font-size: inherit;
            padding: 1px 6px;
            display: block;
            width: 100%;
            overflow: hidden;
            resize: both;
            min-height: 40px;
            line-height: 20px;
            transition: border-color 0.3s ease;
        }

        .textarea:focus {
            outline: 2px solid #80BDFF;
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

        .editable {
            color: black;
        }

        .select2 {
            width: 100% !important
        }

        #to-print {
            display: none;
            padding: 32px;
        }

        @media print {
            .no-print {
                display: none;
            }

            /* Apply custom styles for printed pages */
            /* body {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           font-size: 12pt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           line-height: 1.5;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           margin: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           padding: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          } */

            /* Add page breaks if needed */
            .page-break {
                page-break-before: always;
            }

            #to-print {
                display: block;
            }
        }

        .editable-container.editable-inline,
        .editable-container.editable-inline .control-group.form-group,
        .editable-container.editable-inline .control-group.form-group .editable-input,
        .editable-container.editable-inline .control-group.form-group .editable-input textarea,
        .editable-container.editable-inline .control-group.form-group .editable-input select,
        .editable-container.editable-inline .control-group.form-group .editable-input input:not([type=radio]):not([type=checkbox]):not([type=submit]) {
            width: 100%;
        }
    </style>

    <!-- Main content -->
    <section class="content" id="app">
        <div id="to-print">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda veniam, nihil nesciunt suscipit provident
                adipisci, natus a nostrum odit non eligendi, ullam earum itaque voluptatum minus expedita quam! Qui,
                quaerat.</p>
        </div>
        <div class="container-fluid no-print" style="padding:32px;background-color:#fff;min-height:900px;">
            <div class="row">
                <div class="col-md-12">

                    <form id="journalEntryForm" class="no-print" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 frm-header">
                                <h4><b>Journal Entry</b></h4>
                            </div>
                            <input type="hidden" name="journal_no" id="journal_no">
                            <div class="col-md-4 frm-header">
                                <label class="label-normal" for="date">Journal Date</label>
                                @{{ journal_date }}
                                <div class="input-group">
                                    <input v-model="journal_date" type="text" ref="datepicker"
                                        class="form-control form-control-sm rounded-0" name="journal_date" required>
                                </div>
                            </div>
                            @if (Gate::allows('manager'))
                                <div class="col-md-2 col-xs-12">
                                    <div class="box">
                                        <div class="form-group">
                                            <label class="label-normal" for="branch_id">Branch</label>
                                            <div class="input-group">
                                                <select name="branch_id" class="select2 form-control form-control-sm"
                                                    id="branch_id" required>
                                                    <option value="" disabled selected>-Select Branch-</option>
                                                    <option value="1">Butuan City Branch</option>
                                                    <option value="2">Nasipit Branch</option>
                                                    <option value="3">Gingoog Branch</option>
                                                    <option value="4">Head Office</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif
                            <div class="col-md-{{ Gate::allows('manager') ? '2' : '4' }} col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="">Book Reference</label>
                                        <div class="input-group">
                                            <select name="book_id" class="select2 form-control form-control-sm"
                                                id="book_id" required>
                                                <option value="" disabled selected>-Select Book References-</option>
                                                @foreach ($journalBooks as $journalBook)
                                                    <option value="{{ $journalBook->book_id }}"
                                                        _count="{{ $journalBook->book_code }}-{{ sprintf('%006s', $journalBook->ccount + 1) }}"
                                                        book-src="{{ $journalBook->book_src }}">
                                                        {{ $journalBook->book_code }} - {{ $journalBook->book_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="">Reference No.</label>
                                        <div class="input-group">
                                            <label class="label-normal" id="LrefNo"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="source">Source</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm rounded-0"
                                                name="source" id="source" placeholder="Source" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="cheque_no">Cheque No</label>
                                        <div class="input-group">
                                            <input type="Number" class="form-control form-control-sm rounded-0"
                                                name="cheque_no" id="cheque_no" placeholder="Cheque No">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="cheque_date">Cheque Date</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control form-control-sm rounded-0"
                                                name="cheque_date" id="cheque_date" placeholder="Cheque Date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="status">Status</label>
                                        <div class="input-group">
                                            <select name="status" class="select2 form-control form-control-sm"
                                                id="status" required>
                                                <option value="unposted" selected>Unposted</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="amount">Amount</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm rounded-0"
                                                name="amount_cur" id="amount" step="any" placeholder="Amount"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="payee">Payee</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm rounded-0"
                                                name="payee" id="payee" placeholder="Payee">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="box">
                                    <div class="form-group">
                                        <label class="label-normal" for="remarks">Remarks (<font style="color:red;">
                                                Separate with double colon (::) for the next remarks</font>)</label>
                                        <textarea class="textarea" name="remarks" id="remarks" placeholder="Remarks" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="btn_submit" style="display:none;"> SAVE</button>
                    </form>
                </div>
                <div class="co-md-12" style="height:10px;"></div>
                <div class="col-md-12">
                    <div class="col-md-12 text-right no-print">
                        <button class="btn btn-flat btn-sm bg-gradient-success" id="add_item"><i class="fa fa-plus"></i>
                            Add Details </button>
                    </div>
                    <div class="co-md-12" style="height:10px;"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-sm text-center" id="tbl-create-journal"
                                style="table-layout: fixed;">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 10%;">Account #</th>
                                        <th style="width: 30%;">Account Name</th>
                                        <th style="width: 15%;">Debit</th>
                                        <th style="width: 15%;">Credit</th>
                                        <th style="width: 30%;">S/L</th>
                                        <th style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-create-journal-container">
                                    @for ($i = 0; $i < 1; $i++)
                                        <tr class='editable-table-row'>
                                            <td class="acctnu" value="">
                                                <a href="#"
                                                    class="editable-row-item journal_details_account_no"></a>
                                            </td>
                                            <td class='editable-table-data'>
                                                <select fieldName="account_id"
                                                    class="select-account form-control editable-row-item form-control-sm COASelect">
                                                    <option disabled value="" selected>-Select Account Name-</option>
                                                    @foreach ($chartOfAccount as $account)
                                                        <option value="{{ $account->account_id }}"
                                                            acct-num="{{ $account->account_number }}">
                                                            {{ $account->account_number }}<span> - </span>
                                                            {{ $account->account_name }}</span></option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class='editable-table-data journalNum text-center' id="deb"
                                                value="">
                                                <a href="#" fieldName="journal_details_debit" id="debit"
                                                    class="journalentryItemsEditables editable-row-item records">
                                                </a>
                                            </td>

                                            <td class='editable-table-data journalNum text-center' id="cre"
                                                value="">
                                                <a href="#" fieldName="journal_details_credit" id="credit"
                                                    class="journalentryItemsEditables editable-row-item records">
                                                </a>
                                            </td>
                                            <td class='editable-table-data' value="">
                                                <?php
                                                // echo '<pre>';
                                                // var_export($data['subsidiaries']);
                                                // echo '</pre>';
                                                ?>
                                                <select fieldName="subsidiary_id"
                                                    class="select-subsidiary form-control form-control-sm editable-row-item">
                                                    <option disabled value="" selected>-Select S/L-</option>
                                                    <?php
                                                    $temp = '';
                                                    foreach ($subsidiaries as $subsidiary) {
                                                        if (is_array($subsidiary->toArray()['subsidiary_category']) && $subsidiary->toArray()['subsidiary_category'] > 0) {
                                                            if ($temp == '') {
                                                                $temp = $subsidiary->toArray()['subsidiary_category']['sub_cat_name'];
                                                                echo '<optgroup label="' . $subsidiary->toArray()['subsidiary_category']['sub_cat_name'] . '">';
                                                            } elseif ($temp != $subsidiary->toArray()['subsidiary_category']['sub_cat_name']) {
                                                                echo '<optgroup label="' . $subsidiary->toArray()['subsidiary_category']['sub_cat_name'] . '">';
                                                                $temp = $subsidiary->toArray()['subsidiary_category']['sub_cat_name'];
                                                            }
                                                            echo '<option value="' . $subsidiary->sub_id . '">' . $subsidiary->toArray()['subsidiary_category']['sub_cat_code'] . ' - ' . $subsidiary->sub_name . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-secondary btn-flat btn-sm btn-default remove-journalDetails">
                                                    <span>
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                                <tfoot>
                                    <tr class="text-center">
                                        <th></th>
                                        <th>TOTAL</th>
                                        <th width="150">₱<span id="total_debit">0.00</span></th>
                                        <th width="150">₱<span id="total_credit">0.00</span></th>
                                        <th></th>
                                        <th class="text-right" width="50"></th>
                                    </tr>
                                    <tr class="text-center">
                                        <th></th>
                                        <th>BALANCE</th>
                                        <th>₱<span id="balance_debit">0.00</span></th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-right" width="50"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button class="btn btn-flat btn-sm bg-gradient-info" id="open_voucher">VOUCHER</button>
                    <button class="btn btn-flat btn-sm bg-gradient-success" onclick="$('#btn_submit').click()"> SAVE
                        JOURNAL</button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="JDetailsVoucher" tabindex="2" role="dialog"
            aria-labelledby="JDetailsVoucherLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body" id="printContent">
                        <div class="container-fluid ">
                            <div id="ui-view">
                                <div class="card">
                                    <div class="card-body" id="journal_toPrintVouch">
                                        <link rel="stylesheet"
                                            href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
                                        <link rel="stylesheet"
                                            href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
                                        <link rel="stylesheet" href="{{ asset('css/adminlte/adminlte.min.css') }}">
                                        <div class="col-md-12">
                                            <img src="{{ asset('img/mac_header.fw.png') }}" alt="mac_logo"
                                                class="img img-fluid">
                                        </div>
                                        <div class="col-md-12">
                                            <h3 style="text-align:center">Journal Voucher</h3>
                                        </div>
                                        <div class="row" style="padding-top:10px; border-bottom:10px solid gray;">
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Pay to: &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_pay"></strong></h6>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Branch: &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_branch"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Voucher Date: &nbsp;&nbsp;&nbsp;<strong
                                                            id="journal_voucher_date"></strong></h6>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Reference No: &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_ref_no"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Reference Book: &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_ref_book"></strong></h6>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top:15px; border-bottom:10px solid gray;">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Voucher Source : &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_source"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Particular : &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_particular"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Amount : &nbsp;&nbsp;&nbsp; <strong
                                                            id="journal_voucher_amount"></strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Amount in words : &nbsp;&nbsp;&nbsp; <strong
                                                            class="journal_voucher_amount_in_words"
                                                            style="text-transform:capitalize;"></strong></h6>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive-sm" style="padding-top:5px;">
                                            <table class="table table-striped"
                                                style="margin-bottom:0; border-top:4px dashed black;">
                                                <thead>
                                                    <tr>
                                                        <th class="center">Account</th>
                                                        <th>Title</th>
                                                        <th>S/L</th>
                                                        <th class="center">Debit</th>
                                                        <th class="right">Credit</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="journal_VoucherContent">

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row" style="border-top: 10px solid gray;">
                                            <div class="col-md-4" style="margin-top: 20px;">
                                                <h6 style="margin-bottom: 40px;">Prepared By:</h6>
                                                <p>______________________________________________________</p>
                                            </div>
                                            <div class="col-md-4" style="margin-top: 20px;">
                                                <h6 style="margin-bottom: 40px;">Certified Correct By:</h6>
                                                <p>______________________________________________________</p>
                                            </div>
                                            <div class="col-md-4" style="margin-top: 20px;">
                                                <h6 style="margin-bottom: 40px;">Approved By:</h6>
                                                <p>______________________________________________________</p>
                                            </div>
                                        </div>
                                        <div class="received-payment">
                                            <div class="row">
                                                <br><br>
                                                <div class="col-md-12">
                                                    <h6
                                                        style="text-align: justify;text-justify:inter-word;text-transform:uppercase">
                                                        Received payment from MICRO ACCESS LOANS CORPORATION CORPORATION the
                                                        of
                                                        sum
                                                        <span
                                                            class="journal_voucher_amount_in_words">&nbsp;&nbsp;&nbsp;</span>
                                                    </h6>
                                                </div>
                                                <div class="col-md-12">
                                                    <h6>Cheque Number: &nbsp;&nbsp;&nbsp; <span
                                                            class="cheque-number"></span>
                                                    </h6>

                                                </div>
                                                <div class="col-md-12">
                                                    <h6>Cheque Date: <span class="cheque-date"></span></h6>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Received By:________________________________________</h6>

                                                </div>

                                                <div class="col-md-6">
                                                    <h6>Date:_______________________</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-5">

                                            </div>
                                            <div class="col-lg-4 col-sm-5 ml-auto">

                                                <!-- <table class="table table-clear" style="padding-right:232px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <td class="left">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <strong>TOTAL</strong>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <td class="left">₱ <strong id="journal_total_debit_voucher"></strong></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <td class="left">₱ <strong id="journal_total_credit_voucher"></strong></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 </table> -->
                                                <div>
                                                    <button @click="print" class="btn btn-success float-right no-print"
                                                        data-dismiss="modal" style="padding:5px 32px">Print</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                baseUrl: window.location.protocol + "//" + window.location.host,
                posting_period: {},
                journal_date: ""
            },
            methods: {
                search: function() {
                    window.location.href = this.baseUrl + "/reports/trialBalance?asof=" + this.filter.asof;
                },
                getOpenPostingPeriod: function() {
                    axios.get('/MAC-ams/open-posting-period', {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                    }).then(response => {
                        this.posting_period = response.data.data

                    }).catch(err => {
                        console.error(err)
                    })
                },
                print: function() {
                    var content = document.getElementById('printContent').innerHTML;
                    var toPrint = document.getElementById('to-print');
                    toPrint.innerHTML = content;
                    setTimeout(() => {
                        window.print();
                    }, 500);
                },
            },
            async mounted() {
                var journal_date = null;
                try {
                    const response = await axios.get('/MAC-ams/open-posting-period');
                    this.posting_period = response.data.data;
                } catch (error) {
                    console.err('Error:', error);
                }
                var dates = this.posting_period;

                var date_range = dates.map((period) => {
                    return {
                        from: period.start_date,
                        to: period.end_date
                    }
                })
                const firstDefault = dates.length > 0 ? dates[0].start_date : null;

                console.log(firstDefault);

                flatpickr(this.$refs.datepicker, {
                    defaultDate: firstDefault,
                    enable: date_range,
                    dateFormat: 'Y-m-d'
                })
            }
            /* mounted() {
                var data = {}
                this.getOpenPostingPeriod();
                axios.get('/MAC-ams/open-posting-period', {
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                            .content
                    },
                }).then(response => {
                    this.posting_period = response.data.data

                }).catch(err => {
                    console.error(err)
                })
                console.log(data);

                flatpickr(this.$refs.datepicker, {
                    enable: [{
                            from: "2025-01-01",
                            to: "2025-01-31"
                        },
                        {
                            from: "2025-03-01",
                            to: "2025-03-30"
                        }
                    ],
                    dateFormat: 'Y-m-d'
                })

                console.log(this.baseUrl);
            } */
        });
    </script>
@endsection
@section('footer-scripts')
    @include('scripts.journal.journal')
@endsection
