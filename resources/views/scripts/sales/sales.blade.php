<script type="text/javascript">






var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});


(function ($) {
  'use strict'



  var totalAmount = 0;
  // daterange picker
  var startDate = moment().startOf('year');
  var endDate = moment();
  // instance of datatables(sales and invoice  list)
  // for sales page
  var salesTable = new toDataTable();
  // for invoices page
  var invoiceTable = new toDataTable();
  // modal - to create an invoice
  var invoiceFlyout = new GlobalWidget();
  var paymentFlyout = new GlobalWidget();
  var copyInvoiceFlyout = new GlobalWidget();
  // set salesTable
  salesTable.setSelector($('#tbl-sales-list'))
          .setConfig(
            salesTableConfig(
              $('#flt-status option:selected').val(),
              $('#flt-customer option:selected').val(),
              startDate.format('YYYY-MM-DD'),
              endDate.format('YYYY-MM-DD')
            ),
          )
          .initialize();
  // set invoice table
  invoiceTable.setSelector($('#tbl-invoice-list'))
              .setConfig(
                invoiceTableConfig(
                  $('#flt-status option:selected').val(),
                  startDate.format('YYYY-MM-DD'),
                  endDate.format('YYYY-MM-DD')
                )
              )
              .initialize();


    $('.select2').select2({
        placeholder: 'Select',
        allowClear: true,
    });

  $(document).on('click', '.invoice-create-transaction', function(e){
      e.preventDefault();

        let target = $(this);
        let title = target.data('title');
        let route = target.data("remote");

        invoiceFlyout.setTitle(title)
                    .setRoute(route)
                    .setCallback( function(){

                      $('.select2').select2({
                        placeholder: 'Select',
                        allowClear: true,
                      });

                    })
                   .init();
  });

  $(document).on('submit', '#frm-create-invoice', function(e){
    e.preventDefault();

    var form = $(this);
    var formData = form.serializeArray();
    var url = form.prop('action');

    var items = [];

    items = addItems();

    if( !items ) {
      // change
      alert('no items/details');
      return false;
    }

    formData.push({ name: 'amount', value: totalAmount });
    formData.push({ name: 'items', value: JSON.stringify(items) });
	console.log(formData);

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

            salesTable.datatable.ajax.reload();
            invoiceTable.datatable.ajax.reload();
            invoiceFlyout.close();

        });
  });

  $(document).on('submit', '#frm-add-item-details', function(e){
    e.preventDefault();

    var form = $(this);
    var formData = form.serializeArray();
    var id = formData[0].value;
    var name =  $('.product-service-select option:selected').text();
    var description = formData[1].value;
    var qty =  formData[2].value;
    var rate = formData[3].value;
    var amount = formData[4].value;

    var markup = `
        <tr class="transaction-items">
          <td></td>
          <td data-id="${id}" >${name}</td>
          <td>${description}</td>
          <td class="text-right">${qty}</td>
          <td class="text-right">${rate}</td>
          <td class="text-right">${amount}</td>
          <td class="text-center"><i class="fa fa-trash-alt fa-xs text-muted remove-items" aria-hidden="true"></i></td>
        </tr>
        `;
    $('#footer-row').before(markup);

    calculateAmount();
    // reset form
    form[0].reset();
    // reset account
  });

  $(document).on('click', '.remove-items', function(e){
    e.preventDefault();

    $(this).closest('tr').remove();
    calculateAmount();
  });

  function amountConverter(amount) {
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP',

    });

    return formatter.format(amount)
  }

  $(document).on('change', '.product-service-select', function(e){
    e.preventDefault();

    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP',

    });

    var rate = $(this).find('option:selected').data('rate');



    var qty = $('input[name=qty]').val();
    var amount = initCalc(rate, qty);
    /* var totalAmount = parseFloat(amount).toFixed(2)
    var totalRate = parseFloat(rate).toFixed(2) */

    $('input[name=rate]').val(amountConverter(rate));
    $('input[name=amount]').val(amountConverter(amount));




    //console.log(reverseFormatNumber(formatter.format(rate),'en'));

  });

  $(document).on('blur', 'input[name=qty]', function(e){
    e.preventDefault();
    $('.product-service-select').trigger('change');
  });

  $(document).on('click', '.btn-apply-filters', function(e){
    e.preventDefault();

    let type = $(this).data('type');

    switch( type ) {

      case 'sales':
        salesTable.datatable.destroy();
        salesTable.setConfig(
                    salesTableConfig(
                        $('#flt-status option:selected').val(),
                        $('#flt-customer option:selected').val(),
                        startDate.format('YYYY-MM-DD'),
                        endDate.format('YYYY-MM-DD')
                      )
                  ).initialize();
      break;
      case 'invoice':
        invoiceTable.datatable.destroy();
        invoiceTable.setConfig(
                    invoiceTableConfig(
                        $('#flt-status option:selected').val(),
                        startDate.format('YYYY-MM-DD'),
                        endDate.format('YYYY-MM-DD')
                      )

                  ).initialize();
      break;
      default:
      alert('Error pa ni');
    }

  });

  function cb(start, end) {
      startDate = start;
      endDate = end;
      $('#salesDateRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  }

  $('#salesDateRange').daterangepicker({
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


function reverseFormatNumber(val,locale){

        /* var group = new Intl.NumberFormat(locale).format(1111).replace(/1/g, '');
        var decimal = new Intl.NumberFormat(locale).format(1.1).replace(/1/g, ''); */
        var group = Intl.NumberFormat(locale).format(11111).replace(/\p{Number}/gu, '');
        var decimal = Intl.NumberFormat(locale).format(1.1).replace(/\p{Number}/gu, '');
        var reversedVal = val.replace(new RegExp('\\' + group, 'g'), '');
        reversedVal = reversedVal.replace(new RegExp('\\' + decimal, 'g'), '.');
        return Number.isNaN(reversedVal)?0:reversedVal;
}



  function addItems() {

    var items = [];

    $('.transaction-items').each(function(index, row){

      let cells = $(row).find('td');
      let itemId = cells.eq(1).data('id');
      let description = cells.eq(2).text();
      let qty = cells.eq(3).text();
      let rate = cells.eq(4).text();
      let amount = cells.eq(5).text();

        var totalRate = Number(rate.replace(/[^0-9\.-]+/g,""));
        var t_amount = Number(amount.replace(/[^0-9\.-]+/g,""));

      items.push(
        {
          'item_id' : itemId,
          'description' : description,
          'qty' : qty,
          'rate' : totalRate,
          'amount' : t_amount
        }
      );

    });

    if( items.length ) { return items; }
    return false;
  }

  function initCalc(rate, qty) {

    var amount = parseFloat(qty) * parseFloat(rate);

    if( amount < 0 ){
      return 0;
    }
    return amount;
  }

  function calculateAmount() {

    var amount = 0;
    totalAmount = 0;
    $('.transaction-items').each(function(index, row){
      var cells = $(row).find('td');
      amount = cells.eq(5).text();
      var t_amount = Number(amount.replace(/[^0-9\.-]+/g,""));


      // check amount. add additional functionality
      if ( isNaN(t_amount) ) {
        return false;
      }


      totalAmount += t_amount;

    });

    $('#total-amount').html(amountConverter(totalAmount));
  }

/* --------------------------------------------------------------------------------------------- */
/* payment part of the script */

  $(document).on('click', '.rcv-payment', function(e){
    e.preventDefault();



    let target = $(this);
    let title = target.data('title');
    let route = target.data('remote');

    paymentFlyout.setTitle(title)
                  .setRoute(route)
                  .setCallback( function(){
                    $('.select2').select2({
                        placeholder: 'Select',
                        allowClear: true,
                    })
                }).init();
  });



  $(document).on('click', '.copy-invoice', function(e){
    e.preventDefault();
    let target = $(this);
    let route = target.data('remote');
	console.log(route);

    copyInvoiceFlyout.setTitle('Invoice')
                  .setRoute(route)
                  .setCallback( function(){
                    $('.select2').select2({
                        placeholder: 'Select',
                        allowClear: true,
                    });
                  })
                  .init();
  });

  $(document).on('blur', '.txt-payment', function(e){
    e.preventDefault();
    // check if value is numeric
    amountReceived();
  });

  $(document).on('submit', '#frm-payment', function(e){
    e.preventDefault();

    var form = $(this);
    var formData = form.serializeArray();
    var url = form.prop('action');

    formData.push({ name: 'status', value: checkPayment() });

    var posting = $.post( url, formData);
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

          salesTable.datatable.ajax.reload();
          invoiceTable.datatable.ajax.reload();
          paymentFlyout.close();

        });
  });

  function checkPayment() {

    let amountReceived = parseFloat($('.txt-payment').val());
    let balance = parseFloat($('.invoice-balance').text());
    let total = balance - amountReceived;

    if( total > 0 ){
      return 'partial';
    }
    return 'closed';
  }


  function amountReceived() {

    let payment = $('.txt-payment').val();
    console.log(payment)
    $('#amount-received').text(payment);

  }

})(jQuery);


