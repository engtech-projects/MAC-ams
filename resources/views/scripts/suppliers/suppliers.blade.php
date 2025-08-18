<script type="text/javascript">
(function ($) {
  'use strict'

	var Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000
	});

	$(document).on('click', '.create-supplier', function(e){
		e.preventDefault();
		var modal = $('#modal-create-supplier');
		var target = $(this);
		var title = target.data('title');
		// load content from HTML string
		modal.find('.modal-title').html(title);
		// or, load content from value of data-remote url
		modal.find('.modal-body').html('');
		modal.find('.modal-body').load(target.data("remote"), function(){
		});
		modal.modal('show');
  	});

  	$(document).on('click', '.edit-supplier', function(e){
		e.preventDefault();
		var modal = $('#modal-create-supplier');
		var target = $(this);
		var title = target.data('title');
		// load content from HTML string
		modal.find('.modal-title').html(title);
		// or, load content from value of data-remote url
		modal.find('.modal-body').html('');
		modal.find('.modal-body').load(target.data("remote"), function(){
		});
		modal.modal('show');
  	});

  	$(document).on('submit', '#frm-create-supplier', function(e){
    	e.preventDefault();

    	var form = $(this);
    	var url = form.prop('action');

    	var posting = $.post(url, form.serializeArray());
	        posting.done(function(response){
	           
	        	if(response.success) {

	              Toast.fire({
	                icon: 'success',
	                title: response.message
	              });

	              $('#modal-create-supplier').modal('hide');

	            }else{

	              Toast.fire({
	                icon: 'error',
	                title: response.message
	              });

	            }

	        });
	});

	$(document).on('submit', '#frm-edit-supplier', function(e){
    	e.preventDefault();

    	var form = $(this);
    	var url = form.prop('action');

    	 $.ajax({
          url: url,
          type: 'PUT',
          data: form.serialize(),
          success: function(response) {
            
            if(response.success) {

              Toast.fire({
                icon: 'success',
                title: response.message
              });

              $('#modal-create-supplier').modal('hide');
              oTable.ajax.reload();

            }else{

              Toast.fire({
                icon: 'error',
                title: response.message
              });

            }
          }
      });
    
	});


	var config = {
		processing: true,
	    autoWidth: false,
	    bLengthChange: false,
	    dom:"<'row'<'col-sm-12 col-md-12't><'col-sm-6 col-md-6'i><'col-sm-6 col-md-6'p>>",
	    ajax: {
	          url: "{{ route('supplier.populate') }}",
	    },
	    columns: [
	        { data: "displayname",
	        	render: function (data, type, full, meta) {
	        		var remoteUrl = "{{ route('supplier.show', ':id') }}";
                  	remoteUrl = remoteUrl.replace(':id', full['supplier_id']);

		        	return `<a href="#" class="edit-supplier" data-title="Supplier Information" data-remote="${remoteUrl}">${data}</a>
		        			<br />
		        			<small class="text-muted">${full['company']}</small>`;
		 		},
	    	},
	        { data: "mobile_number" },
	        { data: "email_address" },
	    ],
	    columnDefs: [
	    	{
		        className: 'text-right',
		        render: function (data, type, full, meta) {
		        	return '';
		 		},
		        targets: [3]
		    },
		    {
		        className: 'text-right',
		        render: function (data, type, full, meta) {
		        	return `
                      <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-default btn-flat coa-action"><small>Make payment</small></button>
                        <a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
                          <a class="dropdown-item btn-edit-account" href="#">Create bill</a>
                          <a class="dropdown-item" href="#">Create expense</a>
                        </div>
                      </div>
                  	`;
		 		},
		        targets: [4]
		    },
	    ],
	};

	var oTable = $('#tbl-supplier-list').DataTable(config);

	$("#printBtn").click(function(e){
		window.print();
	});


})(jQuery);
</script>