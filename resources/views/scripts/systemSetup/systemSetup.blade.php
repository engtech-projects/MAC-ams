<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript">
	(function ($) {
		if(sessionStorage.clickNavId)
		{
			$('#'+sessionStorage.clickNavId).click();
		}
		$(document).on('click','.sysnav',function(e){
			e.preventDefault();
			if (typeof(Storage) !== "undefined") {
				sessionStorage.clickNavId = $(this).attr('id');
				
			} else {
				alert("Sorry, your browser does not support Web Storage...");
			}

		});
		$(document).on('click','.SearchName',function(e){
			e.preventDefault();
			$('#searchBarUser').val($(this).attr('value'));
			$('#searchContent').html("");
			var posting = $.get("{{ route('SystemSetupController.usermasterfile.fetchInfo') }}",{p_id:$(this).attr('user-id')});
				posting.done(function(response){
					$('.btn_plus').removeClass('d-none');
					$('.btn_minus').addClass('d-none');
					
					$.each(JSON.parse(response),function(k,v){
						$('#userId').val(v.user_info.id);
						$('#fname').val(v.fname);
						$('#mname').val(v.mname);
						$('#lname').val(v.lname);
						$('#gender').val(v.gender);
						$('#displayname').val(v.displayname);
						$('#email').val(v.email_address);
						$('#phone_number').val(v.phone_number);
						$('#username').val(v.user_info.username);

						$.each(v.user_info.accessibilities,function(kk,vv){
							$('#btn_plus_'+vv.sml_id).addClass('d-none');
							$('#btn_minus_'+vv.sml_id).removeClass('d-none');
						});
					});
			

				});
		})
		$(document).on('click','.btn-subModuleList',function(e){
			var sml_id = $(this).attr('value');
			if($('#userId').val() != '')
			{
				var posting = $.post("{{ route('SystemSetupController.usermasterfile.createOrUpdateAccessibility') }}",{_token: "{{ csrf_token() }}",sml_id:$(this).attr('value'),user_id:$('#userId').val()});
					posting.done(function(response){
						if(response == 'added')
						{
							$('#btn_plus_'+sml_id).addClass('d-none');
							$('#btn_minus_'+sml_id).removeClass('d-none');
						}else if(response == 'removed')
						{
							$('#btn_plus_'+sml_id).removeClass('d-none');
							$('#btn_minus_'+sml_id).addClass('d-none');
						}
					});
			}else{
				alert('no student selected');
			}
		
		});
		$(document).on('submit','#userMasterFileForm',function(e){
			e.preventDefault();
			var datastring = $(this).serialize();
			$.ajax({
				type: "POST",
				url: "{{ route('SystemSetupController.userMasterFile.createOrUpdate')}}",
				data: datastring,
				dataType: "json",
				success: function(data) {
					if(data == 'create'){
						$('#searchBarUser').val();
						toastr.success('Successfully Create');
						reset();
					}else if(data == 'update'){
						toastr.success('Successfully Update');
						reset();
					}
				},
				error: function() {
					console.log("Error");
				}
			});
		});
		$('#searchBarUser').keyup(function(e){
			var value = $(this).val();
			if(value)
			{
				var get = $.get("{{ route('SystemSetupController.usermasterfile.searchAccount') }}",{name:value});
					get.done(function(response){
						
						$('#searchContent').html("");
						$.each(JSON.parse(response),function(k,v){
							$('#searchContent').append('<li class="text-info list-group-item"><a href="#" class="SearchName" user-id="'+v.personal_info_id+'" value="'+ucFirst(v.lname)+' '+ucFirst(v.fname)+' ('+ucFirst(v.mname)+ ')" style="color:#3d9970!important; href="#">'+ucFirst(v.lname)+' '+ucFirst(v.fname)+' ('+ucFirst(v.mname)+ ')</a></li>');
						});
			
					});
			}else{
				$('#userMasterFileForm')[0].reset();
				$('#searchContent').html("");
				$('.btn_plus').addClass('d-none');
				$('.btn_minus').addClass('d-none');
			}
		});
		function reset()
		{
			$('#userMasterFileForm')[0].reset();
			$('#searchContent').html("");
			$('.btn_plus').addClass('d-none');
			$('.btn_minus').addClass('d-none');
			$('#userId').val('');
			$('#searchBarUser').val('');
		}
		function ucFirst(txt)
		{
			return txt.substring(0, 1).toUpperCase() + txt.substring(1);
		}
	})(jQuery);
</script>