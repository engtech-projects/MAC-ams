<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript">
	(function ($) {
		$('form').attr('autocomplete','off');
		var subsidiaryTbl = $('#subsidiaryledgerTbl').DataTable({
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
	})(jQuery);

	function reload()
	{
		window.setTimeout(() => {
			location.reload();
		}, 500);
	}
</script>