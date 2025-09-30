<script type="text/javascript">

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


(function ($) {
  'use strict'

  // daterange picker
  var startDate = moment().startOf('year');
  var endDate = moment();

  var totalAmount = 0;
  var expenseTable = new toDataTable();
  var expenseFlyout = new GlobalWidget();
  var createTransaction = new GlobalWidget();

  // set expense table
  expenseTable.setSelector($('#tbl-expenses-list'))
              .setConfig(
                expenseTableConfig(
                  $('#flt-status option:selected').val(), 
                  $('#flt-payee option:selected').val(),
                  $('#flt-payee option:selected').attr('payee-type'),
                  startDate.format('YYYY-MM-DD'), 
                  endDate.format('YYYY-MM-DD')
                  ),
              )
              .initialize();


  $(document).on('click', '.expense-create-transaction', function(e){
      e.preventDefault();
      // var modal = $('#modal-create-expenses');
      let target = $(this);
      let title = target.data('title');
      let route = target.data('remote');

      createTransaction.setTitle(title)
            .setRoute(route)
            .setCallback( function(){

              $('.select2').select2({
                placeholder: 'Select',
                allowClear: true,
              });
              $('.expense-details-select2').select2({
                placeholder: 'Select an account',
                allowClear: true,
              });

            })
           .init();
  });

  $(document).on('click', '.remove-items', function(e){
    e.preventDefault();

    $(this).closest('tr').remove();
    calculateAmount();
  });

  $(document).on('submit', '#frm-add-expense-details', function(e){
    e.preventDefault();

    var form = $(this);
    var formData = form.serializeArray();
    var id = formData[0].value;
    var name =  $('#select-expense-account option:selected').text();
    var description = formData[1].value;
    var amount = formData[2].value;

    var markup = `
        <tr class="transaction-items">
          <td></td>
          <td data-id="${id}" >${name}</td>
          <td>${description}</td>
          <td class="text-right">${amount}</td>
          <td class="text-center"><i class="fa fa-trash-alt fa-xs text-muted remove-items" aria-hidden="true"></i></td>
        </tr>
        `;
    $('#footer-row').before(markup);

    calculateAmount();
    // reset form
    form[0].reset();
    // reset account
    $('.expense-details-select2').val('').trigger('change');
  });

  $(document).on('submit', '#frm-create-expense', function(e){
    e.preventDefault();

    var form = $(this);
    var formData = form.serializeArray();
    var url = form.prop('action');
    var payee_type = $('select[name=payee] option:selected').data('type');
    var accountId = $('select[name=account_id]').val();
    var items = [];
    
    items = addItems();

    if( !items ) {
      // change 
      alert('no items/details');
      return false;
    }

    formData.push({ name: 'payee_type', value: payee_type });
    formData.push({ name: 'total_amount', value: totalAmount });
    formData.push({ name: 'items', value: JSON.stringify(items) });

    var posting = $.post(url, formData);
        posting.done(function(response){
           
            if(response.success) {

              Toast.fire({
                icon: 'success',
                title: response.message
              });

            }else{

              Toast.fire({
                icon: 'error',
                title: response.message
              });

            }

            createTransaction.close();
            expenseTable.datatable.ajax.reload();

        });
  });

  $(document).on('submit', '#frm-create-bill', function(e){
    e.preventDefault();

    var form = $(this);
    var url = form.prop('action');
    var payee_type = $('select[name=payee] option:selected').data('type');
    var formData = form.serializeArray();

    var items = [];
    
    items = addItems();

    if( !items ) {
      // change 
      alert('no items/details');
      return false;
    }

    formData.push({ name: 'payee_type', value: payee_type });
    formData.push({ name: 'total_amount', value: totalAmount });
    formData.push({ name: 'items', value: JSON.stringify(items) });

    var posting = $.post(url, formData);
        posting.done(function(response){
 
          if(response.success) {

            Toast.fire({
              icon: 'success',
              title: response.message
            });
          }else{

            Toast.fire({
              icon: 'error',
              title: response.message
            });
          }

          createTransaction.close();
          expenseTable.datatable.ajax.reload();
      });
  });


  /* ----- actions ----- */
  $(document).on('click', '.view-expense', function(e){
    e.preventDefault();

    let target = $(this);
    let title = target.data('title');
    let route = target.data("remote");
        
    expenseFlyout.setTitle(title)
          .setRoute(route)
          .setCallback( function(){

            $('.select2').select2({
              placeholder: 'Select',
              allowClear: true,
            });

            calculateAmount();

          })
         .init();
  });

  $(document).on('click', '.void-transaction', function(e) {

    e.preventDefault();
    var id = $(this).parent().data('id');
    bootbox.confirm({
        animate: false,
        message: "This transaction is linked to other accounts. Are you sure you want to <strong>void</strong> it?",
        buttons: {
            confirm: {
                label: 'Void',
                className: 'btn-sm btn-flat btn-danger'
            },
            cancel: {
                label: 'Cancel',
                className: 'btn-sm btn-flat btn-default'
            }
        },
        callback: function (result) {

            let url = "{{ route('expenses.void') }}";
            let posting = $.post( url, { 'id' : id, _token : "{{ csrf_token() }}" , status : 'void'});
                posting.done(function(response){
                  
                  if(response.success) {

                    Toast.fire({
                      icon: 'success',
                      title: response.message
                    });

                  }else{

                    Toast.fire({
                      icon: 'error',
                      title: response.message
                    });

                  }

                  expenseTable.datatable.ajax.reload();

                });

        }
    });
  });


  // filters
  $(document).on('click', '.btn-apply-filters', function(e){
    e.preventDefault();

    let type = $(this).data('type');
    // console.log($('#flt-payee option:selected').val());
    // console.log($('#flt-payee option:selected').attr('payee-type'));
    expenseTable.datatable.destroy();
    expenseTable.setConfig(
                expenseTableConfig(
                    $('#flt-status option:selected').val(), 
                    $('#flt-payee option:selected').val(),
                    $('#flt-payee option:selected').attr('payee-type'),
                    startDate.format('YYYY-MM-DD'), 
                    endDate.format('YYYY-MM-DD')
                  )
              ).initialize();

  });

  function cb(start, end) {
      startDate = start;
      endDate = end;
      $('#expenses-daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  }

  $('#expenses-daterange').daterangepicker({
      startDate: startDate,
      endDate: endDate,
      ranges: {
         'Today': [moment(), moment()],
         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
         'This Month': [moment().startOf('month'), moment().endOf('month')],
         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
         'This Fiscal Year': [moment().startOf('year'), moment()]
      }
  }, cb);

  cb(startDate, endDate);

  function addItems() {

    var items = [];

    $('.transaction-items').each(function(index, row){

      let cells = $(row).find('td');
      let accountId = cells.eq(1).data('id');
      let description = cells.eq(2).text();
      let amount = cells.eq(3).text();
      
      items.push(
        {
          'account_id' : accountId, 
          'description' : description, 
          'amount' : amount, 
          'to_increase' : 'debit'
        }
      );

    });

    if( items.length ) { return items; }
    return false;
  }

  function removeDetails() {}

  function calculateAmount() {

    var amount = 0;
    totalAmount = 0;
    $('.transaction-items').each(function(index, row){
      var cells = $(row).find('td');
      amount = cells.eq(3).text();

      // check amount. add additional functionality
      if ( isNaN(amount) ) {
        return false;
      }

      amount = parseFloat(amount);
      totalAmount += amount;

    });

    $('#total-amount').html(totalAmount.toFixed(2)); 
  }

  var copyExpenseFlyout = new GlobalWidget();
	$(document).on('click', '.copy-transaction', function(e) {
		e.preventDefault();

		let target = $(this);
		let title = target.data('title');
		let route = target.data("remote");
			
		copyExpenseFlyout.setTitle(title)
			.setRoute(route)
			.setCallback( function(){

				$('.select2').select2({
				placeholder: 'Select',
				allowClear: true,
				});

				calculateAmount();

			})
			.init();
	});


})(jQuery);

function toDataTable() {
    this.datatable;
    this.selector = null;

    this.setSelector = function(selector){
      this.selector = selector;
      return this;
    };

    this.config = null;

    this.setConfig = function(config){
      this.config = config
      return this;
    };

    this.initialize = function() {
      this.datatable = this.selector.DataTable(this.config);
    }
}

function expenseTableConfig(status, payee, payeeType, from, to) {

    var config = {
      processing: true,
      autoWidth: false,
      bLengthChange: false,
      dom:"<'row'<'col-sm-12 col-md-12't><'col-sm-6 col-md-6'i><'col-sm-6 col-md-6'p>>",
      ajax: {
            url: "{{ route('expenses.populate') }}",
            type: "POST",
            dataType: "json",
            data : {
              type : 'expenses',
              status : status,
              payee : payee,
              payeeType : payeeType,
              from : from,
              to : to,
              _token : "{{ csrf_token() }}"
            }
      },
      columns: [
          { data: "date" },
          { data: "type" },
          { data: "no" },
          { data: "payee" },
          { data: "due_date" },
          { data: "balance" },
          { data: "total",  
            className: 'text-right',
          },
          { data: "status" },
      ],
      columnDefs: [
        {
          className: 'text-right',
          render: function (data, type, full, meta) {

              var viewEditUrl = "{{ route('expenses.show', ':id') }}";
              var copyLink = '';
			  viewEditUrl = viewEditUrl.replace(':id', full.transaction_id);
			
			  var copyUrl = "{{ route('expenses.create', ['type'=>'expense', 'id'=>'idd']) }}";
              copyUrl = copyUrl.replace('idd', full.transaction_id);
			  console.log(full);

			  if( full['type'].toLowerCase() == 'expense' ){
					copyLink = `<a class="dropdown-item copy-transaction" data-remote="${copyUrl}" href="${copyUrl}">Copy</a>`
			  }

              if( full['transaction_type'] == 'Bill' &&  full['status'] != 'paid'){

                return `
                  <div class="btn-group">
                    <button type="button" class="btn btn-xs btn-default btn-flat coa-action"><small>Make Payment</button>
                    <a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
                      <a class="dropdown-item" href="#">View</a>
                      <a class="dropdown-item" href="#">Delete</a>
                    </div>
                  </div>
              `;

              }

              return `
                  <div class="btn-group">
                    <button type="button" class="btn btn-xs btn-default btn-flat coa-action view-expense" data-title="Expense [show expense id here]" data-remote="${viewEditUrl}"><small>View</button>
                    <a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" data-id="${full.transaction_id}" role="menu" style="left:0;">
                      <a class="dropdown-item void-transaction" href="#">Void</a>` + copyLink + 
                      `<a class="dropdown-item delete-transaction" href="#">Delete</a>
                    </div>
                  </div>
              `;
          },
          targets: [8]
        },
      ],
    };

    return config;
}

$("#printBtn").click(function(e){
	window.print();
});


</script>