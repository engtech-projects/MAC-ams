<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
    (function($) {
        $('#select-account-credit').select2({
            placeholder: 'Account',
            allowClear: true,
        });
        $('#select-account-debit').select2({
            placeholder: 'Account',
            allowClear: true,
        });

        $('.select-year').select2({
            placeholder: 'Select Account',
            allowClear: true,
              tags: true,
            createTag: function(params) {
                // If user typed something not in the list
                return {
                    id: params.term,
                    text: params.term,
                    newOption: true
                }
            },
            insertTag: function(data, tag) {
                // Add the custom input to the dropdown
                data.push(tag)
            }
        });
        $('#filter-logs').select2({
            placeholder: 'Account',
            allowClear: true,
        });
        $('#gender').select2({
            placeholder: 'Select Gender',
            width: '100%',
        });
        $('#role_id').select2({
            placeholder: 'Select Role',
            width: '100%',
        });
        $('#branch_selection').select2({
            placeholder: "Select Branch",
            width: '100%'
        });

        function updateButtonText(isUserSelected) {
            const submitButton = $('input[type="submit"]');
            if (isUserSelected) {
                submitButton.val("UPDATE");
                toggleStatusControls(true);
            } else {
                submitButton.val("SAVE");
                toggleStatusControls(false);
            }
        }

        function togglePasswordRequirement(isUpdate) {
            const passwordField = $('#password');
            if (isUpdate) {
                passwordField.removeAttr('required');
                passwordField.attr('placeholder', 'Leave blank to keep current password');
            } else {
                passwordField.attr('required', 'required');
                passwordField.attr('placeholder', 'Password');
            }
        }

        $('#searchBarUser').on('input', function() {
            if (!$(this).val()) {
                reset();
            }
        });

        var currentStatus = 'active';
        function updateStatusButton(status) {
            const toggleButton = $('#toggleStatusButton');
            const statusField = $('#status');
            
            if (status === 'active') {
                toggleButton.val('DEACTIVATE').removeClass('btn-success').addClass('btn-danger');
                statusField.val('Active');
                currentStatus = 'active';
            } else {
                toggleButton.val('ACTIVATE').removeClass('btn-danger').addClass('btn-success');
                statusField.val('Inactive');
                currentStatus = 'inactive';
            }
        }
        $(document).on('click', '#toggleStatusButton', function(e) {
            e.preventDefault();
            if (currentStatus === 'active') {
                updateStatusButton('inactive');
            } else {
                updateStatusButton('active');
            }
        });
        function toggleStatusControls(showStatusButton) {
            const toggleButtonContainer = $('#toggleStatusButton').parent();
            const submitButtonContainer = $('#submitButton').parent();
            const statusField = $('#status');
            
            if (showStatusButton) {
                toggleButtonContainer.show();
                toggleButtonContainer.css('flex', '1');
                submitButtonContainer.css('flex', '1');
                statusField.val(currentStatus === 'active' ? 'Active' : 'Inactive');
            } else {
                toggleButtonContainer.hide();
                submitButtonContainer.css('flex', '2');
                statusField.val('Active');
                currentStatus = 'active';
                updateStatusButton('active');
            }
        }

        $('#systemSetupAccessibility').DataTable({
            pageLength: 1000
        });
        $('form').attr('autocomplete', 'off');
        var journalBookTbl = $('#journalBookTble').DataTable();
        var categoryFileTbl = $('#categoryFileTbl').DataTable();
        if (sessionStorage.clickNavId) {
            $('#' + sessionStorage.clickNavId).click();
        } else {
            $('#v-pills-CompanySettings-tab').click();
        }
        $(document).on('click', '.sysnav', function(e) {
            e.preventDefault();
            if (typeof(Storage) !== "undefined") {
                sessionStorage.clickNavId = $(this).attr('id');

            } else {
                alert("Sorry, your browser does not support Web Storage...");
            }
        });
        $(document).on('click', '.SearchName', function(e) {
            e.preventDefault();
            $('#searchBarUser').val($(this).attr('value'));
            $('#searchContent').html("");
            var posting = $.get("{{ route('SystemSetupController.usermasterfile.fetchInfo') }}", {
                p_id: $(this).attr('user-id')
            });
            posting.done(function(response) {
                $('.btn_plus').removeClass('d-none');
                $('.btn_minus').addClass('d-none');
                
                if (response.user_info && response.user_info.id) {
                    $('#userId').val(response.user_info.id);
                    $('#username').val(response.user_info.username);
                    var selectedBranches = [];
                    if (response.user_info.user_branch && response.user_info.user_branch.length > 0) {
                        response.user_info.user_branch.forEach(function(branch) {
                            selectedBranches.push(branch.branch_id.toString());
                        });
                    }
                    $('#branch_selection').val(selectedBranches).trigger('change');
                    $('#role_id').val(response.user_info.role_id).trigger('change');
                    var userStatus = response.user_info.status || 'active';
                    currentStatus = userStatus;
                    updateStatusButton(userStatus);
                    if (response.user_info.accessibilities) {
                        $.each(response.user_info.accessibilities, function(kk, vv) {
                            $('#btn_plus_' + vv.sml_id).addClass('d-none');
                            $('#btn_minus_' + vv.sml_id).removeClass('d-none');
                        });
                    }
                } else {
                    alert('Error: User info not found');
                    currentStatus = 'active';
                    updateStatusButton('active');
                }
                
                $('#fname').val(response.fname);
                $('#mname').val(response.mname);
                $('#lname').val(response.lname);
                $('#gender').val(response.gender).trigger('change');
                $('#displayname').val(response.displayname);
                $('#email').val(response.email_address);
                $('#phone_number').val(response.phone_number);
                updateButtonText(true);
                togglePasswordRequirement(true);
            });
        });
        $(document).on('click', '.btn-subModuleList', function(e) {
            var sml_id = $(this).attr('value');
            if ($('#userId').val() != '') {
                var posting = $.post(
                    "{{ route('SystemSetupController.usermasterfile.createOrUpdateAccessibility') }}", {
                        _token: "{{ csrf_token() }}",
                        sml_id: $(this).attr('value'),
                        user_id: $('#userId').val()
                    });
                posting.done(function(response) {
                    if (response == 'added') {
                        $('#btn_plus_' + sml_id).addClass('d-none');
                        $('#btn_minus_' + sml_id).removeClass('d-none');
                        toastr.success('Successfully Added');
                    } else if (response == 'removed') {
                        $('#btn_plus_' + sml_id).removeClass('d-none');
                        $('#btn_minus_' + sml_id).addClass('d-none');
                        toastr.success('Successfully Removed');
                    }
                });
            } else {
                alert('Error');
            }

        });

        $(document).on('submit', '#userMasterFileForm', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            formData.append('status', currentStatus);

            var selectedBranches = $('#branch_selection').val();
            if (selectedBranches && selectedBranches.length > 0) {
                formData.delete('branch_ids[]'); // Remove any existing branch_ids
                selectedBranches.forEach(function(branchId) {
                    formData.append('branch_ids[]', branchId);
                });
            }
            
            if ($('#userId').val() && !$('#password').val()) {
                formData.delete('password');
            }
            
            $.ajax({
                type: "POST",
                url: "{{ route('SystemSetupController.userMasterFile.createOrUpdate') }}",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data) {
                    if (data == 'create') {
                        $('#searchBarUser').val();
                        toastr.success('Successfully Created');
                        reset();
                    } else if (data == 'update') {
                        toastr.success('Successfully Updated');
                        reset();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var response = xhr.responseJSON;
                        toastr.error(response.message);
                        
                        if (response.message.includes('Username')) {
                            $('#username').addClass('is-invalid');
                            $('#username').one('input', function() {
                                $(this).removeClass('is-invalid');
                            });
                        } else if (response.message.includes('branch')) {
                            $('#branch_selection').next('.select2-container').find('.select2-selection').addClass('is-invalid');
                            $('#branch_selection').one('change', function() {
                                $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                            });
                        }
                    } else {
                        toastr.error('An error occurred. Please try again.');
                        console.log("Error", xhr);
                    }
                }
            });
        });

        $(document).on('submit', '#bookJournalForm', function(e) {
            e.preventDefault();
            var datastring = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('SystemSetupController.journalBook.createOrUpdate') }}",
                data: datastring,
                dataType: "json",
                success: function(result) {
                    if (result.status != "book_code_duplicate") {
                        if (result.status == 'create') {
                            toastr.success('Successfully Created');
                        } else if (result.status == 'update') {
                            toastr.success('Successfully Updated');
                            journalBookTbl.row($("button[value ='" + result.book_id + "']")
                                    .parents('tr'))
                                .remove().draw();
                            $('#bookId').val('');
                        } else {
                            toastr.error(result.message);
                        }
                        if (result.status == 'create' || result.status == 'update') {
                            journalBookTbl.row.add([
                                `<strong>${$('#book_code').val()}</strong>`,
                                $('#book_name').val(),
                                $('#book_src').val(),
                                $('#book_ref').val(),
                                $('#book_flag').val(),
                                $('#book_head').val(),
                                `<div class="row">
									<div class="col-md-4">
										<button value="${result.book_id}" vtype="edit" class="btn btn-bookA btn-info btn-sm"><i class="fa  fa-pen"></i></button>
									</div>
									<div class="col-md-4">
										<button value="${result.book_id}" vtype="delete" class="btn btn-bookA btn-danger btn-sm"><i class="fa fa-trash"></i></button>
									</div>
								</div>`
                            ]).draw().node();
                            $('#bookJournalForm')[0].reset();
                            $('#submitBtn').val('SAVE');
                        }
                    } else {
                        toastr.error('Book code already exists. Please enter a unique code.');
                    }

                },
                error: function() {
                    console.log("Error");
                }
            });
        });
        $(document).on('submit', '#categoryFileForm', function(e) {
            e.preventDefault();
            var datastring = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('SystemSetupController.categoryFile.createOrUpdate') }}",
                data: datastring,
                dataType: "json",
                success: function(result) {
                    if (result.status == 'create') {
                        toastr.success('Successfully Created');
                    } else if (result.status == 'update') {
                        toastr.success('Successfully Updated');
                        categoryFileTbl.row($("button[value ='" + result.sub_cat_id + "']")
                                .parents('tr'))
                            .remove().draw();
                        $('#catId').val('');
                    } else {
                        toastr.error(result.message);
                    }
                    if (result.status == 'create' || result.status == 'update') {
                        categoryFileTbl.row.add([
                            $('#sub_cat_code').val(),
                            $('#sub_cat_name').val(),
                            $('#sub_cat_type').val(),
                            $('#cat_description').val(),
                            `<div class="row">
								<div class="col-md-4">
									<button value="${result.sub_cat_id}" vtype="edit" class="btn btn-categoryA btn-info btn-sm"><i class="fa  fa-pen"></i></button>
								</div>
								<div class="col-md-4">
									<button value="${result.sub_cat_id}" vtype="delete" class="btn btn-categoryA btn-danger btn-sm"><i class="fa fa-trash"></i></button>
								</div>
							</div>`
                        ]).draw().node();
                        $('#categoryFileForm')[0].reset();
                    }
                },
                error: function() {
                    console.log("Error");
                }
            });
        });

        $(document).on('click', '.btn-categoryA', function(e) {
            e.preventDefault();
            var type = $(this).attr('vtype');
            var id = $(this).attr('value');

            if (type === 'edit') {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SystemSetupController.categoryFile.fetchCategoryInfo') }}",
                    data: {
                        catId: id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#catId').val(data[0].sub_cat_id);
                            $('#sub_cat_code').val(data[0].sub_cat_code);
                            $('#sub_cat_name').val(data[0].sub_cat_name);
                            $('#sub_cat_type').val(data[0].sub_cat_type);
                            $('#cat_description').val(data[0].description);
                        }
                    },
                    error: function() {
                        console.log("Error");
                    }
                });
            } else if (type === 'delete') {
                if (confirm("Are You Sure want to delete this Category ?")) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('SystemSetupController.categoryFile.deleteCategory') }}",
                        data: {
                            catId: id
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                toastr.success('Subsidiary Category Successfully Remove');
                                categoryFileTbl.row($("button[value ='" + id + "']").parents(
                                        'tr'))
                                    .remove().draw();
                            }
                        },
                        error: function() {
                            console.log("Error");
                        }
                    });
                }
            }
        })
        $(document).on('click', '.btn-bookA', function(e) {
            e.preventDefault();
            var type = $(this).attr('vtype');
            var id = $(this).attr('value');
            if (type === 'edit') {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SystemSetupController.journalBook.fetchBookInfo') }}",
                    data: {
                        bookId: id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#bookId').val(data[0].book_id);
                            $('#book_code').val(data[0].book_code);
                            $('#book_name').val(data[0].book_name);
                            $('#book_src').val(data[0].book_src);
                            $('#book_ref').val(data[0].book_ref);
                            $('#book_flag').val(data[0].book_flag);
                            $('#book_head').val(data[0].book_head);

                            $('#submitBtn').val('UPDATE');
                        }
                    },
                    error: function() {
                        console.log("Error");
                    }
                });
            } else if (type === 'delete') {
                if (confirm("Are you sure you want to delete this Journal Book?")) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('SystemSetupController.journalBook.deleteBook') }}",
                        data: {
                            bookId: id
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                toastr.success('Book Successfully Removed');
                                journalBookTbl.row($("button[value ='" + id + "']").parents(
                                        'tr'))
                                    .remove().draw();
                            }
                        },
                        error: function() {
                            console.log("Error");
                        }
                    });
                }
            }
        });
        $('#searchBarUser').keyup(function(e) {
            var value = $(this).val();
            if (value) {
                var get = $.get("{{ route('SystemSetupController.usermasterfile.searchAccount') }}", {
                    name: value
                });
                get.done(function(response) {

                    $('#searchContent').html("");
                    $.each(response, function(k, v) {
                        var lname = v.lname || '';
                        var fname = v.fname || '';
                        var mname = v.mname || '';
                        
                        var displayName = ucFirst(lname) + ' ' + ucFirst(fname) + 
                                         (mname ? ' (' + ucFirst(mname) + ')' : '');
                        
                        $('#searchContent').append(
                            '<li class="text-info list-group-item"><a href="#" class="SearchName" user-id="' +
                            v.personal_info_id + '" value="' + displayName + 
                            '" style="color:#3d9970!important;">' + displayName + '</a></li>'
                        );
                    });

                });
            } else {
                $('#userMasterFileForm')[0].reset();
                $('#searchContent').html("");
                $('.btn_plus').addClass('d-none');
                $('.btn_minus').addClass('d-none');
                updateButtonText(false);
                togglePasswordRequirement(false);
            }
        });

        function reset() {
            $('#userMasterFileForm')[0].reset();
            $('#searchContent').html("");
            $('.btn_plus').addClass('d-none');
            $('.btn_minus').addClass('d-none');
            $('#userId').val('');
            $('#searchBarUser').val('');
            $('#gender').val(null).trigger('change');
            $('#branch_selection').val(null).trigger('change');
            $('#role_id').val(null).trigger('change');
            updateButtonText(false);
            togglePasswordRequirement(false);
            updateStatusButton('active');
            toggleStatusControls(false);
            $('#username').removeClass('is-invalid');
            $('#branch_selection').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
        }

        function ucFirst(txt) {
            return txt.substring(0, 1).toUpperCase() + txt.substring(1);
        }
    })(jQuery);
</script>