function actionTemplate(action, menuItems) {

  var items = '';

  menuItems.forEach(function(a) {
    items += `<a class="dropdown-item ${a.class}" href="#">${a.menu}</a>`;
  });

  return `<div class="btn-group">
          ${action}
          <a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
          ${items}
          </div>
        </div>`;
}

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

// datatable config
function salesTableConfig(status, customer, from, to) {

  var config = {
    searching: false,
    autoWidth: false,
    bLengthChange: false,
    ordering: false,
    dom:"<'row'<'col-sm-12 col-md-12't><'col-sm-6 col-md-6'i><'col-sm-6 col-md-6'p>>",
    ajax: {
          url: "{{ route('sales.populate') }}",
          type: "POST",
          dataType: "json",
          data : {
              type : 'sales',
              status : status,
              customer : customer,
              from : from,
              to : to,
              _token : "{{ csrf_token() }}"
          }
    },
    columns: [
        { data: "date" },
        { data: "type" },
        { data: "no" },
        { data: "customer" },
        { data: "due_date" },
        { data: "balance",
          className: 'text-right sales-balance',
          render: $.fn.dataTable.render.number( ',', '.', 2 ,'₱')
        },
        { data: "total",
          className: 'text-right',
          render: $.fn.dataTable.render.number( ',', '.', 2, '₱')
        },
        { data: "status" },
    ],
    columnDefs: [
      {
        className: 'text-right',
        render: function (data, type, full, meta) {

            var remoteUrl = "{{ route('payment.create', ':id') }}";
            remoteUrl = remoteUrl.replace(':id', full.transaction_id);
            var action;

            let menuItems = [];

            if( full.status == 'open' ) {
              action = `<button type="button" class="btn btn-xs btn-default btn-flat coa-action rcv-payment" data-title="Receive Payment" data-remote="${remoteUrl}"><small>Receive payment</button>`;
              menuItems.push({ 'class' : '', 'menu' : 'Void' });
              menuItems.push({ 'class' : '', 'menu' : 'Delete' });
            }

            if( full.status == 'paid' ){
              action = `<button type="button" class="btn btn-xs btn-default btn-flat coa-action"><small>Print</button>`;
              menuItems.push({ 'class' : '', 'menu' : 'View/Edit' });
              menuItems.push({ 'class' : '', 'menu' : 'Void' });
              menuItems.push({ 'class' : '', 'menu' : 'Delete' });
            }

            if( full.status == 'partial' ) {
              action = `<button type="button" class="btn btn-xs btn-default btn-flat coa-action"><small>Print</button>`;
              menuItems.push({ 'class' : '', 'menu' : 'Void' });
              menuItems.push({ 'class' : '', 'menu' : 'Delete' });
            }

            if( full.status == 'closed' ){
              action = `<button type="button" class="btn btn-xs btn-default btn-flat coa-action"><small>View/Edit</button>`;

              return `
                  <div class="btn-group">
                    ${action}
                  </div>
              `;
            }
            return actionTemplate(action, menuItems);
        },
        targets: [8]
      },
    ],
  };

  return config;
}

