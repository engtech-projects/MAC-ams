<script type="text/javascript">

(function ($) {

    $(document).on('submit', '#journalEntryFormEdit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.prop('action');
        let formData = form.serialize();

        var posting = $.post(url, formData);
        posting.done(function(response) {

                if (response.message == 'update') {
                        toastr.success('Record has been updated');
                }
                console.log(response);
        });
    });

    $(document).on('click', '.JnalEdit', function(e) {
        e.preventDefault();

        let journal_id = $(this).attr('value');
        var container = $('#tbl-create-edit-container');
        var modal = $('#journalModalEdit');

        container.html('');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: {
                journal_id: journal_id
            },
            url: "{{ route('journal.JournalEntryFetch') }}",
            dataType: "json",
            success: function(response) {

                    if (response.message == 'fetch') {

                        let data = response.data;
                        let journal = data[0] ;
                        let total_debit = 0;
                        let total_credit = 0;
                        let balance = 0;

                        fillEntry(journal);

                        $.each(journal.journal_entry_details, function(index, entry) {

                            let row = journalDetailsTemplate(entry);
                            total_debit += parseFloat(entry.journal_details_debit);
                            total_credit += parseFloat(entry.journal_details_credit);

                            container.append($(row));
                            // display values for (select) account and subsidiary
                            $(`select#account_${entry.journal_details_id}`).val(entry.account_id);
                            $(`select#subsidiary_${entry.journal_details_id}`).val(entry.subsidiary_id);
                            $(`select#account_${entry.journal_details_id}`).select2({
                                placeholder: 'Select Account',
                                allowClear: true,
                            });
                            $(`select#subsidiary_${entry.journal_details_id}`).select2({
                                placeholder: 'Select Stakeholder',
                                allowClear: true,
                            });

                        });

                        balance = total_debit-total_credit;
                        $('#edit_total_debit').text(formatNumber(total_debit))
                        $('#edit_total_credit').text(formatNumber(total_credit))
                        $('#edit_balance_debit').text(formatNumber(balance));

                        
                        
                    }

            },
            error: function() {
                console.log("Error");
            }
        });

        modal.modal('show');

    });

    $(document).on('submit', '#SearchJournalForm', function(e){
        e.preventDefault();

        var button = $(this);
        var formData = $(this).serialize();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: "{{ route('journal.searchJournalEntry') }}",
            data: formData,
            dataType: "json",
            success: function(data) {
                $('#journalEntryDetails').DataTable().destroy();
                var container = $('#journalEntryDetailsContent');
                container.html('');

                $.each(data, function(k, v) {
        
                    let status = (v.status == 'posted') ? 'text-success' : 'text-danger';
                    let disabled = (v.status == 'posted') ? 'disabled' : '';

                    let row = journalRowTemplate(v, status, disabled);
                    container.append(row);

                });
 
                $('#journalEntryDetails').DataTable();
            },
            error: function(data) {
                console.log('error');
                toastr.error('Error');
            }
        });
    });

    function journalRowTemplate(journal, status, disabled) {
        let template = `
        <tr>
                <td>${journal.journal_date}</td>
                <td class="font-weight-bold">${journal.book_details.book_code}</td>
                <td>${journal.journal_no}</td>
                <td>${journal.source}</td>
                <td class="text-right">${journal.amount}</td>
                <td>${journal.remarks}</td>
                <td>${journal.branch_name}</td>
                <td class="text-danger"><b>${journal.status}</b></td>
                <td>
                        <button value="${journal.journal_id}" ${disabled} class="btn btn-flat btn-xs bg-gradient-danger jnalDelete"><i class="fa fa-trash"></i></button>
                        <button value="${journal.journal_id}" class="btn btn-flat btn-xs JnalView bg-gradient-primary"><i class="fa fa-eye"></i></button>
                        <button value="${journal.journal_id}" ${disabled} class="btn btn-flat btn-xs JnalEdit bg-gradient-info"><i class="fa fa-edit"></i></button>
                        <button value="${journal.journal_id}" class="btn btn-flat btn-xs bg-gradient-success stStatus"><i class="fa fa-check"></i></button>
                </td>
        </tr>
        `;

        return template;
    }

    function fillEntry(journal) {

        $('#edit_LrefNo').text(journal.journal_no);
        $('#edit_journal_no').val(journal.journal_no);
        $('#edit_journal_id').val(journal.journal_id);
        $('#edit_journal_date').val(journal.journal_date);
        $('#edit_branch_id').val(journal.branch_id);
        $('#edit_book_id').val(journal.book_id);
        $('#edit_source').val(journal.source);
        $('#edit_cheque_no').val(journal.cheque_no);
        $('#edit_cheque_date').val(journal.cheque_date);
        $('#edit_status').val(journal.status);
        $('#edit_amount').val(journal.amount);
        $('#edit_payee').val(journal.payee);
        $('#edit_remarks').val(journal.remarks);
    }

    function journalDetailsTemplate(entry) {

        let row = `
        <tr class="editable-table-row">
            <td class="acctnu" value="" >
                <a href="#" class="editable-row-item journal_details_account_no">${entry.account.account_number}</a>
            </td>
            <td class="editable-table-data">
                <select fieldName="account_id" id="account_${entry.journal_details_id}" class="form-control form-control-sm editable-row-item COASelect">
                        <option disabled value="" selected>-Select Account Name-</option>
                        @foreach ($chartOfAccount as $account)
                        <option value="{{ $account->account_id }}" acct-num="{{ $account->account_number }}">
                            {{$account->account_name}}
                        </option>
                        @endforeach
                </select>
            </td>
            <td class="editable-table-data text-right">
                    <a href="#" fieldName="journal_details_debit" class="editable-row-item">
                        ${parseFloat(entry.journal_details_debit).toLocaleString(undefined, { minimumFractionDigits: 2 }) }
                    </a>
            </td>
            <td class="editable-table-data text-right">
                    <a href="#" fieldName="journal_details_credit" class="editable-row-item">
                        ${parseFloat(entry.journal_details_credit).toLocaleString(undefined, { minimumFractionDigits: 2 })}
                    </a>
            </td>
            <td class="editable-table-data">
                <select fieldName="subsidiary_id" id="subsidiary_${entry.journal_details_id}" class="form-control form-control-sm editable-row-item edit_subsidiary_item" value="">
                    @foreach ($subsidiaries as $subsidiary)
                        <option value="{{ $subsidiary->sub_id }}">{{ $subsidiary->sub_name }}</option>
                     @endforeach
                 </select>
            </td>
            <td>
                <button class="btn btn-secondary btn-flat btn-sm btn-default remove-journalDetails">
                      <span><i class="fas fa-trash" aria-hidden="true"></i></span>
                </button>
            </td>
        </tr>
        `;

        return row;      
    }

    function formatNumber(num) {
        return Number(num).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    

})(jQuery);
</script>