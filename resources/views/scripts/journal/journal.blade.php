<script type="text/javascript">
    (function($) {
        'use strict'

        $('.select-branch2').select2({
            placeholder: 'Select-Branch',
            allowClear: true,
        });

        $("#amount").on("focus", function() {
            if ((parseFloat(this.value) - parseInt(this.value)) == 0) {
                this.value = amountConverter(this.value)
            }
        });
        $("#amount").on("blur", function() {
            if (this.value) {
                this.value = amountConverter(this.value)
            } else {
                this.value = amountConverter(this.value)
            }
        });

        $("#debit").on("focus", function() {
            if ((parseFloat(this.value) - parseInt(this.value)) == 0) {
                this.value = parseFloat(this.value).toFixed(0)
            }
        });
        $("#debit").on("blur", function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2)
            } else {
                this.value = parseFloat(0).toFixed(2)
            }
        });


        $('.journal-amount').each(function(index, value) {
            var ja = $(this).text()
            var val = amountConverter(ja)

            $(this).text(val)
        })



        $('tbody .tbl-row').click(function() {
            console.log("Clicked");

            var id = $(this).data("id")

            var $sidebar = $('.control-sidebar')
            var $container = $('<div />', {
                class: 'p-3 control-sidebar-content'
            })

            $sidebar.append($container)

            $container.append(
                '<h6><i class="fa fa-users"></i> Account Details</h6><hr class="mb-2"/>'
            )
            $container.append(
                '<h6><i class="fa fa-users"></i>' + id + '</h6><hr class="mb-2"/>'
            )

            $("#account-details").slideDown("slow");

            var id = $(this).data("id")
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {
                    journal_id: id
                },
                url: "{{ route('journal.JournalEntryFetch') }}",
                dataType: "json",
                success: function(response) {
                    if (response.message == 'fetch') {
                        var total_debit = 0;
                        var total_credit = 0;
                        $('#tbl-preview-container').html('');
                        $('#journalVoucherContent').html('');
                        $('#vjournal_remarks').html('');
                        $.each(response.data, function(k, v) {
                            $('#posted-content').html('');
                            var content = '';
                            $.each(v.remarks.split('::'), function(k, vv) {
                                $('#vjournal_remarks').append(
                                    `<li>${vv}</li>`
                                );
                            });
                            if (v.status == 'unposted') {
                                content =
                                    `<button value="${v.journal_id}"  class="btn btn-flat btn-sm bg-gradient-success stStatus">Posted</button>`;

                            } else {
                                content =
                                    `<button disabled  class="btn btn-flat btn-sm  bg-gradient-gray">Posted</button>
										<button  class="btn btn-flat btn-sm bg-gradient-info stsVoucher">View Journal Voucher</button>
										<button  class="btn btn-flat btn-sm bg-gradient-success" id="printVoucher"><i class="fa fa-print"></i> Print</button>`
                            }
                            $('#posted-content').html(content);
                            $.each(v.journal_details, function(kk, vv) {
                                total_debit += parseFloat(vv
                                    .journal_details_debit);
                                total_credit += parseFloat(vv
                                    .journal_details_credit);
                                $('#tbl-preview-container').append(`
								<tr class='editable-table-row'>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.chart_of_account.account_number}</label></td>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.chart_of_account.account_name}</label> </td>


									<td class='editable-table-data' value="" >
										<label class="label-normal" >${vv.subsidiary.sub_name}</label>
									</td>
                                    <td class='editable-table-data' value="" >	<label class="label-normal" >${vv.journal_details_debit}</label> </td>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.journal_details_credit}</label> </td>
								</tr>
							`);
                                $('#journalVoucherContent').append(`
								<tr>
									<td class="center">${vv.chart_of_account.account_number}</td>
									<td class="left">${vv.chart_of_account.account_name}</td>
									<td class="left">${vv.subsidiary.sub_name}</td>
									<td class="center">${vv.journal_details_debit}</td>
									<td class="right">${vv.journal_details_credit}</td>
								</tr>`);
                            })
                            $('#vtotal_debit, #total_debit_voucher').text(total_debit
                                .toLocaleString("en-US"))
                            $('#vtotal_credit, #total_credit_voucher').text(total_credit
                                .toLocaleString("en-US"))
                            $('#vbalance_debit').text(amountConverter((parseFloat(
                                total_debit) - parseFloat(total_credit))))
                        });
                    }

                },
                error: function() {
                    console.log("Error");
                }
            });

        })


        //Convert Amount Currency
        function amountConverter(amount) {
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',

            });

            return formatter.format(amount)
        }

        function reverseAmountConverter(val) {
            const covertedNumber = Number(val.replace(/[^0-9.-]+/g, ""));
            return covertedNumber
        }


        $('tbodys .tbl-rows').click(function() {
            var id = $(this).data("id")
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {
                    journal_id: id
                },
                url: "{{ route('journal.JournalEntryFetch') }}",
                dataType: "json",
                success: function(response) {
                    if (response.message == 'fetch') {
                        var total_debit = 0;
                        var total_credit = 0;
                        $('#tbl-preview-container').html('');
                        $('#journalVoucherContent').html('');
                        $('#vjournal_remarks').html('');
                        $.each(response.data, function(k, v) {
                            $('#posted-content').html('');
                            var content = '';
                            $.each(v.remarks.split('::'), function(k, vv) {
                                $('#vjournal_remarks').append(
                                    `<li>${vv}</li>`
                                );
                            });
                            if (v.status == 'unposted') {
                                content =
                                    `<button value="${v.journal_id}"  class="btn btn-flat btn-sm bg-gradient-success stStatus">Posted</button>`;

                            } else {
                                content =
                                    `<button disabled  class="btn btn-flat btn-sm  bg-gradient-gray">Posted</button>
										<button  class="btn btn-flat btn-sm bg-gradient-info stsVoucher">View Journal Voucher</button>
										<button  class="btn btn-flat btn-sm bg-gradient-success" id="printVoucher"><i class="fa fa-print"></i> Print</button>`
                            }
                            $('#posted-content').html(content);
                            $.each(v.journal_entry_details, function(kk, vv) {
                                total_debit += parseFloat(vv
                                    .journal_details_debit);
                                total_credit += parseFloat(vv
                                    .journal_details_credit);
                                $('#tbl-preview-container').append(`
								<tr class='editable-table-row'>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.account.account_number}</label></td>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.account.account_name}</label> </td>
                                    <td class='editable-table-data' value="" >	<label class="label-normal" >${vv.journal_details_debit}</label> </td>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.journal_details_credit}</label> </td>

									<td class='editable-table-data' value="" >
										<label class="label-normal" >${vv.subsidiary.sub_name}</label>
									</td>
                                    <td class='editable-table-data' value="" >	<label class="label-normal" >${vv.journal_details_debit}</label> </td>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.journal_details_credit}</label> </td>
								</tr>
							`);
                                $('#journalVoucherContent').append(`
								<tr>
									<td class="center">${vv.account.account_number}</td>
									<td class="left">${vv.account.account_name}</td>
									<td class="left">${vv.subsidiary.sub_name}</td>
									<td class="center">${vv.journal_details_debit}</td>
									<td class="right">${vv.journal_details_credit}</td>
								</tr>`);
                            })
                            $('#vtotal_debit, #total_debit_voucher').text(total_debit
                                .toLocaleString("en-US"))
                            $('#vtotal_credit, #total_credit_voucher').text(total_credit
                                .toLocaleString("en-US"))
                            $('#vbalance_debit').text((parseFloat(total_debit) -
                                parseFloat(total_credit)).toLocaleString(
                                "en-US"))
                        });
                    }

                },
                error: function() {
                    console.log("Error");
                }
            });
        })



        $(document).on('change', '#s_from', function(e) {
            $('#s_to').val($('#s_from').val());
            $('#s_to').removeAttr("disabled");
            $('#s_to').attr('min', $('#s_from').val());
        });


        $('[data-toggle="tooltip"]').tooltip({
            show: true,
            html: true,
            title: "Hello",
            template: `
        <div class="custom-tooltip tooltip">
            <div class="tooltip-inner">Hi</div>
        </div>
        `
        })

        $('form').attr('autocomplete', 'off');
        var journalEntryDetails = $('#journalEntryDetails').DataTable({
            dom: 'Bftrip',
            pageLength: 10,
            buttons: ['print', 'csv',
                {
                    text: '<i class="fas fa-file-download" aria-hidden="true"></i>',
                    className: 'btn btn-flat btn-sm btn-default',
                    titleAttr: 'Export',
                    action: function(e, dt, node, config) {
                        var exportBtn = document.getElementsByClassName(
                            'btn btn-secondary buttons-csv buttons-html5')[0];
                        exportBtn.click();
                    }
                },
                {
                    text: '<i class="fas fa-print" aria-hidden="true"></i>',
                    className: 'btn btn-flat btn-sm btn-default',
                    titleAttr: 'Print',
                    action: function(e, dt, node, config) {
                        var printBtn = document.getElementsByClassName(
                            'btn btn-secondary buttons-print')[0];
                        printBtn.click();
                    }
                },
            ],
        });
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });



        $('.select2').select2({
            placeholder: 'Select',
            allowClear: true,
        });

        $('.select-account').select2({
            placeholder: 'Select Account',
            allowClear: true,
        });

        $('.select-subsidary').select2({
            placeholder: 'Select S/L',
            allowClear: true,
        });

        $(document).on('change', '#amount', function() {
            if ($.isNumeric($(this).val())) {
                console.log("Numeric")
            } else {
                console.log("String")
            }
        })



        $.fn.editable.defaults.mode = 'inline';

        $('.records').editable({
            type: 'text',
            emptytext: '',
            showbuttons: false,
            toggle: 'manual',
            onblur: 'cancel',
            inputclass: 'form-control form-control-sm block input-text',
            display: function(value) {

                $(this).text(amountConverter(value))
            }
        })

        /*          $('.editable-row-item').editable({
                    type: 'text',
                    emptytext: '',
                    showbuttons: false,
                    unsavedclass: null,
                    toggle: 'manual',
                    onblur: 'cancel',
                    inputclass: 'form-control form-control-sm block input-text',
                    success: function(newValue) {
                        var id = $(this).attr('id')
                        var input = $('.input-text').val();
                        switch (id) {
                            case 'debit':
                                $('a#debit').text(amountConverter(input))
                        }

                    }
                }); */


        $(".editables").on("shown", function(e, editable) {

            console.log(editable.input.$input)
        });

        function submitEditable() {
            $('.editable-table-data .editableform').editable().submit();
        }
        $(document).on('click', '.remove-journalDetails', function(e) {
            $(this).parents('tr').remove();
        })
        $(document).on('submit', '#journalEntryForm', function(e) {
            e.preventDefault();
            var serialized = $(this).serializeArray();
            var amount = Number($('#amount').val().replace(/[^0-9\.-]+/g, ""))
            serialized.push({
                name: 'amount',
                value: amount
            })
            var _st = false;
            $.each($('#tbl-create-journal-container').find('tr'), function(k, v) {
                var field = $(v).children()
                if ($(field[0]).find('.editable-row-item').text() == '' ||
                    $(field[1]).find('.editable-row-item').val() == '' ||
                    $(field[4]).find('.editable-row-item').val() == '') {
                    _st = false;
                    return false;
                } else {
                    _st = true;
                }
            });
            if (parseFloat($('#debit_balance').text().float()) != 0) {
                if (_st) {
                    var serialized = $(this).serializeArray();


                    var amount = Number($('#amount').val().replace(/[^0-9\.-]+/g, ""))
                    serialized.push({
                        name: 'amount',
                        value: amount
                    })
                    var entry = {};
                    serialized.map(function(i) {
                        entry[i.name] = i.value;
                    });

                    var details = saveJournalEntryDetails('save');


                    var data = Object.assign({
                        "journal_entry": entry,
                        "details": details
                    });
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "{{ route('journal.saveJournalEntry') }}",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                            toastr.success(data.message);
                            reload();
                        },
                        error: function(data) {
                            toastr.error('Error');
                        }
                    });
                } else {
                    alert('MUST ALL COMPLETE THE JOURNAL DETAILS FIELD');
                }
            } else if ($('#amount').val() != parseFloat($('#total_credit').text().float())) {
                alert('AMOUNT VALUE IS NOT EQUAL TO DEBIT');
            } else {
                alert('MUST ALL COMPLETE THE JOURNAL DETAILS FIELD');
            }
        });
        $(document).on('click', '.jnalDelete', function(e) {
            e.preventDefault();
            var id = $(this).attr('value');
            if (confirm("Are You Sure want to delete this Journal Entry ?")) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('journal.JournalEntryDelete') }}",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.message == 'delete') {
                            toastr.success('Successfully Delete');
                            reload();
                        }
                    },
                    error: function() {
                        toastr.error('Error');
                    }
                });
            }
        })
        $(document).on('click', '.JnalFetch', function(e) {
            e.preventDefault();
            var id = $(this).attr('value');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('journal.JournalEntryFetch') }}",
                data: {
                    items: details
                },
                dataType: "json",
                success: function(data) {
                    console.log(data)
                },
                error: function() {
                    toastr.error('Error');
                }
            });
        })
        $(document).on('DOMSubtreeModified', 'a[fieldName="journal_details_debit"]', function() {

            $('#total_debit').text(getTotal('debit').toLocaleString("en-US"));
            $('#edit_total_debit').text(getTotal('debit').toLocaleString("en-US"));
            getBalance()
            checkTotalAndAmount()
        })
        $(document).on('DOMSubtreeModified', 'a[fieldName="journal_details_credit"]', function() {
            $('#total_credit').text(getTotal('credit').toLocaleString("en-US"));
            $('#edit_total_credit').text(getTotal('credit').toLocaleString("en-US"));
            getBalance()
            checkTotalAndAmount()
        })
        $(document).on('change', '.COASelect', function(e) {
            var accnu = $(this).parent().siblings('.acctnu').first().find('.journal_details_account_no')
                .text($('option:selected', this).attr('acct-num'));
        });
        $(document).on('click', '.stStatus', function(e) {
            var journal_id = $(this).attr('value');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('journal.JournalEntryPostUnpost') }}",
                data: {
                    journal_id: journal_id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data)
                    if (data.message == 'posted') {
                        toastr.success('Successfully Update');
                        reload();
                    }
                },
                error: function(data) {
                    toastr.error('Error');
                }
            });
        });
        $(document).on('click', '.stsVoucher', function(e) {
            $('#journalDetailsVoucher').modal('show')
        });
        $('#journalEntryFormEdit').submit(function(e) {
            e.preventDefault();
            var s_data = $(this).serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('journal.JournalEntryEdit') }}",
                data: s_data,
                dataType: "json",
                success: function(data) {
                    if (data.message == 'update') {
                        saveJournalEntryDetails(data.id, 'update')
                    }
                },
                error: function(data) {
                    toastr.error('Error');
                }
            });
        });
        $(document).on('click', '.JnalEdit', function(e) {
            $('#journalModalEdit').modal('show');
            var id = $(this).attr('value');
            $('#tbl-create-edit-container').html('');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {
                    journal_id: id
                },
                url: "{{ route('journal.JournalEntryFetch') }}",
                dataType: "json",
                success: function(response) {
                    if (response.message == 'fetch') {
                        $.each(response.data, function(k, v) {
                            var total_debit = 0;
                            var total_credit = 0;
                            var balance = 0;
                            $('#edit_LrefNo').text(v.journal_no)
                            $('#edit_journal_id').val(v.journal_id);
                            $('#edit_journal_date').val(v.journal_date);
                            $('#edit_branch_id').val(v.branch_id);
                            $('#edit_book_id').val(v.book_id);
                            $('#edit_source').val(v.source);
                            $('#edit_cheque_no').val(v.cheque_no);
                            $('#edit_cheque_date').val(v.cheque_date);
                            $('#edit_status').val(v.status);
                            $('#edit_amount').val(v.amount);
                            $('#edit_payee').val(v.payee);
                            $('#edit_remarks').val(v.remarks);
                            $.each(v.journal_entry_details, function(kk, vv) {
                                $('#tbl-create-edit-container').append(`<tr class='editable-table-row'>
								<td class="acctnu" value="" >
									<a href="#" class="editable-row-item journal_details_account_no">${vv.account.account_number}</a>
								</td>
								<td class='editable-table-data' value="" >
									<select  fieldName="account_id" id="subsidiary_acct_${vv.journal_details_id}" class="select-account form-control form-control-sm editable-row-item COASelect">
										<option disabled value="" selected>-Select Account Name-</option>
										@foreach ($chartOfAccount as $account)
											<option value="{{ $account->account_id }}" acct-num="{{ $account->account_number }}">{{ $account->account_name }}</option>
										@endforeach
									</select>
								</td>
                            </td>
                            <td class='editable-table-data journalNum' id="deb" value="">
                                <a href="#" fieldName="journal_details_debit" id="debit"
                                                    class="editable-row-item records">
                                                    ${parseFloat(vv.journal_details_debit)}
                                                </a>
                                            </td>

                                            <td class='editable-table-data journalNum' id="cre" value="">
                                                <a href="#" fieldName="journal_details_credit" id="credit"
                                                    class="editable-row-item records">
                                                    ${parseFloat(vv.journal_details_credit)}

                                                </a>
                                            </td>


								<td class='editable-table-data' value="" >
									<select  fieldName="subsidiary_id" id="subsidiary_${vv.journal_details_id}" class="select-account form-control form-control-sm editable-row-item edit_subsidiary_item" value="">
										@foreach ($subsidiaries as $subsidiary)
											<option value="{{ $subsidiary->sub_id }}">{{ $subsidiary->sub_name }}</option>
										@endforeach
									</select>
								</td>
								<td>
									<button class="btn btn-secondary btn-flat btn-sm btn-default remove-journalDetails">
										<span>
											<i class="fas fa-trash" aria-hidden="true"></i>
										</span>
									</button>
								</td>
							</tr>`);
                                $('#subsidiary_acct_' + vv.journal_details_id)
                                    .val(vv.account_id);
                                $('#subsidiary_' + vv.journal_details_id).val(vv
                                    .subsidiary_id);
                                total_debit = parseFloat(total_debit) +
                                    parseFloat(vv.journal_details_debit)
                                total_credit = parseFloat(total_credit) +
                                    parseFloat(vv.journal_details_credit)
                                balance = parseFloat(total_debit) - parseFloat(
                                    total_credit)
                            });
                            $('#edit_total_debit').text(total_debit)
                            $('#edit_total_credit').text(total_credit)
                            $('#edit_balance_debit').text(balance)
                        });
                    }
                },
                error: function() {
                    console.log("Error");
                }
            });
        });
        $(document).on('click', '.JnalView', function(e) {
            e.preventDefault();
            var id = $(this).attr('value');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {
                    journal_id: id
                },
                url: "{{ route('journal.JournalEntryFetch') }}",
                dataType: "json",
                success: function(response) {
                    if (response.message == 'fetch') {
                        var total_debit = 0;
                        var total_credit = 0;
                        $('#tbl-create-journalview-container').html('');
                        $('#journalVoucherContent').html('');
                        $('#vjournal_remarks').html('');
                        $.each(response.data, function(k, v) {
                            $('#posted-content').html('');
                            var content = '';
                            $('#vjournal_date, #voucher_date').text(v.journal_date);
                            $('#vjournal_book_reference, #voucher_ref_no').text(v
                                .book_details.book_name);
                            $('#vjournal_source, #voucher_source').text(v.source);
                            $('#vjournal_cheque').text((v.cheque_no) ? v.cheque_no :
                                'NO CHEQUE');
                            $('#vjournal_status').text(v.status);
                            $('#vjournal_amount, #voucher_amount').text(parseFloat(v
                                .amount).toLocaleString("en-US"));
                            $('#vjournal_payee, #voucher_pay').text(v.payee);
                            $('#voucher_amount_in_words').text(numberToWords(parseFloat(
                                v.amount)));
                            $.each(v.remarks.split('::'), function(k, vv) {
                                $('#vjournal_remarks').append(
                                    `<li>${vv}</li>`
                                );
                            });
                            $('#vjournal_branch, #voucher_branch').text(v.branch_id);
                            $('#vjournal_cheque_date').text(v.cheque_date);
                            if (v.status == 'unposted') {
                                content =
                                    `<button value="${v.journal_id}"  class="btn btn-flat btn-sm bg-gradient-success stStatus">Posted</button>`;

                            } else {
                                content =
                                    `<button disabled  class="btn btn-flat btn-sm  bg-gradient-gray">Posted</button>
										<button  class="btn btn-flat btn-sm bg-gradient-info stsVoucher">View Journal Voucher</button>
										<button  class="btn btn-flat btn-sm bg-gradient-success" id="printVoucher"><i class="fa fa-print"></i> Print</button>`
                            }
                            $('#posted-content').html(content);
                            $.each(v.journal_entry_details, function(kk, vv) {
                                total_debit += parseFloat(vv
                                    .journal_details_debit);
                                total_credit += parseFloat(vv
                                    .journal_details_credit);
                                console.log(v.journal_details)
                                $('#tbl-create-journalview-container').append(`
								<tr class='editable-table-row'>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.account.account_number}</label></td>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.account.account_name}</label> </td>

									<td class='editable-table-data' value="" >
										<label class="label-normal" >${vv.subsidiary.sub_name}</label>
									</td>
                                    <td class='editable-table-data' value="" >	<label class="label-normal" >${amountConverter(vv.journal_details_debit)}</label> </td>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${amountConverter(vv.journal_details_credit)}</label> </td>
								</tr>
							`);
                                $('#journalVoucherContent').append(`
								<tr>
									<td class="center">${vv.account.account_number}</td>
									<td class="left">${vv.account.account_name}</td>
									<td class="left">${vv.subsidiary.sub_name}</td>
									<td class="center">${amountConverter(vv.journal_details_debit)}</td>
									<td class="right">${amountConverter(vv.journal_details_credit)}</td>
								</tr>`);
                            })
                            $('#vtotal_debit, #total_debit_voucher').text(
                                amountConverter(total_debit))
                            $('#vtotal_credit, #total_credit_voucher').text(
                                amountConverter(total_credit))
                            $('#vbalance_debit').text(amountConverter((parseFloat(
                                total_debit) - parseFloat(total_credit))))
                        });
                    }
                    $('#journalModalView').modal('show')
                },
                error: function() {
                    console.log("Error");
                }
            });
        })
        $(document).on('click', '.JnalView', function(e) {
            e.preventDefault();
            var id = $(this).attr('value');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {
                    journal_id: id
                },
                url: "{{ route('journal.JournalEntryFetch') }}",
                dataType: "json",
                success: function(response) {
                    if (response.message == 'fetch') {
                        console.log(response);
                    }
                },
                error: function() {
                    console.log("Error");
                }
            });
        })
        $('#SearchJournalForm').submit(function(e) {
            e.preventDefault();
            var s_data = $(this).serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "{{ route('journal.searchJournalEntry') }}",
                data: s_data,
                dataType: "json",
                success: function(data) {
                    $('#journalEntryDetails').DataTable().destroy();
                    $('#journalEntryDetailsContent').html('');

                    $.each(data, function(k, v) {

                        var status = (v.status == 'posted') ? 'text-success' :
                            'text-danger';
                        var disabled = (v.status == 'posted') ? 'disabled' : '';

                        $('#journalEntryDetailsContent').append(
                            `<tr>
							<td class="font-weight-bold">${v.book_details.book_code}</td>
                            <td>${v.journal_no}</td>
							<td>${v.source}</td>
							<td>${v.amount}</td>
							<td>${v.remarks}</td>
							<td>${v.journal_date}</td>
							<td class="nav-link ${status}"><b>${v.status}</b></td>
							<td>
                                <button value="${v.journal_id}" ${disabled} class="btn btn-flat btn-xs bg-gradient-danger jnalDelete"><i class="fa fa-trash"></i></button>
                                <button value="${v.journal_id}" class="btn btn-flat btn-xs JnalView bg-gradient-primary"><i class="fa fa-eye"></i></button>
                                <button value="${v.journal_id}" ${disabled} class="btn btn-flat btn-xs JnalEdit bg-gradient-info"><i class="fa fa-edit"></i></button>
                                <button value="${v.journal_id}" class="btn btn-flat btn-xs bg-gradient-success stStatus"><i class="fa fa-check"></i></button>
							</td>
						</tr>`
                        );



                    });
                    $('#journalEntryDetails').DataTable();
                },
                error: function(data) {
                    toastr.error('Error');
                }
            });
        });
        $(document).on('blur', '#cheque_no', function(e) {
            e.preventDefault();
            console.log($(this).val())
            if ($(this).val() == '') {
                $('#cheque_date').removeAttr('required');
            } else {
                $('#cheque_date').prop('required', true);

            }
        });
        $(document).on('click', '#printVoucher', function(e) {
            var winPrint = window.open('', '',
                'left=0,top=0,width=800,height=600,toolbar=0,scrollbars=0,status=0');
            winPrint.document.write($('#toPrintVouch').html());
            winPrint.document.close();
            winPrint.focus();
            window.setTimeout(() => {
                winPrint.print();
                winPrint.close();
            }, 500);
        })


        $(document).on('click', '#add_item', function(e) {
            e.preventDefault();


            var content = `<tr class='editable-table-row'>
			<td class="acctnu" value="" >
				<a href="#" class="editable-row-item journal_details_account_no"></a>
			</td>
			<td class='editable-table-data' value="" >
				<select  fieldName="account_id" class="select-account form-control form-control-sm editable-row-item COASelect">
					<option disabled value="" selected>-Select Account Name-</option>
					@foreach ($chartOfAccount as $account)
						<option value="{{ $account->account_id }}" acct-num="{{ $account->account_number }}">{{ $account->account_number }} - {{ $account->account_name }}</option>
					@endforeach
				</select>
			</td>
            <td class='editable-table-data' value="" ><a href="#" fieldName="journal_details_debit"class="records editable-row-item"></a> </td>
			<td class='editable-table-data' value="" ><a href="#" fieldName="journal_details_credit" class="records editable-row-item"></a> </td>
			<td class='editable-table-data' width="250">
				<select  fieldName="subsidiary_id" class="select-subsidary form-control form-control-sm editable-row-item">
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
				<button class="btn btn-secondary btn-flat btn-sm btn-default remove-journalDetails">
					<span>
						<i class="fas fa-trash" aria-hidden="true"></i>
					</span>
				</button>
			</td>
		</tr>`
            $('#tbl-create-journal-container').append(content);
            $('.records').editable({
                type: 'text',
                emptytext: '',
                showbuttons: false,
                toggle: 'manual',
                onblur: 'cancel',
                inputclass: 'form-control form-control-sm block input-text',
                display: function(value) {

                    $(this).text(amountConverter(value))
                }
            })

            $('.select-account').select2({
                placeholder: 'Select',
                allowClear: true,
            });

            $('.select-subsidary').select2({
                placeholder: 'Select S/L',
                allowClear: true,
            });
        });

        $(document).on('click', '#open_voucher', function(e) {
            e.preventDefault();
            setVoucherData();
        });
        $(document).on('click', '.editable-table-data', function(e) {
            e.stopPropagation();
            e.preventDefault();
            var field = $(this)
            if ($(this).find('.editableform').length < 1) {
                submitEditable();
            }
            $(this).find('a').each(function() {
                $(this).editable('show');
            });
            $(this).find('.editableform').each(function() {
                $(this).on('keydown', function(e) {
                    if ((e.keyCode || e.which) == 13) {
                        submitEditable();
                    }
                })
            });
        });

        function getTotal(type = '') {
            var total = 0;
            if (type == 'debit') {
                $.each($('#tbl-create-journal-container').find('tr'), function(k, v) {
                    var field = $(v).children()
                    let debitAmount = $(field[2]).find('.editable-row-item').text();
                    debitAmount = reverseAmountConverter(debitAmount);
                    if (Number.isNaN(debitAmount)) {} else {
                        if ($.isNumeric(debitAmount)) {
                            total += debitAmount;
                        }
                    }
                });

                return total;
            } else {
                $.each($('#tbl-create-journal-container').find('tr'), function(k, v) {
                    var field = $(v).children()
                    let creditAmount = $(field[3]).find('.editable-row-item').text()
                    creditAmount = reverseAmountConverter(creditAmount)
                    if (Number.isNaN(creditAmount)) {} else {
                        if ($.isNumeric(creditAmount)) {
                            total += creditAmount;
                        }
                    }
                });


                return total;
            }
            return false;
        }

        function setVoucherData() {
            // if($('#payee').val() && $('#branch_id').val() && $('#journal_date').val()
            // 	 && $('#JDetailsVoucher').val() && $('#source').val() && $('#JDetailsVoucher').val() && $('#amount').val()){
            $('#journal_VoucherContent').html('')
            $('#journal_voucher_pay').text($('#payee').val())
            $('#journal_voucher_branch').text($('#branch_id').find(":selected").text())
            $('#journal_voucher_date').text($('#journal_date').val())
            $('#journal_voucher_ref_no').text($('#JDetailsVoucher').val())
            $('#journal_voucher_source').text($('#source').val())
            $('#journal_voucher_particular').text($('#JDetailsVoucher').val())
            $('#journal_voucher_amount').text(Number($('#amount').val().replace(/[^0-9\.-]+/g, "")))
            /*         $('#journal_voucher_amount').text($('#amount').val().toLocaleString("en-US")) */

            $('#journal_voucher_amount_in_words').text(numberToWords(parseFloat(Number($('#amount').val().replace(
                /[^0-9\.-]+/g, "")))))


            $('#journal_total_debit_voucher').text($('#total_debit').text())
            $('#journal_total_credit_voucher').text($('#total_credit').text())


            $.each($('#tbl-create-journal-container').find('tr'), function(k, v) {
                var field = $(v).children()
                $('#journal_VoucherContent').append(`
				<tr>
					<td class="center">${$(field[0]).find('.editable-row-item').text()}</td>
					<td class="left">${$(field[1]).find('.editable-row-item').find(":selected").text()}</td>
					<td class="left">${$(field[2]).find('.editable-row-item').text()}</td>
					<td class="center">${$(field[3]).find('.editable-row-item').text()}</td>
					<td class="right">${$(field[4]).find('.editable-row-item').find(":selected").text()}</td>
				</tr>`);

            });
            $('#JDetailsVoucher').modal('show');
        }

        function saveJournalEntryDetails(type) {
            var elem = $('#tbl-create-edit-container');
            if (type == 'save') {
                elem = $('#tbl-create-journal-container');
            }
            var details = [];
            $.each(elem.find('tr'), function(k, v) {
                var field = $(v).children()
                var accountName = $(field[1]).find('.select2').text().split("- ")
                var debit = ($(field[2]).find('.editable-row-item').text() === '') ?
                    '0' : $(field[2]).find('.editable-row-item').text()
                var credit = ($(field[3]).find('.editable-row-item').text() === '') ?
                    '0' : $(field[3]).find('.editable-row-item').text()
                details.push({
                    journal_details_account_no: $(field[0]).find('.editable-row-item').text(),
                    account_id: $(field[1]).find('.editable-row-item').val(),
                    journal_details_title: accountName[1],
                    journal_details_debit: reverseAmountConverter(debit),
                    journal_details_credit: reverseAmountConverter(credit),
                    subsidiary_id: $(field[4]).find('.editable-row-item').val(),
                });
            });
            return details;

        }

        function getBalance() {
            $('#balance_debit').text(
                (parseFloat($('#total_debit').text().replace(",", "")) - parseFloat($('#total_credit').text()
                    .replace(",", ""))).toLocaleString("en-US")
            );
            $('#edit_balance_debit').text(
                (parseFloat($('#edit_total_debit').text().replace(",", "")) - parseFloat($('#edit_total_credit')
                    .text().replace(",", ""))).toLocaleString("en-US")
            );
        }

        function numberToWords(number) {
            var digit = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
            var elevenSeries = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen',
                'seventeen', 'eighteen', 'nineteen'
            ];
            var countingByTens = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
            var shortScale = ['', 'thousand', 'million', 'billion', 'trillion'];
            number = number.toString();
            number = number.replace(/[\, ]/g, '');
            if (number != parseFloat(number)) return 'not a number';
            var x = number.indexOf('.');
            if (x == -1) x = number.length;
            if (x > 15) return 'too big';
            var n = number.split('');
            var str = '';
            var sk = 0;
            for (var i = 0; i < x; i++) {
                if ((x - i) % 3 == 2) {
                    if (n[i] == '1') {
                        str += elevenSeries[Number(n[i + 1])] + ' ';
                        i++;
                        sk = 1;
                    } else if (n[i] != 0) {
                        str += countingByTens[n[i] - 2] + ' ';
                        sk = 1;
                    }
                } else if (n[i] != 0) {
                    str += digit[n[i]] + ' ';
                    if ((x - i) % 3 == 0) str += 'hundred ';
                    sk = 1;
                }
                if ((x - i) % 3 == 1) {
                    if (sk) str += shortScale[(x - i - 1) / 3] + ' ';
                    sk = 0;
                }
            }
            if (x != number.length) {
                var y = number.length;
                str += 'point ';
                for (var i = x + 1; i < y; i++) str += digit[n[i]] + ' ';
            }
            str = str.replace(/\number+/g, ' ');
            return str.trim() + " Pesos Only.";
        }

        function checkTotalAndAmount() {
            if ($('#amount').val() == '') {
                let amount = prompt("Please enter Amount");
                if (amount == null || amount == '') {
                    checkTotalAndAmount();
                } else {
                    $('#amount').val(parseFloat(amount));
                    if (amount < parseFloat($('#total_debit').text().replace(",", "")) || amount < parseFloat($(
                            '#total_credit').text().replace(",", ""))) {
                        alert('INPUTED EXCEED FROM EXPECTED AMOUNT')
                    }
                }
            }
        }
        $(document).click(function() {
            submitEditable();
        });
        $(document).on('submit', '#frm-journal-entry', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serializeArray();
            var accountName = $('select[name=account_id] option:selected').text();
            var accountId = formData[0].value;
            var debit = formData[1].value;
            var credit = formData[2].value;
            // var personId = formData[4].value;
            var personName = $('select[name=person] option:selected').text();
            var personType = $('select[name=person] option:selected').data('type');
            var markup = `
			<tr class="transaction-items">
				<td></td>
				<td>${accountName}</td>
				<td class="text-right">${debit}</td>
				<td class="text-right">${credit}</td>
				<td>${personName}</td>
				<td class="text-center"><i class="fa fa-trash-alt fa-xs text-muted remove-items" aria-hidden="true"></i></td>
			</tr>
			`;
            $('#footer-row').before(markup);
        });
        $(document).on('submit', '#frm-create-journal', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serializeArray();
            var url = form.prop('action');

            var posting = $.post(url, formData);
            posting.done(function(response) {
                console.log(response);
            });
        });
        $(document).on('change', '#book_id', function() {
            $('#journal_no').val($(this).find(':selected').attr('_count'));
            $('#LrefNo').text($(this).find(':selected').attr('_count'));
        });

        function editJournal(id) {
            console.log(id)
            $('#journalModal').modal('show')
        }
        String.prototype.float = function() {
            return parseFloat(this.replace(',', '.'));
        }

        function reload() {
            window.setTimeout(() => {
                location.reload();
            }, 500);
        }
    })(jQuery);
</script>