function invoiceTableConfig(status = '', from = '', to = '') {

  var config = {
    searching: false,
    autoWidth: false,
    bLengthChange: false,
    ordering: false,
    dom:"<'row'<'col-sm-12 col-md-12't><'col-sm-6 col-md-6'i><'col-sm-6 col-md-6'p>>",
    ajax: {
        url: "{{ route('sales.populate') }}",
        type: "POST",
        dataType: "json",
        data : {
            type : 'invoice',
            status : status,
            customer : 'all',
            from : from,
            to : to,
            _token : "{{ csrf_token() }}"
        }
    },
    columns: [
      { data: "date" },
      { data: "no" },
      { data: "customer" },
      { data: "amount",
        className: 'text-right',
        render: $.fn.dataTable.render.number( ',', '.', 2 )
      },
      { data: "balance",
        className: 'text-right',
        render: $.fn.dataTable.render.number( ',', '.', 2 )
      },
      { data: "due_date" },
      { data: "status" },
    ],
    columnDefs: [
    {
      className: 'text-right',
      render: function (data, type, full, meta) {

      var remoteUrl = "{{ route('payment.create', ':id') }}";
		  var copyUrl = "{{ route('sales.create', ['type'=>':type']) }}";
      remoteUrl = remoteUrl.replace(':id', full.transaction_id);
		  copyUrl = copyUrl.replace(':type', 'invoice');
		  copyUrl += "?id=" + full.transaction_id;
          var action;

          if( full.status == 'open' ) {
            action = `<button type="button" class="btn btn-xs btn-default btn-flat coa-action rcv-payment" data-title="Receive Payment" data-remote="${remoteUrl}"><small>Receive payment</button>`;
            return `
                <div class="btn-group">
                  ${action}
                  <a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
                    <a class="dropdown-item" href="#">Void</a>
					<a class="dropdown-item copy-invoice" data-remote="${copyUrl}" href="#">Copy</a>
                    <a class="dropdown-item" href="#">Delete</a>
                  </div>
                </div>
            `;
          }

          if( full.status == 'paid' ){
             action = `<button type="button" class="btn btn-xs btn-default btn-flat coa-action"><small>Print</button>`;

            return `
                <div class="btn-group">
                  ${action}
                  <a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
                    <a class="dropdown-item" href="#">View/Edit</a>
                    <a class="dropdown-item" href="#">Delete</a>
                    <a class="dropdown-item" href="#">Void</a>
                  </div>
                </div>
            `;
          }


          if( full.status == 'partial' ) {
            action = `<button type="button" class="btn btn-xs btn-default btn-flat coa-action"><small>Print</button>`;

            return `
                <div class="btn-group">
                  ${action}
                  <a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
                    <a class="dropdown-item" href="#">Void</a>
                    <a class="dropdown-item" href="#">Delete</a>
                  </div>
                </div>
            `;
          }

          if( full.status == 'closed' ){
            action = `<button type="button" class="btn btn-xs btn-default btn-flat coa-action"><small>View/Edit</button>`;
            return `
                <div class="btn-group">
                  ${action}
                </div>
            `;
          }
      },
      targets: [7]
    },
    ],
  };

  return config;
}

function copyInvoice(e){
	console.log(e.target.getAttribute('data-id'));
}

// $(document).on('click', '.copy-invoice', function(e){
// 	e.preventDefault();

// 	alert('copied!');
// });




</script>
