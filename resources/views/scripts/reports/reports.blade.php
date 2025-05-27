<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript">
    // $(document).ready(function(){
    // $("form").submit(function(){
    //   alert("Submitted");
    // });
    // });


    (function($) {

        var cashblotter_tbl
        fetchCashBlotter()


        $('#total').insertAfter('#journal tr:first');


        var editCashblotterFlyOut = new GlobalWidget();
        var showCashblotterFlyOut = new GlobalWidget();



        /*  $('#create-cashblotter').click(function(){
             $('#Mymodal').modal('show')
             reset()
             $('#title').text("Cashier's Transaction Blotter (New)")

             var branchID;

             if ($('#branch_id').length) {
                 $(document).on('change','#branch_id',function(){
                     branchID = $(this).val(); // Get selected value from the dropdown
                     fetchCollectionBreakdown(branchID);
                 });
             } else {
                 $('#transactionDate').prop('disabled', false);
                 branchID = "{{ session()->get('auth_user_branch') }}"; // Use session value if not visible
                 fetchCollectionBreakdown(branchID);
             }
         });
         $('#edit-cashblotter').click(function(){
             $('#Mymodal').modal('show')
             reset()
             $('#title').text("Cashier's Transaction Blotter (New)")

             var branchID;

             if ($('#branch_id').length) {
                 $(document).on('change','#branch_id',function(){
                     branchID = $(this).val(); // Get selected value from the dropdown
                     fetchCollectionBreakdown(branchID);
                 });
             } else {
                 $('#transactionDate').prop('disabled', false);
                 branchID = "{{ session()->get('auth_user_branch') }}"; // Use session value if not visible
                 fetchCollectionBreakdown(branchID);
             }
         }); */

        // Function to fetch collection breakdown based on branch ID
        function fetchCollectionBreakdown(branchID) {
            if (branchID) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('reports.getLatestCollectionBreakdown', '') }}/" + branchID,
                    success: function(response) {
                        if (response.latest_collection) {
                            // Get the transaction date and increment it by one day
                            const lastTransaction = new Date(response.latest_collection
                                .transaction_date);
                            // console.log(lastTransaction);
                            lastTransaction.setDate(lastTransaction.getDate() + 1);

                            // Set the min attribute to the next day in YYYY-MM-DD format
                            $('#transactionDate').attr("min", lastTransaction.toISOString().split('T')[
                                0]);
                        } else {
                            $('#transactionDate').removeAttr(
                                "min"); // Remove the min attribute if no collection data
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            } else {
                $('#transactionDate').datepicker("option", "minDate", null);
            }
        }

        /*
         **********************  EDIT CASH BLOTTER **************************
         */

        $(document).on('click', '#update-cashblotter', function(e) {
            e.preventDefault();
            $('#Mymodal').modal('show')
            reset()
            $('#title').text("Cashier's Transaction Blotter (Edit)")

            var cashblotter_id = $(this).attr('data-id')
            console.log(e)
            $.ajax({
                type: "POST",
                url: "cashTransactionBlotter/" + cashblotter_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(response) {
                    $('#onethousand').val(response.data.cash_breakdown.onethousand_pesos)
                    $('#fivehundred').val(response.data.cash_breakdown.fivehundred_pesos)
                    $('#twohundred').val(response.data.cash_breakdown.twohundred_pesos)
                    $('#onehundred').val(response.data.cash_breakdown.onehundred_pesos)
                    $('#fifty').val(response.data.cash_breakdown.fifty_pesos)
                    $('#twenty').val(response.data.cash_breakdown.twenty_pesos)
                    $('#ten').val(response.data.cash_breakdown.ten_pesos)
                    $('#five').val(response.data.cash_breakdown.five_pesos)
                    $('#one').val(response.data.cash_breakdown.one_peso)
                    $('#centavo').val(response.data.cash_breakdown.one_centavo)
                    setCashBreakdown()

                }
            });
            /* let target = $(this);
            let title = target.data('title');
            let route = target.data('remote');
            editCashblotterFlyOut.setTitle(title)
                        .setRoute(route)
                        .setCallback( function(){
                            $('.select2').select2({
                                placeholder: 'Select',
                                allowClear: true,
                            })
                        }).init(); */
        })

        function setCashBreakdown() {
            $('.cash-breakdown').each(function(index, row) {

                let cells = $(row).find('td');
                let val = cells.eq(0).text();
                let pcs = $(row).find('input[type=number]').val()
                var total_amount = cells.eq(2).text()
                let total = val * pcs
                cells.eq(2).text(amountConverter(total))
                totalCashCount()


            });


        }

        /*
         **********************  VIEW CASH BLOTTER **************************
         */

        $(document).on('click', '.view-cashblotter', function(e) {
            e.preventDefault();


            let target = $(this);
            let title = target.data('title');
            let route = target.data('remote');

            showCashblotterFlyOut.setTitle(title)
                .setRoute(route)
                .setCallback(function() {
                    $('.select2').select2({
                        placeholder: 'Select',
                        allowClear: true,
                    })
                }).init();
        })

        /*
         **********************  DELETE CASH BLOTTER **************************
         */

        $(document).on('click', '.delete-cashblotter', function(e) {
            e.preventDefault();
            alert("delete cash blotter")





            /* let target = $(this);
            let title = target.data('title');
            let route = target.data('remote');

            paymentFlyout.setTitle(title)
                        .setRoute(route)
                        .setCallback( function(){
                            $('.select2').select2({
                                placeholder: 'Select',
                                allowClear: true,
                            })
                        }).init(); */
        })


        /*
         **********************  DOWNLOAD CASH BLOTTER **************************
         */
        $(document).on('click', '.download-cashblotter', function(e) {
            e.preventDefault();
            alert("download cash blotter")



            /* let target = $(this);
            let title = target.data('title');
            let route = target.data('remote');

            paymentFlyout.setTitle(title)
                        .setRoute(route)
                        .setCallback( function(){
                            $('.select2').select2({
                                placeholder: 'Select',
                                allowClear: true,
                            })
                        }).init(); */
        })


        /*
         **********************  PRINT CASH BLOTTER **************************
         */

        $(document).on('click', '.print-cashblotter', function(e) {
            e.preventDefault();
            alert("print cash blotter")



            /* let target = $(this);
            let title = target.data('title');
            let route = target.data('remote');

            paymentFlyout.setTitle(title)
                        .setRoute(route)
                        .setCallback( function(){
                            $('.select2').select2({
                                placeholder: 'Select',
                                allowClear: true,
                            })
                        }).init(); */
        })



        /*
         **********************  ADD CASH BLOTTER **************************
         */
        $(document).on('change', '#branch_id', function() {
            // Get the selected branch ID
            const selectedBranchId = $(this).val();

            // If a branch is selected (i.e., selectedBranchId is not empty or null)
            if (selectedBranchId) {
                // Enable the date picker (if branch is selected)
                $('#transactionDate').prop('disabled', false);
            } else {
                // Disable the date picker (if no branch is selected)
                $('#transactionDate').prop('disabled', true);
            }
        });

        $(document).on('change', '#select_branch', function() {
            var branch_id = $(this).val()
            $('.select-officer').find('option').remove()
            $('.select-officer').append('<option value="" disabled selected text="Select-Officer">')
            $.ajax({
                type: "get",
                url: "{{ route('reports.fetchAccountOfficer', ['id' => 'branch_id']) }}".replace(
                    'branch_id', branch_id),
                dataType: "json",
                success: function(response) {
                    var data = response.data
                    $.each(data, function(i, item) {
                        $('.select-officer ').append($('<option>', {
                            value: item.accountofficer_id,
                            text: item.name
                        }))
                    })
                }
            });

        })

        /* $(document).on('click','#get-cash-blotter',function(){
            var transactionDate = $('#transaction_date').val()
            var data = {
                transaction_date: $('#transaction_date').val()
            }
            $.ajaxSetup({
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
             });
            $.ajax({
                type:"POST",
                url:"<?= config('app.url') ?>/reports/cashTransactionBlotter",
                data:data,
            }).done(function(data) {
                console.log(data);
            })
        }) */


        $(document).on('submit', '#filter-cash-blotter', function(e) {
            event.preventDefault();
            return alert(e);
        })


        /* $(document).on('submit','#add-cash-blotter',function(e){
            e.preventDefault()

            var form = $(this);
            var formData = form.serializeArray();
            var totalcash_count = parseFloat($('#totalcashcount').text().replace(/[^0-9\.-]+/g, ""));
            var selectedBranchValue = $('#branch_id').val();
            var cashEndingBranch = selectedBranchValue ? selectedBranchValue : "{{ session()->get('auth_user_branch') }}" ;
            var transactionDate = $('#transactionDate').val(); // Assuming there's a transaction date input field

            // Validate transaction date
            if (!transactionDate) {
                alert("Please select a transaction date.");
                return false;
            }

            // Fetch cash ending balance from the ReportsController
            $.ajax({
                type: 'GET',
                url: "{{ route('reports.getCashEndingBalance', '') }}/" + cashEndingBranch,
                data: { transaction_date: transactionDate },
                success: function(response) {
                    var cashEndingBalance = parseFloat(response.cash_ending_balance); // Adjust based on your JSON structure

                    // console.log("Total Cash Count:", totalcash_count);
                    // console.log("Cash Ending Balance:", cashEndingBalance);

                    // Compare total cash count with fetched cashEndingBalance
                    if (totalcash_count !== cashEndingBalance) {
                        let formattedDate = new Date(transactionDate).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        alert("Total Cash Count does not match Cash Ending Balance of " + amountConverter(cashEndingBalance) + " as of " + formattedDate + "!");
                        //return true; // Prevent form submission
                    }

                    // Proceed with form submission if the values match
                    var aocollection_items = addAoCollection();
                    var branchcollection_items = addBranchCollection();

                    if (!aocollection_items) {
                        alert("Please add account officer collection");
                        return false;
                    }

                    formData.push({ name: 'branch_id', value: selectedBranchValue });
                    formData.push({ name: 'total', value: totalcash_count });
                    formData.push({ name: 'collection_ao', value: aocollection_items });
                    formData.push({ name: 'branch_collection', value: JSON.stringify(branchcollection_items) });

                    var fdata = {};
                    for (var i in formData) {
                        var fd = formData[i];
                        fdata[fd.name] = fd.value;
                    }

                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        url: "{{ route('create.collection.breakdown') }}",
                        data: fdata,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            toastr.success(data.message);
                            $('#Mymodal').modal('hide');
                            $('#cash-blotter-tbl').DataTable().ajax.reload();
                            reset(); // Clear input fields or reset the form
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText); // Log error details
                            // Handle validation errors
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors; // Access validation errors
                                var errorMessages = [];
                                for (var field in errors) {
                                    errorMessages.push(errors[field].join(', ')); // Join messages for each field
                                }
                                alert("Validation errors:\n" + errorMessages.join("\n")); // Display the errors
                                reset()
                            } else {
                                // Handle other errors (e.g., server errors)
                                alert("An error occurred: " + (xhr.responseJSON.message || "Please try again."));
                                reset()
                            }
                        }
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Log error details
                    alert("Failed to retrieve Cash Ending Balance. Please try again.");
                }
            });
        }); */

        function reset() {
            $('#add-cash-blotter')[0].reset()
            $('#branch_id').val('').trigger('change')
            $('#remarks').val('')
            $('#branch_id_collection').val('').trigger('change')
            $('.aocollection-items').remove()
            $('.branchcollection-items').remove()
            $('#totalbranchcollection').text(0)
            $('#totalaccountofficercollection').text(0)
            $('#totalcashcount').text(0)
            $('.cash-breakdown').each(function(index, row) {
                let cells = $(row).find('td')
                cells.eq(2).text(0)
            })

        }



        function addAoCollection() {
            var items = [];

            $('.aocollection-items').each(function(index, row) {

                let cells = $(row).find('td');
                let accountofficer_id = cells.eq(0).text();
                let remarks = cells.eq(1).text();
                let totalamount = Number(cells.eq(2).text().replace(/[^0-9\.-]+/g, ""))

                /* let aocollection_totalamount = Number(cells.eq(3).text().replace(/[^0-9\.-]+/g,"")); */

                items.push({
                    'representative': accountofficer_id,
                    'note': remarks,
                    'total': totalamount,
                    'grp': 'collection officer'
                });

            });
            if (items.length) {
                return items
            }

            return false;
        }

        function addBranchCollection() {
            var items = [];

            $('.branchcollection-items').each(function(index, row) {

                let cells = $(row).find('td');
                let branch_id_collection = cells.eq(0).data('id');
                let totalamount = Number(cells.eq(1).text().replace(/[^0-9\.-]+/g, ""))

                /* let aocollection_totalamount = Number(cells.eq(3).text().replace(/[^0-9\.-]+/g,"")); */

                items.push({
                    'branch_id': branch_id_collection,
                    'totalamount': totalamount
                });

            });

            if (items.length) {
                return items
            }
            return false;
        }

        /*
         **********************  SELECT DROPDOWN WITH INPUT SEARCH **************************
         */

        $('.select-officer').select2({
            placeholder: 'Select-Officer',
            allowClear: true,
        });

        $('.select-account').select2({
            placeholder: 'Select-Account',
            allowClear: true,
        });

        $('.select-branch').select2({
            placeholder: 'Select-Branch',
            allowClear: true,
        });

        $('#subsidiaryDD').select2({
            placeholder: 'Select-Subsidiary',
            allowClear: true,
        });

        $('#subsidiaryFilterAccountTitle').select2({
            placeholder: 'Select-AccountTitle',
            allowClear: true,
        });


        /*
         **********************  CASH BRANCH COLLECTION  **************************
         */

        $(document).on('click', '#btn-add-branch-collection', function(e) {

            var branchcollection_amount = amountConverter($('#branchcollection_amount').val())
            var branch_id_collection = $('#branch_id_collection').val();
            if (branchcollection_amount == "" || branch_id_collection == null) {
                alert("All fields are required")
            } else {
                var branch_name = $('#branch_id_collection option:selected').text();
                var markup = `
                <tr class="branchcollection-items">
                <td data-id="${branch_id_collection}" >${branch_name}</td>
                <td id="total_amount">${branchcollection_amount}</td>
                <td class="text-center"><button id="btn-remove-account-officer-collection" class="btn btn-xs btn-danger remove-account-officer-collection">
                        <i class="fas fa-trash fa-xs"></i>
                    </button></i>
                </td>
                </tr>
                `;
                $('#branch-collection-row').before(markup);
                calculateAmount("branchcollection");

                $('#branchcollection_amount').val("")
                $('#branch_id_collection').val(null).trigger("change")

            }

        })




        /*
         **********************  CASH ACCOUNT OFFICER COLLECTION  **************************
         */

        $(document).on('click', '#btn-add-account-officer-collection', function(e) {
            var remarks = $('#remarks').val();
            var total_amount = amountConverter($('#total_amount').val());
            var accountofficer_id = $('#accountofficer_id').val();
            if (remarks == "" || total_amount == "" || accountofficer_id == null) {
                alert("All fields are required")
            } else {
                var name = $('.select-officer option:selected').text();
                var markup = `
                <tr class="aocollection-items">
                <td data-id="${accountofficer_id}" >${accountofficer_id}</td>
                <td class="text-right">${remarks}</td>
                <td id="total_amount">${total_amount}</td>
                <td><button id="btn-remove-account-officer-collection" class="btn btn-xs btn-danger remove-account-officer-collection">
                        <i class="fas fa-trash fa-xs"></i>
                    </button></i>
                </td>
                </tr>
                `;
                $('#footer-row').before(markup);
                calculateAmount("aocollection");

                $('#remarks').val("")
                $('#total_amount').val("")
                $('#accountofficer_id').val(null).trigger("change")

            }

        })


        /*TRIAL BALANCE MODUKE SCRIPTS*/






















        /*END TRIAL BALANCE SCRIPTS*/
        $(document).on('click', '.remove-account-officer-collection', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            calculateAmount("aocollection");
        });

        function calculateAmount(type) {
            var amount = 0;
            totalAmount = 0;
            if (type == "aocollection") {
                $('.aocollection-items').each(function(index, row) {
                    var tr = $(this)

                    var totalCollection = tr.find('td:eq(2)').text().trim() != "" ? Number(tr.find(
                        'td:eq(2)').text().replace(/[^0-9\.-]+/g, "")) : 0;

                    totalAmount += totalCollection;
                    if (isNaN(totalCollection)) {
                        return false;
                    }

                });
                // console.log(amountConverter(totalAmount))


                $('#totalaccountofficercollection').html(amountConverter(totalAmount));
            } else {
                $('.branchcollection-items').each(function(index, row) {
                    var tr = $(this)
                    var totalCollection = tr.find('td:eq(1)').text().trim() != "" ? Number(tr.find(
                        'td:eq(1)').text().replace(/[^0-9\.-]+/g, "")) : 0;

                    totalAmount += totalCollection;
                    if (isNaN(totalCollection)) {
                        return false;
                    }

                });
                $('#totalbranchcollection').html(amountConverter(totalAmount));
            }



        }




        /*
         **********************  BALANCE SHEET  **************************
         */

        $(document).on('change', '#balanceSheetDate', function() {
            window.location = window.location.href.split('?')[0] + "?date=" + this.value
        })



        /*
         **********************  CASH BREAKDOWN  **************************
         */

        $(document).on('change', '#onethousand', function() {
            var val = 1000
            var pcs = $('#onethousand').val()
            var total = val * pcs
            $('#onethousandtotalamount').text(total === 0 ? '' : formatCurrency(total))

            totalCashCount()
        })
        $(document).on('change', '#fivehundred', function() {
            var val = 500
            var pcs = $('#fivehundred').val()
            var total = val * pcs
            $('#fivehundredtotalamount').text(total === 0 ? '' : formatCurrency(total))

            totalCashCount()
        })
        $(document).on('change', '#twohundred', function() {
            var val = 200
            var pcs = $('#twohundred').val()
            var total = val * pcs
            $('#twohundredtotalamount').text(total === 0 ? '' : formatCurrency(total))

            totalCashCount()
        })
        $(document).on('change', '#onehundred', function() {
            var val = 100
            var pcs = $('#onehundred').val()
            var total = val * pcs
            $('#onehundredtotalamount').text(total === 0 ? '' : formatCurrency(total))

            totalCashCount()
        })
        $(document).on('change', '#fifty', function() {
            var val = 50
            var pcs = $('#fifty').val()
            var total = val * pcs
            $('#fiftytotalamount').text(total === 0 ? '' : formatCurrency(total))

            totalCashCount()
        })
        $(document).on('change', '#twenty', function() {
            var val = 20
            var pcs = $('#twenty').val()
            var total = val * pcs
            $('#twentytotalamount').text(total === 0 ? '' : formatCurrency(total))

            totalCashCount()
        })
        $(document).on('change', '#ten', function() {
            var val = 10
            var pcs = $('#ten').val()
            var total = val * pcs
            $('#tentotalamount').text(total === 0 ? '' : formatCurrency(total))
            totalCashCount()
        })
        $(document).on('change', '#five', function() {
            var val = 5
            var pcs = $('#five').val()
            var total = val * pcs
            $('#fivetotalamount').text(total === 0 ? '' : formatCurrency(total))
            totalCashCount()
        })
        $(document).on('change', '#one', function() {
            var val = 1
            var pcs = $('#one').val()
            var total = val * pcs
            $('#onetotalamount').text(total === 0 ? '' : formatCurrency(total))
            totalCashCount()
        })
        $(document).on('change', '#centavo', function() {
            var val = .25
            var pcs = $('#centavo').val()
            var total = val * pcs
            $('#centavototalamount').text(total === 0 ? '' : formatCurrency(total))

            totalCashCount()
        })

        function totalCashCount() {
            var totalAmount = 0


            var onethousand = Number($('#onethousandtotalamount').text().replace(/[^0-9\.-]+/g, ""))
            var fivehundred = Number($('#fivehundredtotalamount').text().replace(/[^0-9\.-]+/g, ""))
            var twohundred = Number($('#twohundredtotalamount').text().replace(/[^0-9\.-]+/g, ""))
            var onehundred = Number($('#onehundredtotalamount').text().replace(/[^0-9\.-]+/g, ""))
            var fifty = Number($('#fiftytotalamount').text().replace(/[^0-9\.-]+/g, ""))
            var twenty = Number($('#twentytotalamount').text().replace(/[^0-9\.-]+/g, ""))
            var ten = Number($('#tentotalamount').text().replace(/[^0-9\.-]+/g, ""))
            var five = Number($('#fivetotalamount').text().replace(/[^0-9\.-]+/g, ""))
            var one = Number($('#onetotalamount').text().replace(/[^0-9\.-]+/g, ""))
            var centavo = parseFloat(Number($('#centavototalamount').text().replace(/[^0-9\.-]+/g, "")))
            var total = onethousand + fivehundred + twohundred + onehundred + fifty + twenty + ten + five + one +
                centavo
            $('#totalcashcount').text(formatCurrency(total))
        }

        function amountConverter(amount) {
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 0

            });

            return formatter.format(amount)
        }

        function formatCurrency(amount) {
            amount = parseFloat(amount);
            if (isNaN(amount)) {
                return 0;
            }
            amount = amount.toFixed(2);

            amount = amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            return amount;
        }

        var dtbleOption = {
            dom: 'Bftrip',
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": true,

        }

        // var dtbleOptionJL = {
        //     dom: 'Bftrip',
        //     "info": true,
        //     "paging": true,
        //     "ordering": false,
        //     "filter": true,
        //     "pageLength" : 60
        // }

        // var subsidiaryTbl = $('#subsidiaryledgerTbl').dataTable(dtbleOption);
        var generalLedger = $('#generalLedgerTbl').dataTable(dtbleOption);
        // var journalLedgerTbl = $('#journalLedgerTbl').dataTable(dtbleOptionJL);

        $('#select-account').select2({
            placeholder: 'Account',
            allowClear: true,
        });

        $('form').attr('autocomplete', 'off');

        $(document).on('click', '#printGeneralLedgerExcel', function(e) {
            var from = $('#genLedgerFrom').val();
            var to = $('#genLedgerTo').val();
            var account_name = $('#genLedgerAccountName').val();
            var rtype = $(this).attr('type')

            var path = '/reports/reportPrint?type=' + rtype + '&from=' + from + '&to=' + to +
                '&account_name=' + account_name;
            window.open("{{ url('/') }}" + path, '_blank');
        });
        $(document).on('click', '#subsidiaryPrintExcel', function(e) {
            var rtype = $(this).attr('type')
            var path = '/reports/reportPrint?type=' + rtype;
            window.open("{{ url('/') }}" + path, '_blank');
        });
        $(document).on('click', '#printCharOfAccountExcel', function(e) {
            var rtype = $(this).attr('type')
            var path = '/reports/reportPrint?type=' + rtype;
            window.open("{{ url('/') }}" + path, '_blank');
        });
        $(document).on('click', '.subsid-view-info', function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: "json",
                url: "{{ route('reports.subsidiaryViewInfo') }}",
                data: {
                    id: $(this).attr('value')
                },
                success: function(data) {
                    if (data != false) {
                        $('#sub_id').val(data[0].sub_id);
                        $('#sub_code').val(data[0].sub_code);
                        $('#sub_cat_id').val(data[0].sub_cat_id);
                        $('#sub_name').val(data[0].sub_name);
                        $('#sub_address').val(data[0].sub_address);
                        $('#sub_tel').val(data[0].sub_tel);
                        $('#sub_per_branch').val(data[0].sub_per_branch);
                        $('#sub_date').val(data[0].sub_date);
                        $('#sub_amount').val(data[0].sub_amount);
                    }

                }
            });
        });

        $(document).on('click', '.JnalView', function(e) {
            e.preventDefault();
            var id = $(this).attr('value');
            var statusElement = $(this).closest('tr').find('b'); // Get reference to status element
            var editButton = $(this).closest('tr').find(
                '.JnalEdit'); // Find the edit button within the same row
            var cancelButton = $(this).closest('tr').find(
                '.jnalCancel'); // Find the cancel button within the same row
            var stStatusButton = $(this).closest('tr').find('.stStatus');

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
                    console.log(response);
                    if (response.message == 'fetch') {
                        var total_debit = 0;
                        var total_credit = 0;
                        $('#tbl-create-journalview-container').html('');
                        $('#journalVoucherContent').html('');
                        $('#vjournal_remarks').html('');
                        $.each(response.data, function(k, v) {
                            console.log(v)
                            $('#posted-content').html('');
                            var content = '';
                            $('#vjournal_date, #voucher_date').text(moment(v
                                .journal_date).format('MMMM D, YYYY'));
                            $('#vjournal_book_reference, #voucher_ref_no').text(v
                                .book_details.book_name);
                            $('#vjournal_source, #voucher_source').text(v.source);
                            $('.vjournal_cheque').text((v.cheque_no) ? v.cheque_no :
                                'NO CHEQUE');
                            $('#vjournal_status').text(v.status);
                            $('#vjournal_amount, #voucher_amount').text(parseFloat(v
                                .amount).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }));
                            $('#vjournal_payee, #voucher_pay').text(v.payee);
                            $('.voucher_amount_in_words').text(numberToWords(parseFloat(
                                v.amount)));
                            if (v.remarks) {
                                $.each(v.remarks.split('::'), function(k, vv) {
                                    $('#vjournal_remarks').append(
                                        `<p>${vv}</p>`
                                    );
                                });
                            }
                            $('#voucher_particular').html(v.remarks ? v.remarks.replace(
                                    /::/g,
                                    '<br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;') :
                                '');
                            $('#vjournal_branch, #voucher_branch').text(v.branch
                                .branch_name);
                            $('#voucher_ref_no').text(v.journal_no);
                            $('.vjournal_cheque_date').text((v.cheque_date) ?
                                moment(v.cheque_date).format('MM/DD/YYYY') :
                                'NO CHEQUE');
                            if (v.status == 'unposted') {
                                content =
                                    `<button value="${v.journal_id}"  class="btn btn-flat btn-sm bg-gradient-success stStatus">Post</button>
                                    <button  class="btn btn-flat btn-sm bg-gradient-info stsVoucher">View Journal Voucher</button>`;
                            } else if (v.status == 'cancelled') {
                                content = ``
                            } else {
                                content =
                                    `<button disabled  class="btn btn-flat btn-sm  bg-gradient-gray">Posted</button>
										<button  class="btn btn-flat btn-sm bg-gradient-info stsVoucher">View Journal Voucher</button>`
                            }
                            $('#posted-content').html(content);
                            $.each(v.journal_entry_details, function(kk, vv) {
                                total_debit += parseFloat(vv
                                    .journal_details_debit);
                                total_credit += parseFloat(vv
                                    .journal_details_credit);
                                $('#tbl-create-journalview-container').append(`
								<tr class='editable-table-row'>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.account.account_number}</label></td>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${vv.account.account_name}</label> </td>

									<td class='editable-table-data' value="" >

									</td>
                                    <td class='editable-table-data' value="" >	<label class="label-normal" >${amountConverter(vv.journal_details_debit)}</label> </td>
									<td class='editable-table-data' value="" >	<label class="label-normal" >${amountConverter(vv.journal_details_credit)}</label> </td>
								</tr>
							`);
                                $('#journalVoucherContent').append(`
								<tr>
									<td class="center">${vv.account.account_number}</td>
									<td class="left">${vv.account.account_name}</td>

									<td class="center">${amountConverter(vv.journal_details_debit)}</td>
									<td class="right">${amountConverter(vv.journal_details_credit)}</td>
								</tr>`);
                            })
                            $('#journalVoucherContent').append(`
                                <tr style="border-top:4px dashed black; border-bottom:none">
                                    <td></td>
                                    <td></td>
                                    <td><b>TOTAL</b></td>
                                    <td><strong id="total_debit_voucher"></strong></td>
                                    <td><strong id="total_credit_voucher"></strong></td>
                                </tr>
                            `)
                            $('#vtotal_debit, #total_debit_voucher').text(
                                amountConverter(total_debit))
                            $('#vtotal_credit, #total_credit_voucher').text(
                                amountConverter(total_credit))
                            $('#vbalance_debit').text(amountConverter(
                                parseFloat(((parseFloat(total_debit.toFixed(
                                    2)) - parseFloat(total_credit
                                    .toFixed(2))).toFixed(2)))
                            ))
                        });
                    }
                    $('#journalModalView').modal('show')
                },
                error: function() {
                    console.log("Error");
                }
            });
            $('#journalModalView').on('hidden.bs.modal', function(e) {
                // Update status immediately after closing modal
                if (statusElement) {
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
                                // Update status element in the main table
                                if (response.data[0].status === 'posted') {
                                    statusElement.html('<b>Posted</b>');
                                    statusElement.removeClass('text-danger').addClass(
                                        'text-success');
                                    stStatusButton.text(
                                        'Unpost'
                                    ); // Change the text content of the clicked button
                                    stStatusButton.removeClass('bg-gradient-success')
                                        .addClass(
                                            'bg-gradient-danger'
                                        ); // Change button background color
                                    //editButton.prop('disabled',true); // Disable the edit button
                                    cancelButton.prop('disabled',
                                        false); // Enable the cancel button
                                }
                            }
                        },
                        error: function() {
                            console.log("Error");
                        }
                    });
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
                        var data = response.data[0]
                        $('#journalEntryBookId').val(data.book_id);
                    }
                },
                error: function() {
                    console.log("Error");
                }
            });
        })

        var customDTable = {
            dom: 'Bftrip',
            "info": false,
            "paging": false,
            "ordering": false,
            "searching": true, // Changed from "filter": false to enable search
            "language": {
                "search": "Search:",
            },
        }

        var subsidiaryldgrTbl = $('#subsidiaryledgerTbl').dataTable(customDTable);

        // Convert to API instance for easier manipulation
        var subsidiaryTblAPI = subsidiaryldgrTbl.api();

        // Custom global search function (if you want to trigger search programmatically)
        function customSearch(searchTerm) {
            subsidiaryTblAPI.search(searchTerm).draw();
        }

        // Clear search function
        function clearSearch() {
            subsidiaryTblAPI.search('').draw();
        }

        $(document).on('submit', '#subsidiaryForm', function(e) {
            e.preventDefault();
            const subId = $('[name="sub_id"]').val();
            
            const url = subId ? 
                "{{ route('subsidiary.update', ':id') }}".replace(':id', subId) : 
                "{{ route('subsidiary.store') }}";
            
            let formData = $(this).serialize();
            
            $.ajax({
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: "json",
                url: url,
                data: formData,
                success: function(data) {
                    const subAmount = parseFloat($('#sub_amount').val() || 0);
                    const formattedAmount = `₱${subAmount.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    
                    if (data.message === 'Successfully created.') {
                        subsidiaryTblAPI.row.add([
                            $('#sub_code').val(),
                            $('#sub_name').val(),
                            $('#sub_address').val(),
                            $('#sub_tel').val(),
                            $('#sub_per_branch option:selected').text(),
                            '',
                            formattedAmount,
                            `<div class="btn-group">
                                <button type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a class="dropdown-item btn-edit-account subsid-edit" data-value="${data.data.sub_id}" href="#"  @click="show" style="transition: background-color 0.2s;">Edit</a>
                                    <a class="dropdown-item btn-edit-account subsid-delete" value="${data.data.sub_id}" href="#" style="transition: background-color 0.2s;">Delete</a>
                                </div>
                            </div>`
                        ]).draw(false);
                        toastr.success('Successfully Added');
                    }
                    else if (data.message === 'Successfully updated.') {
                        const subId = data.data.sub_id;
                        
                        // Find the row by the subsid-delete element with the matching value
                        const rowIndex = subsidiaryTblAPI.rows().indexes().filter(function(idx) {
                            const rowNode = subsidiaryTblAPI.row(idx).node();
                            return $(rowNode).find('a.subsid-delete[value="' + subId + '"]').length > 0;
                        });
                        
                        if (rowIndex.length > 0) {
                            // Update the row with new values
                            subsidiaryTblAPI.row(rowIndex[0]).data([
                                $('#sub_code').val(),
                                $('#sub_name').val(),
                                $('#sub_address').val(),
                                $('#sub_tel').val(),
                                $('#sub_per_branch option:selected').text(),
                                '',
                                formattedAmount,
                                subsidiaryTblAPI.row(rowIndex[0]).data()[7] // Keep the existing actions column
                            ]).draw(false);
                        }
                        
                        toastr.success('Successfully Updated');
                    }
                    if (window.app && typeof window.app.resetForm === 'function') {
                        window.app.resetForm();
                    }
                    $('#subsidiaryForm').trigger('reset');
                    $('[name="sub_id"]').val('');
                },
                error: function(xhr, status, error) {
                    // Handle validation errors (422 status code)
                    if (xhr.status === 422) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            
                            // Show toastr notification for duplicate sub_code or other validation errors
                            if (response.message) {
                                toastr.error(response.message);
                            } else if (response.errors) {
                                // If there are specific field errors, show the first one
                                const firstError = Object.values(response.errors)[0][0];
                                toastr.error(firstError);
                            } else {
                                toastr.error('Validation error occurred');
                            }
                        } catch (parseError) {
                            console.error('Error parsing response:', parseError);
                            toastr.error('An error occurred while processing the request');
                        }
                    } 
                    // Handle server errors (500 status code)
                    else if (xhr.status === 500) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            toastr.error(response.message || 'Server error occurred');
                        } catch (parseError) {
                            toastr.error('Server error occurred');
                        }
                    }
                    // Handle other errors
                    else {
                        toastr.error('An unexpected error occurred: ' + error);
                    }
                }
            });
        });

        let selectedSubsidiaryId = null;

        $(document).on('click', '.subsid-edit', function (event) {
            event.preventDefault();
            selectedSubsidiaryId = $(this).data('value');

            const fakeEvent = {
                target: {
                    dataset: {
                        value: selectedSubsidiaryId
                    }
                }
            };

            if (window.app && typeof window.app.show === 'function') {
                window.app.show(fakeEvent);
            }
            setTimeout(() => {
                const formElement = $('#subsidiaryForm'); // ← fix here
                if (formElement.length) {
                    $('html, body').animate({
                        scrollTop: formElement.offset().top
                    }, 500);
                } else {
                    console.warn('Scroll target not found.');
                }
            }, 100);
        });

        $(document).on('click', '.subsid-delete', function(e) {
            e.preventDefault();
            selectedSubsidiaryId = $(this).attr('value'); // store ID for later
            $('#deleteSubsidiaryModal').modal('show'); // show modal
        });

        $('#confirmDeleteSubsidiary').on('click', function() {
            if (!selectedSubsidiaryId) return;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "{{ route('reports.subsidiaryDelete') }}",
                data: { id: selectedSubsidiaryId },
                dataType: "json",
                success: function(data) {
                    if (data.message === 'delete') {
                        toastr.success('Successfully Removed');
                        // Remove row manually
                        subsidiaryTblAPI
                            .row($(`a.subsid-delete[value="${selectedSubsidiaryId}"]`).closest('tr'))
                            .remove()
                            .draw(false);
                    }
                },
                error: function() {
                    console.error("Error deleting subsidiary.");
                },
                complete: function() {
                    $('#deleteSubsidiaryModal').modal('hide');
                    selectedSubsidiaryId = null;
                }
            });
        });




        function formatAmount(amount) {
            let number = Number(amount)
            let formattedNumber = number.toLocaleString("en-US", {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            return formattedNumber
        }


        // $(document).on('change', '#genLedgerAccountName', function(e){
        //           e.preventDefault()
        // 	var id = $(this).val();
        // 	var from = $('#genLedgerFrom').val();
        // 	var to = $('#genLedgerTo').val();
        // 	$.ajax({
        // 		headers: {
        // 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // 		},
        // 		type: "POST",
        // 		url: "{{ route('reports.generalLedgerFetchAccount') }}",
        // 		data:{id:id,from:from,to:to},
        // 		dataType: "json",
        // 		success: function(data) {
        //                   console.log(data)
        // 			generalLedger.fnClearTable();
        // 			generalLedger.fnDestroy();

        // 			if(data)
        // 			{
        // 				var vvid = '';
        // 				var tempContainer = '';
        // 				var container = '';
        //                       let balance = 0
        //                       let total_debits = 0,total_credits = 0
        // 				$.each(data, function(k,v){

        // 					if(vvid == ''){

        //                               balance = v.opening_balance

        // 						container += `<tr>
        //                                       <td  class="font-weight-bold">${v.account_number} - ${v.account_name}</td>
        // 								<td></td>
        // 								<td></td>
        // 								<td></td>
        // 								<td></td>
        // 								<td></td>
        // 								<td></td>
        // 								<td class="balance">${formatAmount(v.opening_balance)}</td>

        // 							</tr>`;
        // 						vvid = v.account_id;
        // 					}else if(vvid != v.account_id){

        // 							container += `
        //                                   <tr>
        //                                       <td></td>
        //                                       <td></td>
        //                                       <td></td>
        //                                       <td></td>
        //                                       <td></td>
        //                                       <td>${formatAmount(total_debits)}</td>
        //                                       <td>${formatAmount(total_credits)}</td>
        //                                       <td></td>
        //                                   </tr>
        //                                   <tr>
        //                                       <td  class="font-weight-bold">${v.account_number} - ${v.account_name}</td>
        // 								<td></td>
        // 								<td></td>
        // 								<td></td>
        // 								<td></td>
        // 								<td></td>
        // 								<td></td>
        // 								<td class="balance">${formatAmount(v.opening_balance)}</td>
        // 							</tr>
        //                                  `;
        //                                  total_credits =0
        //                                  total_debits = 0
        // 						vvid = v.account_id;
        // 						}
        //                               balance+=Number(v.journal_details_debit)
        //                               balance-=Number(v.journal_details_credit)
        //                               total_debits+=Number(v.journal_details_debit)
        //                               total_credits+=Number(v.journal_details_credit)

        // 					container +=
        // 						`<tr>
        // 							<td>${v.journal_date}</td>
        // 							<td>${v.sub_name}</td>
        // 							<td>${v.source}</td>
        // 							<td>${(v.cheque_date == '') ? '/' : v.cheque_date}</td>
        // 							<td>${(v.cheque_no == '') ? '/' : v.cheque_no}</td>
        // 							<td>${formatAmount(v.journal_details_debit)}</td>
        // 							<td>${formatAmount(v.journal_details_credit)}</td>
        // 							<td class="journal_balance">${formatAmount(balance)}</td>
        // 						</tr>`


        // 				});
        //                       container += `<tr>
        //                                       <td></td>
        //                                       <td></td>
        //                                       <td></td>
        //                                       <td></td>
        //                                       <td></td>
        //                                       <td>${formatAmount(total_debits)}</td>
        //                                       <td>${formatAmount(total_credits)}</td>
        //                                       <td></td>
        //                                   </tr>`


        // 				$('#generalLedgerTblContainer').html(container)
        // 			}
        // 			generalLedger = $('#generalLedgerTbl').dataTable(dtbleOption);
        // 		},
        // 		error: function() {
        // 			console.log("Error");
        // 		}
        // 	});
        // });
    })(jQuery);


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






    function reload() {
        window.setTimeout(() => {
            location.reload();
        }, 500);
    }

    function fetchCashBlotter() {
        $('#cash-blotter-tbl').dataTable({
            processing: true,
            searching: true,
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            ajax: {
                url: "<?= config('app.url') ?>/reports/cashTransactionBlotter",
            },
            columns: [{
                    data: "branch_code"
                },
                {
                    data: "branch_name"
                },
                {
                    data: "transaction_date"
                },

                {
                    data: "total_collection",
                    className: 'text-left',
                    render: $.fn.dataTable.render.number(',', '.', 2, '₱')
                },
                {
                    data: null,
                    render: function(data, row, type) {
                        var cashblotter_id = data.cashblotter_id
                        var editCashBlotterUrl = "{{ route('reports.showCashBlotter', ':id') }}";
                        editCashBlotterUrl = editCashBlotterUrl.replace(':id', cashblotter_id);
                        var showCashBlotterUrl = "{{ route('reports.showCashBlotter', ':id') }}";
                        showCashBlotterUrl = showCashBlotterUrl.replace(':id', cashblotter_id);
                        var action;
                        /* '<button class="mr-1 btn btn-xs btn-warning"><i class="fas fa-xs fa-edit edit-cashblotter" data-title="Cash Transaction Blotter (Edit)" data-remote="'+editCashBlotterUrl+'"></i></button>'+ */
                        // return '<button class="mr-1 btn btn-xs btn-success"><i class="fas fa-xs fa-eye view-cashblotter" data-title="Cash Transaction Blotter (Preview)" data-remote="'+showCashBlotterUrl+'"></i></button>'+
                        // '<button class="mr-1 btn btn-xs btn-warning" id="update-cashblotter" data-id="'+data.cashblotter_id+'"><i class="fas fa-xs fa-edit"></i></button>'+
                        // '<button class="mr-1 btn btn-xs btn-danger"><i class="fas fa-xs fa-trash delete-cashblotter"></i></button>'+
                        // '<button class="mr-1 btn btn-xs btn-primary"><i class="fas fa-xs fa-download download-cashblotter"></i></button>'+
                        // '<button class="mr-1 btn btn-xs btn-default"><i class="fas fa-xs fa-print print-cashblotter"></i></button>'
                        return '<button class="mr-1 btn btn-xs btn-success"><i class="fas fa-xs fa-eye" data-toggle="modal" data-target="#cashBlotterPreviewModal"></i></button>' +
                            '<button class="mr-1 btn btn-xs btn-warning" id="update-cashblotter" data-id="' +
                            data.cashblotter_id + '"><i class="fas fa-xs fa-edit"></i></button>' +
                            '<button class="mr-1 btn btn-xs btn-danger"><i class="fas fa-xs fa-trash delete-cashblotter"></i></button>' +
                            '<button class="mr-1 btn btn-xs btn-primary"><i class="fas fa-xs fa-download download-cashblotter"></i></button>' +
                            '<button class="mr-1 btn btn-xs btn-default"><i class="fas fa-xs fa-print print-cashblotter"></i></button>'
                    }
                }
            ]
        })
    }

    // Select for JournalLedger

    $('#select-jl-bybook').select2({
        placeholder: 'Select Book',
        allowClear: true,
    });

    $('#jlBranch').select2({
        placeholder: 'Select Branch',
        allowClear: true,
    });
    $('#jlStatus').select2({
        placeholder: 'Select Status',
        allowClear: true,
    });

    $(document).ready(function() {
        const hasJournalForm = $('#bookJournalForm').length > 0;
        const hasVueApp = window.app && window.app.filter;

        if (hasJournalForm && hasVueApp) {
            // Access the Vue instance
            const vueApp = window.app; // Assuming your Vue instance is assigned to window.app

            // Set initial values from Vue model to select2
            if (vueApp.filter.book_id) {
                $('#select-jl-bybook').val(vueApp.filter.book_id).trigger('change');
            }
            if (vueApp.filter.branch_id) {
                $('#jlBranch').val(vueApp.filter.branch_id).trigger('change');
            }
            if (vueApp.filter.status) {
                $('#jlStatus').val(vueApp.filter.status).trigger('change');
            }

            // Add change event listeners to update Vue model when select2 changes
            $('#select-jl-bybook').on('select2:select', function(e) {
                vueApp.filter.book_id = $(this).val();
            });

            $('#jlBranch').on('select2:select', function(e) {
                vueApp.filter.branch_id = $(this).val();
            });

            $('#jlStatus').on('select2:select', function(e) {
                vueApp.filter.status = $(this).val();
            });

            // Also handle clear events
            $('#select-jl-bybook, #jlBranch, #jlStatus').on('select2:clear', function(e) {
                const id = $(this).attr('id');
                if (id === 'select-jl-bybook') {
                    vueApp.filter.book_id = '';
                } else if (id === 'jlBranch') {
                    vueApp.filter.branch_id = '';
                } else if (id === 'jlStatus') {
                    vueApp.filter.status = '';
                }
            });
        }
    });

    // $('.select-jl-branch').select2({
    //     placeholder: 'Select Branch',
    //     allowClear: true,
    // });

    // $('.select-jl-status').select2({
    //     placeholder: 'Select Status',
    //     allowClear: true,
    // });
</script>
