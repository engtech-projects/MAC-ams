<script type="text/javascript">
(function ($) {
  'use strict'

  $('form').attr('autocomplete','off');
	var journalEntryDetails = $('#journalEntryDetails').DataTable({
		dom: 'Bftrip',
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
			{
				text: '<i class="fas fa-file-upload" aria-hidden="true"></i>',
				className: 'btn btn-flat btn-sm btn-default',
				titleAttr: 'Import',
				action: function ( e, dt, node, config ) {
					document.getElementById('import').click();
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

    $.fn.editable.defaults.mode = 'inline';

    $('.editable-row-item').editable({
        type: 'text',
        emptytext: '',
        showbuttons: false,
        unsavedclass: null,
        toggle: 'manual',
        onblur: 'ignore', 
        inputclass: 'form-control form-control-sm block',
        success: function (response, newValue) {
            console.log(response);
            console.log(newValue);
        }
    });

	$(".editables").on("shown", function(e, editable) {
		console.log(	editable.input.$input)
	});
    function submitEditable() {
        $('.editable-table-data .editableform').editable().submit();
    }

    $('.editable-table-data').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
		console.log($(this));
		// $(this).editable().submit();
		// co
        if ($(this).find('.editableform').length < 1) { submitEditable();}
        $(this).find('a').each(function () { $(this).editable('show'); });
        $(this).find('.editableform').each(function () { $(this).on('keydown', function (e) { if ((e.keyCode || e.which) == 13) { submitEditable(); } }) });
        
    });

	$(document).on('click','.remove-journalDetails',function(e){
		$(this).parents('tr').remove();
		
	})
	$(document).on('click','#add_item',function(e){
		e.preventDefault();
		var content = `<tr class='editable-table-row'>
								<td value="" ></td>
								<td class='editable-table-data' value="" ><a href="#" ed-title="account_no" class="editable-row-item"></a> </td>
								<td class='editable-table-data' value="" ><a href="#" class="editable-row-item"></a> </td>
								<td class='editable-table-data' value="" ><a href="#" class="editable-row-item"></a> </td>
								<td class='editable-table-data' value="" >
									<select name="" class="form-control form-control-sm" id="" >
										<option disabled selected>-Select S/L-</option>
										@foreach($journalBooks as $journalBook)
											<option value="{{$journalBook->book_id}}" book-src="{{$journalBook->book_src}}">{{$journalBook->book_name}}</option>
										@endforeach
									</select>
								</td>
								<td class='editable-table-data' value="" ><a href="#" class="editable-row-item"></a> </td>
								<td>
									<button class="btn btn-secondary btn-flat btn-sm btn-default remove-journalDetails">
										<span>
											<i class="fas fa-trash" aria-hidden="true"></i>
										</span>
									</button>
								</td>
							</tr>`
		$('#tbl-create-journal-container').append(content);
	});

    $(document).click(function () {
        submitEditable();
    });



    $(document).on('submit', '#frm-journal-entry', function(e){
    	e.preventDefault();

    	var form = $(this);
    	var formData = form.serializeArray();
    	var accountName = $('select[name=account_id] option:selected').text();
    	var accountId = formData[0].value;
    	var debit = formData[1].value;
    	var credit = formData[2].value;
    	var description = formData[3].value;
    	// var personId = formData[4].value;
    	var personName = $('select[name=person] option:selected').text();
    	var personType = $('select[name=person] option:selected').data('type');

    	var markup = `
			        <tr class="transaction-items">
			          <td></td>
			          <td>${accountName}</td>
			          <td class="text-right">${debit}</td>
			          <td class="text-right">${credit}</td>
			          <td>${description}</td>
			          <td>${personName}</td>
			          <td class="text-center"><i class="fa fa-trash-alt fa-xs text-muted remove-items" aria-hidden="true"></i></td>
			        </tr>
			        `;
		$('#footer-row').before(markup);

    	console.log(formData);
    });

    $(document).on('submit', '#frm-create-journal', function(e){
    	e.preventDefault();

    	var form = $(this);
    	var formData = form.serializeArray();
    	var url = form.prop('action');
    	
    	var posting = $.post(url, formData);
        posting.done(function(response){
        	console.log(response);
          
        });
    });

	$(document).on('change','#book_id',function(){
		$('#source').val($(this).attr('book-src'));
	});
	

})(jQuery);
</script>