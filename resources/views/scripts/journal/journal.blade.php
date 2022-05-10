<script type="text/javascript">
(function ($) {
  'use strict'

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
            console.log(newValue);
        }
    });

    function submitEditable() {
        $('.editable-table-row .editableform').editable().submit();
    }

    $('.editable-table-row').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        if ($(this).find('.editableform').length < 1) { submitEditable();}
        $(this).find('a').each(function () { $(this).editable('show'); });
        $(this).find('.editableform').each(function () { $(this).on('keydown', function (e) { if ((e.keyCode || e.which) == 13) { submitEditable(); } }) });
        
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
            // if(response.success) {

            //   Toast.fire({
            //     icon: 'success',
            //     title: response.message
            //   });

            //   $('#modal-create-sales').modal('hide');

            // }else{

            //   Toast.fire({
            //     icon: 'error',
            //     title: response.message
            //   });

            // }

        });
    });





})(jQuery);
</script>