<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
    (function($) {
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

                $.each(JSON.parse(response), function(k, v) {
                    $('#userId').val(v.user_info.id);
                    $('#fname').val(v.fname);
                    $('#mname').val(v.mname);
                    $('#lname').val(v.lname);
                    $('#gender').val(v.gender);
                    $('#displayname').val(v.displayname);
                    $('#email').val(v.email_address);
                    $('#phone_number').val(v.phone_number);
                    $('#username').val(v.user_info.username);

                    $.each(v.user_info.accessibilities, function(kk, vv) {
                        $('#btn_plus_' + vv.sml_id).addClass('d-none');
                        $('#btn_minus_' + vv.sml_id).removeClass('d-none');
                    });
                });


            });
        })
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
                alert('no student selected');
            }

        });


        $(document).on('submit', '#userMasterFileForm', function(e) {
            e.preventDefault();
            var datastring = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('SystemSetupController.userMasterFile.createOrUpdate') }}",
                data: datastring,
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
                error: function() {
                    console.log("Error");
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
                    $.each(JSON.parse(response), function(k, v) {
                        $('#searchContent').append(
                            '<li class="text-info list-group-item"><a href="#" class="SearchName" user-id="' +
                            v.personal_info_id + '" value="' + ucFirst(v.lname) + ' ' +
                            ucFirst(v.fname) + ' (' + ucFirst(v.mname) +
                            ')" style="color:#3d9970!important; href="#">' + ucFirst(v
                                .lname) + ' ' + ucFirst(v.fname) + ' (' + ucFirst(v
                                .mname) + ')</a></li>');
                    });

                });
            } else {
                $('#userMasterFileForm')[0].reset();
                $('#searchContent').html("");
                $('.btn_plus').addClass('d-none');
                $('.btn_minus').addClass('d-none');
            }
        });

        function reset() {
            $('#userMasterFileForm')[0].reset();
            $('#searchContent').html("");
            $('.btn_plus').addClass('d-none');
            $('.btn_minus').addClass('d-none');
            $('#userId').val('');
            $('#searchBarUser').val('');
        }

        function ucFirst(txt) {
            return txt.substring(0, 1).toUpperCase() + txt.substring(1);
        }
    })(jQuery);
</script>
