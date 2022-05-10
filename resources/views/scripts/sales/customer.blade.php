<script type="text/javascript">
(function ($) {
  'use strict'

	var config = {
		processing: true,
		// serverSide: true,
		autoWidth: false,
		bLengthChange: false,
		oLanguage: {
		"sSearch": "<i>Filter</i> : "
		},
		dom:"<'row'<'col-sm-6 col-md-6'f><'col-sm-6 col-md-6 text-left'B>>",
		ajax: {
		    url: "{{ route('customer.populate') }}",
			dataSrc:""
		},
		columns: [
		  { data: "displayname" },
		  { data: "phone_number" },
		  { data: "open_balance",
		  	className: 'text-right',
		  },
		],
		columnDefs: [
			{
			  className: 'text-right',
			  render: function (data, type, full, meta) {
			  		
			  		var remoteUrl = "{{ route('payment.customer', ':id') }}";
              		remoteUrl = remoteUrl.replace(':id', full.customer_id);

			  		let action = `<button type="button" class="btn btn-xs btn-default btn-flat coa-action"><small>Print</button>`;

			  		if( full.unpaid.length ) {
			  			action = `<button type="button" class="btn btn-xs btn-default btn-flat coa-action rcv-payment"  data-title="Receive Payment" data-remote="${remoteUrl}"><small>Receive payment</button>`;
			  		}

			        return `
			            <div class="btn-group">
			              ${action}
			              <a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
			                <span class="sr-only">Toggle Dropdown</span>
			              </a>
			              <div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
			                <a class="dropdown-item" href="#"><small>Create Invoice</small></a>
			              </div>
			            </div>
			        `;
			  },
			  targets: [3]
			},
		],
	};

  	var oTable = $('#tbl-customer-list').DataTable(config);

  	$(document).on('click', '.rcv-payment', function(e){
	    e.preventDefault();
	  
	    var target = $(this);
   		var title = target.data('title');
   		var route = target.data("remote");	

	    payment(title, route, function(){

	    	$('.select2').select2({
	        	placeholder: 'Select',
	        	allowClear: true,
	      	});

	      	calculatePayment();
	    });
	});

	$(document).on('blur', '.txt-payment', function(e){
    	e.preventDefault();
		// check if value is numeric
		calculatePayment();
	});

	$(document).on('click', '.pr-chkbox-payment', function(){

		if( $(this).is(":checked") ){

            $('.child-chkbox-payment').each(function() {

            	let balance = parseFloat($(this).data('balance'));
            	$(this).closest('tr').find('.txt-payment').val(balance);
            	$(this).prop('checked', true);

            });

        }else {

        	$('.child-chkbox-payment').each(function() {
            	$(this).prop('checked', false);
            	$(this).closest('tr').find('.txt-payment').val('0.00');
            });

        }

        calculatePayment();

	});

	$(document).on('click', '.child-chkbox-payment', function(){

		if( $(this).is(":checked") ) {

			let balance = parseFloat($(this).data('balance'));
            $(this).closest('tr').find('.txt-payment').val(balance);
          
        }else if( $(this).is(":not(:checked)") ) {
        	$('.pr-chkbox-payment').prop('checked', false);
			$(this).closest('tr').find('.txt-payment').val('0.00');            
        }

        calculatePayment();

	});


	function checkPayment() {



	}

	function calculatePayment() {
		let total = 0.00;

		$('.txt-payment').each(function(i, e){
			total += parseFloat($(e).val());
		})

		$('#amount-received').text(total);

		return total;
	}

})(jQuery);
</script>