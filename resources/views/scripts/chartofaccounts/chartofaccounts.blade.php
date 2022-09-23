<script type="text/javascript">
(function ($) {
  'use strict'
  $('form').attr('autocomplete','off');
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    // accounts datatable
    var accountsTable = new toDataTable();
 
    // var oTable;

  	$(document).on('click', '#chkSubAccount', function(){
  		if( this.checked > 0 ) {
  			$('#sltParentAccount').prop('disabled', false);
  			return;
  		}
  		$('#sltParentAccount').prop('disabled', true);      
  	});

	
    $(document).on('submit', '#frm-create-account', function(e){
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

            $('#modal-create-account').modal('hide');
			reload();
          }else{

            Toast.fire({
              icon: 'error',
              title: response.message
            });

          }

        });
    });

	$("#import").on('change', function(e){
		var selectedFile = e.target.files[0];
		var fileReader = new FileReader();
		fileReader.onload = function(event) {
			var data = event.target.result;
			var csv = XLSX.read(data, {type: "binary"});
			csv.SheetNames.forEach(sheet => {
				let rowObject = XLSX.utils.sheet_to_row_object_array(csv.Sheets[sheet]);
				let jsonObject = JSON.stringify(rowObject);
				// console.log(JSON.parse(jsonObject));
				importAccounts(JSON.parse(jsonObject));
			});
		};
		fileReader.readAsBinaryString(selectedFile);
	});

	function importAccounts(accounts){
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type:'POST',
			url:"{{route('accounts.import')}}",
			data:{'accounts':accounts},
			success:function(data) {
				accountsTable.datatable.ajax.reload();
				console.log(data);
			}
		});
	}

    // oTable = $('#tbl-chart-of-accounts').DataTable(config);
    // $('.dataTables_filter input').addClass('rounded-0');

    $(document).on('click', '.btn-create-account', function(e){
      e.preventDefault();
      var modal = $('#modal-create-account');
      var target = $(this);
      // load content from HTML string
      //modal.find('.modal-body').html("Nice modal body baby...");
      // or, load content from value of data-remote url
      modal.find('.modal-body').html('');
      modal.find('.modal-body').load(target.data("remote"), function(){
        $('.select2').select2();
      });
      modal.modal('show');
    });

	$(document).on('click', '#btn-create-class', function(e){
      e.preventDefault();
      var modal = $('#modal-create-account');
      var target = $(this);
      // load content from HTML string
      //modal.find('.modal-body').html("Nice modal body baby...");
      // or, load content from value of data-remote url
      modal.find('.modal-body').html('');
      modal.find('.modal-body').load(target.data("remote"), function(){
        $('.select2').select2();
      });
      modal.modal('show');
    });

	$(document).on('click', '#btn-create-type', function(e){
      e.preventDefault();
      var modal = $('#modal-create-account');
      var target = $(this);
      // load content from HTML string
      //modal.find('.modal-body').html("Nice modal body baby...");
      // or, load content from value of data-remote url
      modal.find('.modal-body').html('');
      modal.find('.modal-body').load(target.data("remote"), function(){
        $('.select2').select2();
      });
      modal.modal('show');
    });

    $(document).on('click', '.btn-edit-account', function(e){
      e.preventDefault();
      var modal = $('#modal-create-account');
      var target = $(this);
      // load content from HTML string
      //modal.find('.modal-body').html("Nice modal body baby...");
      // or, load content from value of data-remote url
      modal.find('.modal-body').html('');
      modal.find('.modal-body').load(target.data("remote"), function(){
        $('.select2').select2();
      });
      modal.modal('show');
    });

	


	$(document).on('submit', '#form-class',function(e){
		e.preventDefault();
		$.ajax({
          url: "{{ route('accounts.saveClass')}}",
          type: 'POST',
          data: $(this).serialize(),
          success: function(response) {
				if(response === 'true')
				{
					Toast.fire({
						icon: 'success',
						title: ' Class Successfully Save'
					});
					$('#form-class')[0].reset();
					$('#modal-create-class').modal('hide');
					reload();
				}
          }
      	});
	});

	$(document).on('submit', '#form-type',function(e){
		e.preventDefault();
		$.ajax({
          url: "{{ route('accounts.saveType')}}",
          type: 'POST',
          data: $(this).serialize(),
          success: function(response) {
				if(response === 'true')
				{
					Toast.fire({
						icon: 'success',
						title: ' Type Successfully Save'
					});
					$('#form-type')[0].reset();
					$('#modal-create-class').modal('hide');
					reload();
				}
          }
      	});
	});

    $(document).on('submit', '#frm-update-account', function(e){
      e.preventDefault();

      var url = $(this).prop('action');
      var form = $(this);

      // console.log(form.attr('method'));
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

              $('#modal-create-account').modal('hide');
			  reload();

            }else{

              Toast.fire({
                icon: 'error',
                title: response.message
              });

            }
          }
      });
    });

    /* set account active inactive */
    $(document).on('click', '.btn-set-status', function(e){

      e.preventDefault();

      let elem = $(this);
      let status = $(this).data('status');
      let accountId = $(this).data('id');
      let url = "{{ route('accounts.setStatus') }}";

        bootbox.confirm({
          animate: false,
          message: "This transaction might be linked to other accounts. Are you sure you want to perform this action?",
          buttons: {
              confirm: {
                  label: `Set ${status}`,
                  className: 'btn-sm btn-flat btn-danger'
              },
              cancel: {
                  label: 'Cancel',
                  className: 'btn-sm btn-flat btn-default'
              }
          },
          callback: function (result) {

            if( result ) {

              let posting = $.post( 
                url, { 
                  id : accountId, 
                  _token : "{{ csrf_token() }}" ,
                  status : status
                });

                posting.done(function(response){
                    
                    console.log(response);
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

                    accountsTable.datatable.ajax.reload();

                  });

            }
          }
      });





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

function reload()
{
	window.setTimeout(() => {
		location.reload();
	}, 500);
}
function accountsTableConfig() {

  let config = {
      processing: true,
      // serverSide: true,
      autoWidth: false,
      bLengthChange: false,
      oLanguage: {
        "sSearch": "<i>Filter</i> : "
      },
      dom:"<'row'<'col-sm-6 col-md-6'f><'col-sm-6 col-md-6 text-right'B>>",
      buttons: ['print', 'csv',
	  		{
                text: '<i class="fas fa-file-download" aria-hidden="true"></i>',
                className: 'btn btn-flat btn-sm btn-default',
                titleAttr: 'Export',
                action: function ( e, dt, node, config ) {
					var exportBtn = document.getElementsByClassName('btn btn-secondary buttons-csv buttons-html5')[0];
					exportBtn.click();
                }
            },
            {
                text: '<i class="fas fa-print" aria-hidden="true"></i>',
                className: 'btn btn-flat btn-sm btn-default',
                titleAttr: 'Print',
                action: function ( e, dt, node, config ) {
                    var printBtn = document.getElementsByClassName('btn btn-secondary buttons-print')[0];
					printBtn.click();
                }
            },
      ],
      ajax: {
          url: "{{ route('accounts.populate') }}",
      },
      columns: [
        { data: "account_number" },
        { data: "account_name",
          render: function(data, type, full) {


              if( full['parent_account'] ){
                return `<div style="margin-left:20px; "> ${data} 
                          <span class="float-right badge badge-secondary">${full.account_category}</span>
                        </div>`;
              }
              
              return `<div> ${data} 
                        <span class="float-right badge badge-secondary">${full.account_category}</span>
                      </div>`;
          }
        },
        { data: "account_type" },
        { data: "account_description" },
        { data: "account_type_id" },
      ],
      columnDefs: [
        {
          className: 'text-right',
          render: function (data, type, full, meta) {
            return '0.00';
          },
          targets: [4]
        },
        // {
        //         "targets": [ 4 ],
        //         "visible": false,
        //         "searchable": false
        // },
        {
          className: 'text-center',
              render: function (data, type, full, meta) {
                  var remoteUrl = "{{ route('accounts.show', ':id') }}";
                  remoteUrl = remoteUrl.replace(':id', full['account_id']);

                  let status = full.status;
                  let accountId = full.account_id;

                  if( full.status == 'active' ) {
                    status = 'inactive';
                  }

                  return `
                      <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-default btn-flat coa-action">Report</button>
                        <a type="button" class="btn btn-xs btn-default btn-flat dropdown-toggle dropdown-icon coa-action" data-toggle="dropdown" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" role="menu" style="left:0;">
                          <a class="dropdown-item btn-edit-account" href="#" data-remote="${remoteUrl}">Edit</a>
                          <a class="dropdown-item btn-set-status" data-status="${status}" data-id="${accountId}" href="#">${status}</a>
                          <!-- <a class="dropdown-item" href="#">Something else here</a> -->
                        <!--   <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#">Separated link</a> -->
                        </div>
                      </div>
                  `;
              },
              targets: [5]
          },
      ]
  }

  return config;
}

</script>