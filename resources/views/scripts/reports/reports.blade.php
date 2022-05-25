<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript">
	(function ($) {


		var subsidiaryTbl = $('#subsidiaryledgerTbl').DataTable({
			dom: 'Bftrip',
			buttons: [
				{
                text: 'Excel',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            }
			]
		});
	})(jQuery);
</script>