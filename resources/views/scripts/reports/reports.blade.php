<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript">
	(function ($) {

        var cashblotter_tbl
        fetchCashBlotter()


        $('#total').insertAfter('#journal tr:first');


        var editCashblotterFlyOut = new GlobalWidget();
        var showCashblotterFlyOut = new GlobalWidget();



        $('#create-cashblotter').click(function(){
            $('#Mymodal').modal('show')
            reset()
            $('#title').text("Cash Transaction Blotter (New)")
        });

     /*
     **********************  EDIT CASH BLOTTER **************************
    */

    $(document).on('click', '#update-cashblotter', function(e){
        e.preventDefault();
        $('#Mymodal').modal('show')
        reset()
        $('#title').text("Cash Transaction Blotter (Edit)")

        var cashblotter_id = $(this).attr('data-id')
        $.ajax({
            type: "GET",
            url: "cashTransactionBlotter/editcashblotter/"+cashblotter_id,
            dataType: "json",
            success: function (response) {
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
        $('.cash-breakdown').each(function(index, row){

        let cells = $(row).find('td');
        let val = cells.eq(0).text();
        let pcs = $(row).find('input[type=number]').val()
        var total_amount = cells.eq(2).text()
        let total = val*pcs
        cells.eq(2).text(amountConverter(total))
        totalCashCount()


    });


    }

    /*
     **********************  VIEW CASH BLOTTER **************************
    */

    $(document).on('click', '.view-cashblotter', function(e){
        e.preventDefault();


        let target = $(this);
        let title = target.data('title');
        let route = target.data('remote');

        showCashblotterFlyOut.setTitle(title)
                    .setRoute(route)
                    .setCallback( function(){
                        $('.select2').select2({
                            placeholder: 'Select',
                            allowClear: true,
                        })
                    }).init();
    })

    /*
     **********************  DELETE CASH BLOTTER **************************
    */

    $(document).on('click', '.delete-cashblotter', function(e){
        e.preventDefault();
        alert("delete cash blotter")

        aja



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
    $(document).on('click', '.download-cashblotter', function(e){
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

    $(document).on('click', '.print-cashblotter', function(e){
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

    $(document).on('change','#select_branch',function(){
        var branch_id   =   $(this).val()
        $('.select-officer').find('option').remove()
        $('.select-officer').append('<option value="" disabled selected text="Select-Officer">')
        $.ajax({
            type: "get",
            url: "{{route('reports.fetchAccountOfficer',['id' => 'branch_id'])}}".replace('branch_id', branch_id),
            dataType: "json",
            success: function (response) {
                var data = response.data
                $.each(data,function(i,item){
                    $('.select-officer ').append($('<option>',{
                        value:item.accountofficer_id,
                        text:item.name
                    }))
                })
            }
        });

    })


    $(document).on('submit','#add-cash-blotter',function(e){
        e.preventDefault()

        var form = $(this);
        var formData = form.serializeArray();
        var totalcash_count = Number($('#totalcashcount').text().replace(/[^0-9\.-]+/g,""))
        var aocollection_items = []
        var branchcollection_items = []
        aocollection_items = addAoCollection()
        branchcollection_items = addBranchCollection()


        if(!aocollection_items) {
            alert("Please add account officer collection")
            return false
        }

        formData.push({name:'total',value:totalcash_count})
        formData.push({name:'collection_ao',value:aocollection_items})
        formData.push({name:'branch_collection',value:JSON.stringify(branchcollection_items)})
		var fdata = {};
		for(var i in formData){
			var fd = formData[i];
			fdata[fd.name] = fd.value;
		}
        $.ajax({
				type:'POST',
				dataType: "json",
				url:"{{route('create.collection.breakdown')}}",
				data:fdata,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				success:function(data) {
                    toastr.success(data.message);
                    $('#create-cashblotter-modal').modal('hide');
                    $('#cash-blotter-tbl').DataTable().ajax.reload();
                    $('#Mymodal').modal('hide')
                    reset()
                },
                error:function(data){
                    console.log(data)
                }
            })

    })

    function reset() {
        $('#add-cash-blotter')[0].reset()
        $('.aocollection-items').remove()
        $('.branchcollection-items').remove()
        $('#totalbranchcollection').text(0)
        $('#totalaccountofficercollection').text(0)
        $('#totalcashcount').text(0)
        $('.cash-breakdown').each(function(index, row){
            let cells = $(row).find('td')
            cells.eq(2).text(0)
        })

    }



    function addAoCollection() {
        var items = [];

        $('.aocollection-items').each(function(index, row){

        let cells = $(row).find('td');
        let accountofficer_id = cells.eq(0).val();
        let remarks = cells.eq(1).text();
        let totalamount = Number(cells.eq(2).text().replace(/[^0-9\.-]+/g,""))

        /* let aocollection_totalamount = Number(cells.eq(3).text().replace(/[^0-9\.-]+/g,"")); */

        items.push(
            {
            'representative' : accountofficer_id,
            'note' : remarks,
            'total':totalamount,
			'grp':'collection officer'
            }
        );

        });

        if( items.length ) {
            return items
        }
        return false;
    }
    function addBranchCollection() {
        var items = [];

        $('.branchcollection-items').each(function(index, row){

        let cells = $(row).find('td');
        let branch_id = cells.eq(0).data('id');
        let totalamount = Number(cells.eq(1).text().replace(/[^0-9\.-]+/g,""))

        /* let aocollection_totalamount = Number(cells.eq(3).text().replace(/[^0-9\.-]+/g,"")); */

        items.push(
            {
            'branch_id' : branch_id,
            'totalamount':totalamount
            }
        );

        });

        if( items.length ) {
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


    /*
     **********************  CASH BRANCH COLLECTION  **************************
    */

    $(document).on('click', '#btn-add-branch-collection', function(e){

        var branchcollection_amount = amountConverter($('#branchcollection_amount').val())
        var branch_id = $('#branch_id').val();
        if(branchcollection_amount == "" || branch_id == null) {
            alert("All fields are required")
        }else {
            var branch_name =  $('.select-branch option:selected').text();
            var markup = `
                <tr class="branchcollection-items">
                <td data-id="${branch_id}" >${branch_name}</td>
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
            $('#branch_id').val(null).trigger("change")

        }

    })




    /*
     **********************  CASH ACCOUNT OFFICER COLLECTION  **************************
    */

    $(document).on('click', '#btn-add-account-officer-collection', function(e){
        var remarks = $('#remarks').val();
        var total_amount = amountConverter($('#total_amount').val());
        var accountofficer_id = $('#accountofficer_id').val();
        if(remarks == "" || total_amount == "" || accountofficer_id == null) {
            alert("All fields are required")
        }else {
            var name =  $('.select-officer option:selected').text();
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
    $(document).on('click', '.remove-account-officer-collection', function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
        calculateAmount("aocollection");
    });
    function calculateAmount(type) {
        var amount = 0;
        totalAmount = 0;
        if(type == "aocollection") {
            $('.aocollection-items').each(function(index, row){
                var tr = $(this)

                var totalCollection = tr.find('td:eq(2)').text().trim() != "" ? Number(tr.find('td:eq(2)').text().replace(/[^0-9\.-]+/g,"")) : 0;

            totalAmount += totalCollection;
            if( isNaN(totalCollection) ) {
                return false;
            }

            });
            console.log(amountConverter(totalAmount))


            $('#totalaccountofficercollection').html(amountConverter(totalAmount));
        }else {
            $('.branchcollection-items').each(function(index, row){
                var tr = $(this)
                var totalCollection = tr.find('td:eq(1)').text().trim() != "" ? Number(tr.find('td:eq(1)').text().replace(/[^0-9\.-]+/g,"")) : 0;

            totalAmount += totalCollection;
            if( isNaN(totalCollection) ) {
                return false;
            }

            });
            $('#totalbranchcollection').html(amountConverter(totalAmount));
        }



    }




    /*
     **********************  CASH BREAKDOWN  **************************
    */

        $(document).on('change','#onethousand',function(){
            var val = 1000
            var pcs = $('#onethousand').val()
            $('#onethousandtotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#fivehundred',function(){
            var val = 500
            var pcs = $('#fivehundred').val()
            $('#fivehundredtotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#twohundred',function(){
            var val = 200
            var pcs = $('#twohundred').val()
            $('#twohundredtotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#onehundred',function(){
            var val = 100
            var pcs = $('#onehundred').val()
            $('#onehundredtotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#fifty',function(){
            var val = 50
            var pcs = $('#fifty').val()
            $('#fiftytotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#twenty',function(){
            var val = 20
            var pcs = $('#twenty').val()
            $('#twentytotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#ten',function(){
            var val = 10
            var pcs = $('#ten').val()
            $('#tentotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#five',function(){
            var val = 5
            var pcs = $('#five').val()
            $('#fivetotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#one',function(){
            var val = 1
            var pcs = $('#one').val()
            $('#onetotalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })
        $(document).on('change','#centavo',function(){
            var val = .25
            var pcs = $('#centavo').val()
            $('#centavototalamount').text(amountConverter(val*pcs))
            totalCashCount()
        })

        function totalCashCount() {
            var totalAmount = 0


            var onethousand = Number($('#onethousandtotalamount').text().replace(/[^0-9\.-]+/g,""))
            var fivehundred = Number($('#fivehundredtotalamount').text().replace(/[^0-9\.-]+/g,""))
            var twohundred = Number($('#twohundredtotalamount').text().replace(/[^0-9\.-]+/g,""))
            var onehundred = Number($('#onehundredtotalamount').text().replace(/[^0-9\.-]+/g,""))
            var fifty = Number($('#fiftytotalamount').text().replace(/[^0-9\.-]+/g,""))
            var twenty = Number($('#twentytotalamount').text().replace(/[^0-9\.-]+/g,""))
            var ten = Number($('#tentotalamount').text().replace(/[^0-9\.-]+/g,""))
            var five = Number($('#fivetotalamount').text().replace(/[^0-9\.-]+/g,""))
            var one = Number($('#onetotalamount').text().replace(/[^0-9\.-]+/g,""))
            var centavo = parseFloat(Number($('#centavototalamount').text().replace(/[^0-9\.-]+/g,"")))
            var total = onethousand+fivehundred+twohundred+onehundred+fifty+twenty+ten+five+one+centavo
            $('#totalcashcount').text(amountConverter(total))
        }

        function amountConverter(amount) {
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',

            });

            return formatter.format(amount)
        }

		var dtbleOption = {
			dom: 'Bftrip',
			"info": false,
			"paging": false,
			"ordering": false,
			"filter": false,

		}
		var subsidiaryTbl = $('#subsidiaryledgerTbl').dataTable(dtbleOption);
		var generalLedger = $('#generalLedgerTbl').dataTable(dtbleOption);
		// var journalLedgerTbl = $('#journalLedgerTbl').dataTable(dtbleOption);

		$('form').attr('autocomplete','off');

		$(document).on('click','#printGeneralLedgerExcel',function(e){
			var from = $('#genLedgerFrom').val();
			var to = $('#genLedgerTo').val();
			var account_name = $('#genLedgerAccountName').val();
			var rtype = $(this).attr('type')

			var path = '/reports/reportPrint?type='+rtype+'&from='+from+'&to='+to+'&account_name='+account_name;
			window.open("{{ url('/') }}"+path, '_blank');
		});
		$(document).on('click','#subsidiaryPrintExcel',function(e){
			var rtype = $(this).attr('type')
			var path = '/reports/reportPrint?type='+rtype;
			window.open("{{ url('/') }}"+path, '_blank');
		});
		$(document).on('click','#printCharOfAccountExcel',function(e){
			var rtype = $(this).attr('type')
			var path = '/reports/reportPrint?type='+rtype;
			window.open("{{ url('/') }}"+path, '_blank');
		});
		$(document).on('click','.subsid-view-info',function(e){
			e.preventDefault();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type:'GET',
				dataType: "json",
				url:"{{route('reports.subsidiaryViewInfo')}}",
				data:{id:$(this).attr('value')},
				success:function(data) {
					if(data != false)
					{
						$('#sub_id').val(data[0].sub_id);
						$('#sub_acct_no').val(data[0].sub_acct_no);
						$('#sub_cat_id').val(data[0].sub_cat_id);
						$('#sub_name').val(data[0].sub_name);
						$('#sub_address').val(data[0].sub_address);
						$('#sub_tel').val(data[0].sub_tel);
						$('#sub_per_branch').val(data[0].sub_per_branch);
						$('#sub_date').val(data[0].sub_date);
						$('#sub_amount').val(data[0].sub_amount);
						$('#sub_no_amort').val(data[0].sub_no_amort);
						$('#sub_life_used').val(data[0].sub_life_used);
						$('#sub_salvage').val(data[0].sub_salvage);
						$('#sub_date_post').val(data[0].sub_date_post);
					}
				}
			});
		});
		$(document).on('click','.subsid-delete',function(e){
			e.preventDefault();
			var id = $(this).attr('value');
			if (confirm("Are You Sure want to delete this Subsidiary ?")) {
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: "GET",
					url: "{{route('reports.subsidiaryDelete')}}",
					data:{id:id},
					dataType: "json",
					success: function(data) {
						if(data.message == 'delete'){
							toastr.success('Subsidiary Successfully Remove');
							subsidiaryTbl.row($("a[value ='"+id+"']").parents('tr'))
							.remove().draw();
						}
					},
					error: function() {
						console.log("Error");
					}
				});
			}
		});
		$(document).on('submit','#subsidiaryForm',function(e){
			e.preventDefault();
			var dataSerialize = $(this).serialize();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type:'POST',
				dataType: "json",
				url:"{{route('reports.subsidiarySaveorEdit')}}",
				data:dataSerialize,
				success:function(data) {
					if(data.message === 'save'){
						toastr.success('Successfully Create');
					}else if(data.message === 'update'){
						subsidiaryTbl.row($("a[value ='"+data.sub_id+"']").parents('tr'))
							.remove().draw();
						toastr.success('Successfully Update');
					}
					if(data.message == 'save' || data.message == 'update')
					{
						subsidiaryTbl.row.add([
							$('#sub_acct_no').val(),
							$('#sub_name').val(),
							$('#sub_address').val(),
							$('#sub_tel').val(),
							$('#sub_per_branch').val(),
							$('#sub_date').val(),
							$('#sub_amount').val(),
							$('#sub_no_amort').val(),
							$('#sub_life_used').val(),
							$('#sub_salvage').val(),
							$('#sub_date_post').val(),
							`<div class="btn-group">
								<button type="button" class="btn btn-xs btn-default btn-flat coa-action">Action</button>
								<a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</a>
								<div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
									<a class="dropdown-item btn-edit-account subsid-view-info" value="${data.sub_id}" href="#">Edit</a>
									<a class="dropdown-item btn-edit-account subsid-delete" value="${data.sub_id}" href="#">delete</a>
								</div>
							</div>`
						]).draw().node();
						$('#subsidiaryForm')[0].reset();
					}
				}
			});
		});






        function formatAmount(amount) {
                let number = Number(amount)
                let formattedNumber = number.toLocaleString("en-US", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                return formattedNumber
        }


		$(document).on('change', '#genLedgerAccountName', function(e){
            e.preventDefault()
			var id = $(this).val();
			var from = $('#genLedgerFrom').val();
			var to = $('#genLedgerTo').val();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "POST",
				url: "{{route('reports.generalLedgerFetchAccount')}}",
				data:{id:id,from:from,to:to},
				dataType: "json",
				success: function(data) {
                    console.log(data)
					generalLedger.fnClearTable();
					generalLedger.fnDestroy();

					if(data)
					{
						var vvid = '';
						var tempContainer = '';
						var container = '';
                        let balance = 0
                        let total_debits = 0,total_credits = 0
						$.each(data, function(k,v){

							if(vvid == ''){

                                balance = v.opening_balance

								container += `<tr>
                                        <td  class="font-weight-bold">${v.account_number} - ${v.account_name}</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="balance">${formatAmount(v.opening_balance)}</td>

									</tr>`;
								vvid = v.account_id;
							}else if(vvid != v.account_id){

									container += `
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>${formatAmount(total_debits)}</td>
                                        <td>${formatAmount(total_credits)}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td  class="font-weight-bold">${v.account_number} - ${v.account_name}</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="balance">${formatAmount(v.opening_balance)}</td>
									</tr>
                                   `;
                                   total_credits =0
                                   total_debits = 0
								vvid = v.account_id;
								}
                                balance+=Number(v.journal_details_debit)
                                balance-=Number(v.journal_details_credit)
                                total_debits+=Number(v.journal_details_debit)
                                total_credits+=Number(v.journal_details_credit)

							container +=
								`<tr>
									<td>${v.journal_date}</td>
									<td>${v.sub_name}</td>
									<td>${v.source}</td>
									<td>${(v.cheque_date == '') ? '/' : v.cheque_date}</td>
									<td>${(v.cheque_no == '') ? '/' : v.cheque_no}</td>
									<td>${formatAmount(v.journal_details_debit)}</td>
									<td>${formatAmount(v.journal_details_credit)}</td>
									<td class="journal_balance">${formatAmount(balance)}</td>
								</tr>`


						});
                        container += `<tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>${formatAmount(total_debits)}</td>
                                        <td>${formatAmount(total_credits)}</td>
                                        <td></td>
                                    </tr>`


						$('#generalLedgerTblContainer').html(container)
					}
					generalLedger = $('#generalLedgerTbl').dataTable(dtbleOption);
				},
				error: function() {
					console.log("Error");
				}
			});
		});
	})(jQuery);








	function reload()
	{
		window.setTimeout(() => {
			location.reload();
		}, 500);
	}
    function fetchCashBlotter() {
        $('#cash-blotter-tbl').dataTable({
            processing: true,
            searching: true,
            type:"GET",
            ajax:{
                url:"<?= config('app.url') ?>/reports/cashTransactionBlotter",
/* 				url:"{{route('reports.cashblotter')}}", */
            },
            columns:[
                {data:"branch_code"},
                {data:"branch_name"},
                {data:"transaction_date"},

                {data:"total_collection",
                    className: 'text-left',
                    render: $.fn.dataTable.render.number( ',', '.', 2 ,'₱')
                },
                {data:null,
                    render:function(data,row,type){
                        var cashblotter_id = data.cashblotter_id
                        var editCashBlotterUrl = "{{ route('reports.editCashBlotter',':id') }}";
                        editCashBlotterUrl = editCashBlotterUrl.replace(':id', cashblotter_id);
                        var showCashBlotterUrl = "{{ route('reports.showCashBlotter',':id') }}";
                        showCashBlotterUrl = showCashBlotterUrl.replace(':id', cashblotter_id);
                        var action;
                        /* '<button class="mr-1 btn btn-xs btn-warning"><i class="fas fa-xs fa-edit edit-cashblotter" data-title="Cash Transaction Blotter (Edit)" data-remote="'+editCashBlotterUrl+'"></i></button>'+ */
                        // return '<button class="mr-1 btn btn-xs btn-success"><i class="fas fa-xs fa-eye view-cashblotter" data-title="Cash Transaction Blotter (Preview)" data-remote="'+showCashBlotterUrl+'"></i></button>'+
                        // '<button class="mr-1 btn btn-xs btn-warning" id="update-cashblotter" data-id="'+data.cashblotter_id+'"><i class="fas fa-xs fa-edit"></i></button>'+
                        // '<button class="mr-1 btn btn-xs btn-danger"><i class="fas fa-xs fa-trash delete-cashblotter"></i></button>'+
                        // '<button class="mr-1 btn btn-xs btn-primary"><i class="fas fa-xs fa-download download-cashblotter"></i></button>'+
                        // '<button class="mr-1 btn btn-xs btn-default"><i class="fas fa-xs fa-print print-cashblotter"></i></button>'
						return '<button class="mr-1 btn btn-xs btn-success"><i class="fas fa-xs fa-eye" data-toggle="modal" data-target="#cashBlotterPreviewModal"></i></button>'+
                        '<button class="mr-1 btn btn-xs btn-warning" id="update-cashblotter" data-id="'+data.cashblotter_id+'"><i class="fas fa-xs fa-edit"></i></button>'+
                        '<button class="mr-1 btn btn-xs btn-danger"><i class="fas fa-xs fa-trash delete-cashblotter"></i></button>'+
                        '<button class="mr-1 btn btn-xs btn-primary"><i class="fas fa-xs fa-download download-cashblotter"></i></button>'+
                        '<button class="mr-1 btn btn-xs btn-default"><i class="fas fa-xs fa-print print-cashblotter"></i></button>'
                    }
                }
            ]
        })
    }

	// Select for JournalLedger

	// $('.select-jl-bybook').select2({
    //     placeholder: 'By Book',
    //     allowClear: true,
    // });

	// $('.select-jl-account-title').select2({
    //     placeholder: 'Select Account Title',
    //     allowClear: true,
    // });
	// $('.select-jl-subsidiary').select2({
    //     placeholder: 'Select Subsidiary',
    //     allowClear: true,
    // });

	// $('.select-jl-branch').select2({
    //     placeholder: 'Select Branch',
    //     allowClear: true,
    // });

	// $('.select-jl-status').select2({
    //     placeholder: 'Select Status',
    //     allowClear: true,
    // });
</script>
