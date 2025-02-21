@extends('layouts.app')

@section('content')
    <style type="text/css">
        .frm-header {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4ec891;
        }

        .search-custom {
            display: block;
            position: absolute;
            z-index: 999;
            width: 100%;
            margin: 0px !important;
            color: #3d9970 !;
            font-weight: bold;
            font-size: 14px;
        }

        .dataTables_filter {
            float: right !important;
        }

        .total-count {
            background: #4ec891
        }

        .table-header {
            font-size: 11px;

        }

        @media print {
            body {
                margin: 10px !important;
            }

            .no-print,
            .toast {
                display: none;
            }

            .table td {
                padding: 1px !important;
            }

            .page-break {
                page-break-before: always;
            }

            #to-print {
                display: block;
            }
        }

        .editable-container.editable-inline,
        .editable-container.editable-inline .control-group.form-group,
        .editable-container.editable-inline .control-group.form-group .editable-input,
        .editable-container.editable-inline .control-group.form-group .editable-input textarea,
        .editable-container.editable-inline .control-group.form-group .editable-input select,
        .editable-container.editable-inline .control-group.form-group .editable-input input:not([type=radio]):not([type=checkbox]):not([type=submit]) {
            width: 100%;
        }

        .select2 {
            width: 100% !important;
        }
    </style>

    <!-- Main content -->

    <section class="content" id="app">
        <div id="to-print">
        </div>
        <div class="container-fluid no-print" style="padding:32px;background-color:#fff;min-height:900px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 frm-header">
                            <h4><b>Cashier's Transaction Blotter</b></h4>

                        </div>
                    </div>
                    <div class="row">
                        @if (Gate::allows('manager'))
                            <div class="col-md-4">
                                <label for="branch">Select Branch</label>
                                <select-branch @setselectedbranch="getSelectedBranch" />
                            </div>
                        @endif
                        <div class="col-md-4">
                            <label for="branch">Transaction Date</label>
                            <div class="input-group">
                                <input type="date" v-model="filter.transaction_date" id="transaction_date"
                                    name="transaction_date" class="form-control form-control-sm">
                            </div>

                        </div>
                        <div class="col-md-2">
                            <div class="mt-4 text-left">
                                <button @click="filterCollections()" class="btn btn-success">Search</button>
                            </div>
                        </div>

                        @if (Gate::allows(['accounting-staff']) || Gate::allows(['manager']))
                            <div class="col-md-{{ Gate::allows(['accounting-staff']) ? '6' : '2' }}"
                                @click="processCreateCollection()">
                                <div class="mt-4 text-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#Mymodal">New
                                        Transaction</button>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>

            </div>


            <div class="modal fade bd-example-modal-lg" id="Mymodal" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">

                <div class="modal-dialog modal-xl">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create Transaction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 frm-header" style="padding:10px;">
                                    <h4 id="title"><b></b></h4>
                                </div>
                            </div>

                            <div class="row" style="margin-left:15px;">
                                @if (Gate::allows(['manager']))
                                    <div class="col-md-3">
                                        <label for="branch">Select Branch</label>
                                        <select name="branch_id" v-model="collectionBreakdown.branch_id"
                                            class="select2 form-control form-control-sm" style="width:100%" id="branchID">
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->branch_id }}">
                                                    {{ $branch->branch_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- <select name="branch_id" id="branch_id" v-model="branch"
                                                class="select2 form-control form-control-sm" required>
                                                <option value="" disabled selected v-text="branch"></option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                                    </option>
                                                @endforeach
                                            </select> --}}
                                    </div>
                                @endif
                                <div class="col-md-3">
                                    <label for="transactionDate">Transaction Date</label>
                                    <div class="input-group">
                                        <input type="date" name="transaction_date"
                                            v-model="collectionBreakdown.transaction_date"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>


                            <div class="container pl-4">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="row">

                                            <table class="table table-sm cash-breakdown-tbl">
                                                <thead>
                                                    <th class="table-header">Cash Breakdown</th>
                                                    <th class="table-header">Pcs.</th>
                                                    <th class="table-header">Total Amount</th>
                                                </thead>
                                                <tbody>
                                                    <tr class="cash-breakdown">
                                                        <td>₱1000.00</td>
                                                        <td><input type="number" v-model="collectionBreakdown.p_1000"
                                                                ref="p_1000" @keydown.enter="nextTextField('p_500')"
                                                                name="p_1000" id="onethousand"
                                                                class="form-control form-control-sm pcs" required>
                                                        </td>
                                                        <td id="onethousandtotalamount" class="total">
                                                            <h6 v-text="total.p_1000"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr class="cash-breakdown">
                                                        <td>₱500.00</td>
                                                        <td><input type="number" v-model="collectionBreakdown.p_500"
                                                                name="p_500" ref="p_500" id="fivehundred"
                                                                @keydown.enter="nextTextField('p_200')"
                                                                class="form-control form-control-sm pcs" required>
                                                        </td>
                                                        <td id="fivehundredtotalamount" class="total">
                                                            <h6 v-text="total.p_500"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr class="cash-breakdown">
                                                        <td>₱200.00</td>
                                                        <td><input type="number" v-model="collectionBreakdown.p_200"
                                                                name="p_200" ref="p_200" id="twohundred"
                                                                @keydown.enter="nextTextField('p_100')"
                                                                class="form-control form-control-sm" required></td>
                                                        <td id="twohundredtotalamount" class="total">
                                                            <h6 v-text="total.p_200"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr class="cash-breakdown">
                                                        <td>₱100.00</td>
                                                        <td><input type="number" v-model="collectionBreakdown.p_100"
                                                                name="p_100" ref="p_100" id="onehundred"
                                                                @keydown.enter="nextTextField('p_50')"
                                                                class="form-control form-control-sm" required></td>
                                                        <td id="onehundredtotalamount" class="total">
                                                            <h6 v-text="total.p_100"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr class="cash-breakdown">
                                                        <td>₱50.00</td>
                                                        <td><input type="number" v-model="collectionBreakdown.p_50"
                                                                name="p_50" ref="p_50" id="fifty"
                                                                @keydown.enter="nextTextField('p_20')"
                                                                class="form-control form-control-sm" required></td>
                                                        <td id="fiftytotalamount" class="total">
                                                            <h6 v-text="total.p_50"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr class="cash-breakdown">
                                                        <td>₱20.00</td>
                                                        <td><input type="number" v-model="collectionBreakdown.p_20"
                                                                name="p_20" id="twenty" ref="p_20"
                                                                @keydown.enter="nextTextField('p_10')"
                                                                class="form-control form-control-sm" required></td>
                                                        <td id="twentytotalamount" class="total">
                                                            <h6 v-text="total.p_20"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr class="cash-breakdown">
                                                        <td>₱10.00</td>
                                                        <td><input type="number" v-model="collectionBreakdown.p_10"
                                                                name="p_10" id="ten" ref="p_10"
                                                                @keydown.enter="nextTextField('p_5')"
                                                                class="form-control form-control-sm" required></td>
                                                        <td id="tentotalamount" class="total">
                                                            <h6 v-text="total.p_10"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr class="cash-breakdown">
                                                        <td>₱5.00</td>
                                                        <td><input type="number" v-model="collectionBreakdown.p_5"
                                                                name="p_5" id="five" ref="p_5"
                                                                @keydown.enter="nextTextField('p_1')"
                                                                class="form-control form-control-sm" required></td>
                                                        <td id="fivetotalamount" class="total">
                                                            <h6 v-text="total.p_5"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr class="cash-breakdown">
                                                        <td>₱1.00</td>
                                                        <td><input type="number" v-model="collectionBreakdown.p_1"
                                                                name="p_1" id="one" ref="p_1"
                                                                @keydown.enter="nextTextField('c_25')"
                                                                class="form-control form-control-sm" required></td>
                                                        <td id="onetotalamount" class="total">
                                                            <h6 v-text="total.p_1"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr class="cash-breakdown">
                                                        <td>₱0.25</td>
                                                        <td><input type="number" v-model="collectionBreakdown.c_25"
                                                                name="c_25" id="centavo" ref="c_25"
                                                                class="form-control form-control-sm" required></td>
                                                        <td id="centavototalamount" class="total">
                                                            <h6 v-text="total.c_25"></h6>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-primary">
                                                        <td class="text-uppercase">
                                                            Total
                                                        </td>
                                                        <td class="text-right" colspan="2" id="totalcashcount"
                                                            v-text="totalCash">
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-12 col-sm-12">

                                            <table class="table table-bordered table-sm"
                                                id="account-officer-table-collection">
                                                <thead class="table-header">
                                                    <tr>
                                                        <th width="200">Account Officer</th>
                                                        <th>Remarks</th>
                                                        <th>Total Amount</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-if="isEdit">
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="accountofficer_id"
                                                                v-model="officer_collection.representative">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="remarks"
                                                                class="form-control form-control-sm rounded-0"
                                                                v-model="officer_collection.note" name="remarks"
                                                                form="frm-add-account-officer-details"
                                                                placeholder="Remarks">
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                class="form-control form-control-sm rounded-0 text-right"
                                                                id="total_amount" placeholder="0.00"
                                                                v-model="officer_collection.total">
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-xs btn-primary"
                                                                @click="addAccountOfficerCollection()">
                                                                <i class="fas fa-plus fa-xs"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="isEdit"
                                                        v-for="officerCollection in collectionBreakdown.account_officer_collections">
                                                        <td>
                                                            <h6 v-text="officerCollection.representative"></h6>
                                                        </td>
                                                        <td>
                                                            <h6 v-text="officerCollection.note"></h6>

                                                        </td>
                                                        <td>
                                                            <h6 v-text="officerCollection.total"></h6>
                                                        </td>
                                                        <td class="text-center">
                                                            {{-- <button type="button"
                                                                    id="btn-add-account-officer-collection"
                                                                    class="btn btn-xs btn-danger add-accounting-officer">
                                                                    <i class="fas fa-trash fa-xs"></i>
                                                                </button> --}}
                                                            <button class="btn btn-xs btn-danger"
                                                                @click="removeAccountOfficerCollection(officerCollection)">
                                                                <i class="fas fa-trash fa-xs"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="!isEdit">
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm"
                                                                v-model="officer_collection.representative"
                                                                id="accountofficer_id">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="remarks"
                                                                class="form-control form-control-sm rounded-0"
                                                                v-model="officer_collection.note" name="remarks"
                                                                form="frm-add-account-officer-details"
                                                                placeholder="Remarks">
                                                        </td>
                                                        <td>
                                                            <input type="number" v-model="officer_collection.total"
                                                                class="form-control form-control-sm rounded-0 text-right"
                                                                id="total_amount" placeholder="0.00">
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-xs btn-primary"
                                                                @click="addAccountOfficerCollection()">
                                                                <i class="fas fa-plus fa-xs"></i>
                                                            </button>

                                                        </td>
                                                    </tr>
                                                    <tr v-if="!isEdit"
                                                        v-for="(officerCollection,i) in collectionBreakdown.account_officer_collections">
                                                        <td>
                                                            <div v-if="officerCollection.isEditing">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    v-model="officerCollection.representative"
                                                                    id="accountofficer_representative">

                                                            </div>
                                                            <div v-else>
                                                                <h6 v-text="officerCollection.representative"></h6>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div v-if="officerCollection.isEditing">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    v-model="officerCollection.note"
                                                                    id="accountofficer_note">

                                                            </div>
                                                            <div v-else>
                                                                <h6 v-text="officerCollection.note"></h6>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <div v-if="officerCollection.isEditing">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    v-model="officerCollection.total"
                                                                    id="accountofficer_total">

                                                            </div>
                                                            <div v-else>
                                                                <h6 v-text="officerCollection.total"></h6>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <button v-if="!isEditing"
                                                                        class="btn btn-xs btn-success"
                                                                        @click="editOfficerCollection(i)">
                                                                        <i class="fas fa-pen fa-xs"></i>
                                                                    </button>

                                                                    <button v-else class="btn btn-xs btn-success"
                                                                        @click="saveOfficerCollection(i)">
                                                                        <i class="fas fa-save fa-xs"></i>
                                                                    </button>

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <button class="btn btn-xs btn-danger">
                                                                        <i class="fas fa-trash fa-xs"
                                                                            @click="removeAccountOfficerCollection(officerCollection)"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr id="footer-row">
                                                        <!-- <td colspan="7"></td> -->
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-primary">
                                                        <td class="text-uppercase">
                                                            total
                                                        </td>
                                                        <td class="text-right" colspan="3"
                                                            id="totalaccountofficercollection" v-text='aoCollectionTotal'>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>


                                        </div>

                                        <div class="col-md-12">
                                            <table class="table table-bordered table-sm" id="account-officer-table">
                                                <thead class="table-header">
                                                    <tr>
                                                        <th width="200">Branch Collection</th>
                                                        <th>Total Amount</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select class="form-control form-control-sm rounded-0"
                                                                id="branch_id_collection"
                                                                v-model="branch_collection.branch_name">
                                                                <option value="" disabled selected>-Select
                                                                    Branch-</option>
                                                                @foreach ($branches as $branch)
                                                                    <option value="{{ $branch->branch_id }}">
                                                                        {{ $branch->branch_name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" v-model="branch_collection.total_amount"
                                                                class="form-control form-control-sm rounded-0 text-right"
                                                                id="branchcollection_amount">
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-xs btn-primary"
                                                                @click="addBranchCollection()">
                                                                <i class="fas fa-plus fa-xs"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="isEdit"
                                                        v-for="(branchCollection,i) in collectionBreakdown.branch_collections">
                                                        <td>
                                                            <h6 v-text="branchCollection.branch.branch_name"
                                                                value="branchCollection.branch.branch_id"></h6>
                                                        </td>
                                                        <td class="text-right">
                                                            <h6 v-text="branchCollection.total_amount"></h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-xs btn-danger"
                                                                @click="removeBranchCollection(branchCollection,i)">
                                                                <i class="fas fa-trash fa-xs"></i>
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    <tr v-if="!isEdit"
                                                        v-for="(branchCollection,i) in collectionBreakdown.branch_collections">
                                                        <td>
                                                            <div v-if="branchCollection.isEditing">

                                                                <select class="form-control form-control-sm rounded-0"
                                                                    id="branch_id_collection_edit"
                                                                    v-model="branchCollection.branch.branch_id">
                                                                    <option value="" disabled selected>-Select
                                                                        Branch-</option>
                                                                    @foreach ($branches as $branch)
                                                                        <option value="{{ $branch->branch_id }}">
                                                                            {{ $branch->branch_name }}</option>
                                                                    @endforeach

                                                                </select>


                                                            </div>
                                                            <div v-else>
                                                                <h6 v-text="branchCollection.branch.branch_name"></h6>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div v-if="branchCollection.isEditing">
                                                                <input type="number" class="form-control form-control-sm"
                                                                    v-model="branchCollection.total_amount">

                                                            </div>
                                                            <div v-else>
                                                                <h6 v-text="branchCollection.total_amount"></h6>
                                                            </div>

                                                        </td>



                                                        <td class="text-center">

                                                            <button v-if="!isEditing" class="btn btn-xs btn-success"
                                                                @click="editBranchCollection(i,branchCollection)">
                                                                <i class="fas fa-pen fa-xs"></i>
                                                            </button>

                                                            <button v-else class="btn btn-xs btn-success"
                                                                @click="saveBranchCollection(i,branchCollection.branch.branch_id)">
                                                                <i class="fas fa-save fa-xs"></i>
                                                            </button>


                                                            <button class="btn btn-xs btn-danger">
                                                                <i class="fas fa-trash fa-xs"
                                                                    @click="removeBranchCollection(branchCollection,i)"></i>
                                                            </button>

                                        </div>
                                        </td>
                                        </tr>

                                        <tr style="background-color: #f1f1f1;" id="branch-collection-row">
                                            <!-- <td colspan="7">&nbsp;</td> -->
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-primary">
                                                <td class="text-uppercase">
                                                    total
                                                </td>
                                                <td class="text-right" colspan="3" id="totalbranchcollection"
                                                    v-text="branchCollectionTotal">
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>

                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-sm" id="account-officer-table">
                                            <thead>

                                                <th colspan="2"> Other Payment</th>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>CASH</p>
                                                    </td>
                                                    <td class="text-right" v-text='aoCollectionTotal'>
                                                    </td>

                                                </tr>
                                                <tr>

                                                    <td>
                                                        <p>CHECK</p>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="number"
                                                            v-model="collectionBreakdown.other_payment.check_amount"
                                                            class="form-control form-control-sm rounded-0 text-right"
                                                            required placeholder="0.00">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <p>POS</p>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="number"
                                                            v-model="collectionBreakdown.other_payment.pos_amount"
                                                            class="form-control form-control-sm rounded-0 text-right"
                                                            required placeholder="0.00">

                                                    </td>
                                                </tr>

                                                <tr>

                                                    <td>
                                                        <p>MEMO</p>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="number"
                                                            v-model="collectionBreakdown.other_payment.memo_amount"
                                                            class="form-control form-control-sm rounded-0 text-right"
                                                            required placeholder="0.00">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        INTERBRANCH
                                                    </td>
                                                    <td class="text-right" v-text='branchCollectionTotal'>
                                                    </td>
                                                </tr>
                                                <tr class="bg-primary">
                                                    <td class="text-uppercase">
                                                        total
                                                    </td>
                                                    <td class="text-right" colspan="3" v-text="otherPaymentTotal">
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="text-right">

                                        {{--                                         <button type="button" @click="resetForm()" class="btn btn-warning"
                                                style="margin-bottom: 20px;">
                                                Cancel
                                            </button> --}}

                                        <button type="button" @click="processCreateOrUpdate()" class="btn btn-success"
                                            style="margin-bottom: 20px;"> Save</button>
                                    </div>




                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>


        <div class="row">
            <div class="col-md-12 mt-5">
                <table id="cash-blotter-tbls" class="table table-sm table-bordered">
                    <thead>
                        <th>Branch</th>
                        <th>Transaction Date</th>
                        <th>Cash Ending Balance</th>
                        <th>Total Branch Collection</th>
                        <th> Difference (+/-) </th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr v-for="d in collectionsBreakdown">
                            <td>@{{ getBranchName(d.branch_id) }}</td>
                            <td>@{{ d.transaction_date }}</td>
                            <td>@{{ formatCurrency(d.cash_ending_balance) }}</td>
                            <td>@{{ formatCurrency(d.total) }}</td>
                            <td>@{{ formatCurrency(d.cash_ending_balance - d.total) }}</td>
                            <td>@{{ d.status }}</td>
                            <td>
                                <button @click="showCashBlotter(d.collection_id, d.branch_id)"
                                    class="mr-1 btn btn-xs btn-success">
                                    <i class="fas fa-xs fa-eye" data-toggle="modal"
                                        data-target="#cashBlotterPreviewModal"></i>
                                </button>
                                <button @click="editCollectionBreakdown(d)" class="mr-1 btn btn-xs btn-warning">
                                    <i class="fas fa-xs fa-pen" data-toggle="modal" data-target="#Mymodal"></i>
                                </button>
                                <button @click="deleteCollectionBreakdown(d.collection_id, d.branch_id)"
                                    class="mr-1 btn btn-xs btn-danger">
                                    <i class="fas fa-xs fa-trash"></i>
                                </button>

                                <button class="mr-1 btn btn-xs btn-primary">
                                    <i class="fas fa-xs fa-download download-cashblotter"></i>
                                </button>
                                <button class="mr-1 btn btn-xs btn-default">
                                    <i class="fas fa-xs fa-print print-cashblotter"></i>
                                </button>
                                @if (Gate::allows('manager'))
                                <button class="mr-1 btn btn-xs btn-primary"
                                    @click="updateStatus(d,'posted')">Post</button>
                                <button class="mr-1 btn btn-xs btn-warning"
                                    @click="updateStatus(d,'unposted')">Unpost</button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        <div class="modal fade" id="cashBlotterPreviewModal" tabindex="2" role="dialog"
            aria-labelledby="JDetailsVoucherLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body" id="printContent">
                        <div class="container-fluid ">
                            <div id="ui-view">
                                <div class="card">
                                    <div class="card-body" id="journal_toPrintVouch">
                                        <link rel="stylesheet"
                                            href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
                                        <link rel="stylesheet"
                                            href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
                                        <link rel="stylesheet" href="{{ asset('css/adminlte/adminlte.min.css') }}">
                                        <div class="col-md-12">
                                            <img src="{{ asset('img/mac_header.fw.png') }}" alt="mac_logo"
                                                class="img img-fluid">
                                        </div>
                                        <div class="col-md-12">
                                            <h3 style="text-align:center">Cashier's Transaction Blotter</h3>
                                        </div>
                                        <div class="row" style="padding-top:10px; border-bottom:10px solid gray;">
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Transaction Date: &nbsp;&nbsp;&nbsp; <strong
                                                            id="">@{{ formatDate(collections.transaction_date) }}</strong></h6>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h6 class="mb-4">Branch: &nbsp;&nbsp;&nbsp; <strong
                                                            id="">@{{ getBranchName(collections.branch_id) }}</strong></h6>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive-sm" style="padding-top:5px;">
                                    <table class="table table-striped" style="border-top:4px dashed black;">
                                        <thead>
                                            <tr>
                                                <th class="center">DATE</th>
                                                <th>REFERENCE</th>
                                                <th>REFERENCE NAME</th>
                                                <th>SOURCE</th>
                                                <th>CHK DATE</th>
                                                <th>CHK NO.</th>
                                                <th class="center">CASH IN</th>
                                                <th class="right">CASH OUT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="fb in filteredCashBlotter.rows">
                                                <td v-for="f in fb" v-html="f"></td>
                                            </tr>

                                            <tr style="border-top:4px dashed black;border-bottom:4px dashed black;">
                                                <td><strong>TOTAL</strong></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>@{{ formatCurrency(filteredCashBlotter.total.cashin) }}</strong></td>
                                                <td><strong>@{{ formatCurrency(filteredCashBlotter.total.cashout) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table class="table table-striped">
                                                <thead>
                                                    <th>Cash Breakdown</th>
                                                    <th>Pc(s)</th>
                                                    <th>Total Amount</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1,000.00</td>
                                                        <td>@{{ collections.p_1000 }}</td>
                                                        <td>@{{ formatCurrency(1000 * parseFloat(collections.p_1000)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>500.00</td>
                                                        <td>@{{ collections.p_500 }}</td>
                                                        <td>@{{ formatCurrency(500 * parseFloat(collections.p_500)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>200.00</td>
                                                        <td>@{{ collections.p_200 }}</td>
                                                        <td>@{{ formatCurrency(200 * parseFloat(collections.p_200)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>100.00</td>
                                                        <td>@{{ collections.p_100 }}</td>
                                                        <td>@{{ formatCurrency(100 * parseFloat(collections.p_100)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>50.00</td>
                                                        <td>@{{ collections.p_50 }}</td>
                                                        <td>@{{ formatCurrency(50 * parseFloat(collections.p_50)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20.00</td>
                                                        <td>@{{ collections.p_20 }}</td>
                                                        <td>@{{ formatCurrency(20 * parseFloat(collections.p_20)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10.00</td>
                                                        <td>@{{ collections.p_10 }}</td>
                                                        <td>@{{ formatCurrency(10 * parseFloat(collections.p_10)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5.00</td>
                                                        <td>@{{ collections.p_5 }}</td>
                                                        <td>@{{ formatCurrency(5 * parseFloat(collections.p_5)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1.00</td>
                                                        <td>@{{ collections.p_1 }}</td>
                                                        <td>@{{ formatCurrency(1 * parseFloat(collections.p_1)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>0.25</td>
                                                        <td>@{{ collections.c_25 }}</td>
                                                        <td>@{{ formatCurrency(0.25 * parseFloat(collections.c_25)) }}</td>
                                                    </tr>
                                                    <tr style="border-top:4px dashed black;">
                                                        <td><strong>TOTAL CASH COUNT</strong></td>
                                                        <td></td>
                                                        <td><strong>@{{ formatCurrency(parseFloat(collections.total)) }}</strong></td>
                                                    </tr>
                                                    <tr style="border-bottom:4px dashed black;">
                                                        <td><strong>TOTAL OTHERS</strong></td>
                                                        <td></td>
                                                        <td><strong>0.00</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>TOTAL RECEIVED</strong></td>
                                                        <td></td>
                                                        <td><strong>@{{ formatCurrency(0 + parseFloat(collections.total)) }}</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <table class="table table-striped">
                                                <thead>
                                                    <th>Account Officer</th>
                                                    <th>Amount</th>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="officer in collections.account_officer_collections">
                                                        <td>@{{ officer.representative }} ; @{{ officer.note }}</td>
                                                        <td>@{{ formatCurrency(officer.total) }}</td>
                                                    </tr>

                                                    <tr
                                                        style="border-top:4px dashed black;border-bottom:4px dashed black;">
                                                        <td><strong>TOTAL COLLECTION</strong></td>
                                                        <td><strong>@{{ formatCurrency(collections.total_accountofficer) }}</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-striped">
                                                <thead>
                                                    <th class="text-uppercase text-bold">Other Payments</th>
                                                    <th>Amount</th>
                                                </thead>
                                                <tbody class="text-uppercase">
                                                    <tr>
                                                        <td>Cash</td>
                                                        <td v-text="otherPayment.cash_amount"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>check</td>
                                                        <td v-text="otherPayment.check_amount"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>pos</td>
                                                        <td v-text="otherPayment.pos_amount"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>memo</td>
                                                        <td v-text="otherPayment.memo_amount"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>interbranch</td>
                                                        <td v-text="otherPayment.interbranch_amount"></td>
                                                    </tr>


                                                    <tr
                                                        style="border-top:4px dashed black;border-bottom:4px dashed black;">
                                                        <td><strong>TOTAL</strong></td>
                                                        <td v-text="otherPayment.total"><strong></strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="col-md-4">
                                            <table class="table table-striped">
                                                <thead>
                                                    <th>Interbranch</th>
                                                    <th>Amount</th>
                                                </thead>
                                                <tbody class="text-uppercase">
                                                    <tr v-for="bc in collections.branch_collections">
                                                        <td class="text-bold" v-text="bc.branch.branch_name"></td>
                                                        <td v-text="bc.total_amount"></td>
                                                    </tr>
                                                    <tr
                                                        style="border-top:4px dashed black;border-bottom:4px dashed black;">
                                                        <td><strong>TOTAL</strong></td>
                                                        <td><strong>@{{ total_interbranch_collection }}</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: 24px;">
                                    <p style="font-size:16px;"><span style="padding-left:32px">I HEREBY CERTIFY that the
                                            above total cash and COCI is in my possession as my CASH ON HAND.</span>
                                        <span>As Branch Cashier I am aware the the said amount is my cash accountability to
                                            MICRO ACCESS LOAN CORP.</span>
                                    </p>
                                    <div style="display:flex;margin-top:45px;">
                                        <div
                                            style="flex:1;border-bottom:1px solid #000;margin-right:32px;padding-bottom:32px;">
                                            <span>Prepared By:</span>
                                        </div>
                                        <div
                                            style="flex:1;border-bottom:1px solid #000;margin-right:32px;padding-bottom:32px;">
                                            <span>Certified Corrected By:</span>
                                        </div>
                                        <div
                                            style="flex:1;border-bottom:1px solid #000;margin-right:32px;padding-bottom:32px;">
                                            <span>Approved By:</span>
                                        </div>
                                        <div style="flex:1">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-5">
                                    </div>
                                    <div class="col-lg-4 col-sm-5 ml-auto">

                                        <div>
                                            <button @click="print" class="btn btn-success float-right no-print"
                                                data-dismiss="modal" style="padding:5px 32px">Print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    @include('includes.branches')
    <script>
        new Vue({
            el: '#app',
            data: {
                data: @json($cash_blotter),
                accountOfficers: @json($account_officers),
                baseUrl: window.location.protocol + "//" + window.location.host + "/MAC-ams",
                branches: null,
                branch: null,
                filter: {
                    transaction_date: "", //'2024-11-30',
                    branch_id: null,
                },
                isEdit: false,
                isEditing: false,
                isUpdateStatus: false,
                result: {},
                entries: {
                    begining_balance: {},
                    cash_received: [],
                    cash_paid: [],
                    non_cash_received: [],
                    pos_payment: [],
                    check_payment: [],
                    pdc_deposit: [],
                    interbranch: [],
                    coci_beginning_balance: [],
                    coci_received: [],
                    coci_encashment: [],
                },
                officer_collection: {
                    representative: '',
                    note: '',
                    total: 0,
                },
                branch_collection: {
                    total_amount: 0,
                    branch_id: null,
                    branch: ''
                },
                other_payment: {
                    cash_amount: 0,
                    check_amount: 0,
                    pos_amount: 0,
                    memo_amount: 0,
                    interbranch_amount: 0,
                    total: 0
                },
                collectionBreakdown: {
                    total: 0,
                    collection_id: 0,
                    branch_id: null,
                    transaction_date: "",
                    p_1000: null, //34,
                    p_500: null, //1,
                    p_200: null,
                    p_100: null, //1,
                    p_50: null,
                    p_20: null,
                    p_10: null,
                    p_5: null,
                    p_1: null, //4,
                    c_25: null,
                    total: null,
                    flag: "",
                    account_officer_collections: [],
                    branch_collections: [],
                    other_payment: {
                        cash_amount: 0,
                        check_amount: 0,
                        pos_amount: 0,
                        memo_amount: 0,
                        interbranch_amount: 0,
                        total: 0
                    }
                },
                isValid: true,
                total: {
                    grandTotal: 0,
                    p_1000: 0,
                    p_500: 0,
                    p_200: 0,
                    p_100: 0,
                    p_50: 0,
                    p_20: 0,
                    p_10: 0,
                    p_5: 0,
                    p_1: 0,
                    c_25: 0,
                },
                accountOfficers: [],

                collections: {
                    transaction_date: ''
                },
                statusUpdate: false,
            },
            methods: {
                nextTextField: function(textField) {
                    const nextInput = this.$refs[textField]
                    if (nextInput) {
                        nextInput.focus();
                    }
                },
                amountConverter: function(amount) {
                    const formatter = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',

                    });

                    return formatter.format(amount)
                },
                addBranchCollection() {
                    this.isEditing = false;
                    if ($('#branch_id_collection').val() == "") {
                        alert("Please add branch");
                    } else {
                        var branch = $('#branch_id_collection option:selected').text().trim();
                        this.collectionBreakdown.branch_collections.push({
                            branch: {
                                branch_id: $('#branch_id_collection').val(),
                                branch_name: branch
                            },
                            total_amount: this.branch_collection.total_amount,
                            isEditing: false,
                        });

                        $('#branch_id_collection option:selected').val("");

                        this.branch_collection.total_amount = 0;

                    }
                },
                addAccountOfficerCollection: function() {
                    if ($('#remarks').val() == "") {
                        alert("Please add account officer collection");
                    } else {
                        this.collectionBreakdown.account_officer_collections.push({
                            representative: this.officer_collection.representative,
                            note: this.officer_collection.note,
                            total: this.officer_collection.total,
                            isEditing: false
                        });

                        this.officer_collection.total = 0;
                        this.officer_collection.representative = '';
                        this.officer_collection.note = '';
                    }



                },
                editOfficerCollection: function(index) {
                    this.collectionBreakdown.account_officer_collections[index].isEditing = true;
                    this.isEditing = true;

                },
                saveOfficerCollection: function(index) {
                    this.collectionBreakdown.account_officer_collections[index].isEditing = false;
                    this.isEditing = false;
                },
                processCreateOrUpdate: function() {
                    if (this.isEdit) {
                        this.updateCollectionBreakdown();

                    } else {
                        this.createValidation()
                        if (this.isValid) {
                            this.createNewCollectionBreakdown();

                        }
                    }
                },
                createValidation: function() {
                    if (this.collectionBreakdown.other_payment.pos_amount === '') {
                        alert('POS amount is required.')
                        this.isValid = false;
                    } else if (this.collectionBreakdown.other_payment.memo_amount === '') {
                        alert('MEMO amount is required.')
                        this.isValid = false;
                    } else if (this.collectionBreakdown.other_payment.check_amount === '') {
                        alert('CHECK amount is required.')
                        this.isValid = false;
                    } else {
                        this.isValid = true;
                    }


                },
                createNewCollectionBreakdown: function() {
                    this.collectionBreakdown.status = 'unposted';
                    var totalCash = parseFloat(this.totalCash.replace(/[^0-9\.-]+/g, ""));
                    this.collectionBreakdown.other_payment.interbranch_amount = parseFloat(this
                        .branchCollectionTotal.replace(/[^0-9\.-]+/g, ""));
                    this.collectionBreakdown.other_payment.cash_amount = parseFloat(this.aoCollectionTotal
                        .replace(/[^0-9\.-]+/g, ""));
                    this.collectionBreakdown.total = parseFloat(this.totalCash.replace(/[^0-9\.-]+/g, ""));
                    axios.post('/MAC-ams/collections', this.collectionBreakdown, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                        window.location.reload();
                        //  this.resetForm();
                    }).catch(err => {
                        toastr.error(err.response.data.message);

                    })
                },
                editBranchCollection: function(index, branchCollection) {
                    this.collectionBreakdown.branch_collections[index].isEditing = true;
                    this.isEditing = true;

                },
                saveBranchCollection: function(index, branch_id) {
                    this.collectionBreakdown.branch_collections[index].isEditing = false;
                    var branch = $('#branch_id_collection_edit option:selected').text().trim();
                    this.collectionBreakdown.branch_collections[index].branch.branch_name = branch;
                    this.isEditing = false;
                },
                removeBranchCollection: function(collection, index) {
                    this.collectionBreakdown.branch_collections[index].isEditing = false;
                    if (this.isEdit) {
                        axios.delete('/MAC-ams/branch-collection/' + collection.id, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        }).then(response => {
                            toastr.success(response.data.message);

                            this.collectionBreakdown.branch_collections = updatedArray;
                        }).catch(err => {
                            toastr.error(err.data.message);
                        })
                    } else {
                        if (index !== -1) {
                            this.collectionBreakdown.branch_collections.splice(index, 1);
                        }
                    }


                    /* const isEqual = (obj1, obj2) =>
                        Object.keys(obj1).every(key => obj1[key] === obj2[key]);
                    const updatedArray = this.collectionBreakdown.branch_collections.filter(
                        element => !
                        isEqual(element, collection)); */

                },
                resetForm: function() {
                    this.collectionBreakdown.collection_id = null,
                        this.collectionBreakdown.branch_id = null;
                    this.collectionBreakdown.transaction_date = '';
                    this.collectionBreakdown.p_1000 = 0;
                    this.collectionBreakdown.p_500 = 0;
                    this.collectionBreakdown.p_200 = 0;
                    this.collectionBreakdown.p_100 = 0;
                    this.collectionBreakdown.p_50 = 0;
                    this.collectionBreakdown.p_20 = 0;
                    this.collectionBreakdown.p_10 = 0;
                    this.collectionBreakdown.p_5 = 0;
                    this.collectionBreakdown.p_1 = 0;
                    this.collectionBreakdown.c_25 = 0;
                    this.collectionBreakdown.branch_collections = [];
                    this.collectionBreakdown.account_officer_collections = [];
                    this.collectionBreakdown.other_payment = {
                        cash_amount: 0,
                        check_amount: 0,
                        pos_amount: 0,
                        memo_amount: 0,
                        interbranch_amount: 0
                    }
                },
                removeAccountOfficerCollection: function(collection) {
                    if (this.isEdit) {
                        axios.delete('/MAC-ams/account-officer-collection/' + collection.collection_ao_id, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        }).then(response => {
                            toastr.success(response.data.message);

                        }).catch(err => {
                            toastr.error(err.data.message);
                        })
                    }
                    const isEqual = (obj1, obj2) =>
                        Object.keys(obj1).every(key => obj1[key] === obj2[key]);
                    const updatedArray = this.collectionBreakdown.account_officer_collections
                        .filter(element =>
                            !
                            isEqual(element, collection));
                    this.collectionBreakdown.account_officer_collections = updatedArray;



                },

                calculateCashCount: function(collectionBreakdown) {
                    this.total.p_1000 = collectionBreakdown.p_1000 * 1000;
                    this.total.p_500 = collectionBreakdown.p_500 * 500
                    this.total.p_200 = collectionBreakdown.p_200 * 200;
                    this.total.p_100 = collectionBreakdown.p_100 * 100;
                    this.total.p_50 = collectionBreakdown.p_50 * 50;
                    this.total.p_20 = collectionBreakdown.p_20 * 20;
                    this.total.p_10 = collectionBreakdown.p_10 * 10;
                    this.total.p_5 = collectionBreakdown.p_5 * 5;
                    this.total.p_1 = collectionBreakdown.p_1 * 1;
                    this.total.c_25 = collectionBreakdown.c_25 * .25;




                },
                editCollectionBreakdown: function(collectionBreakdown) {
                    this.isEdit = true;
                    this.calculateCashCount(collectionBreakdown)
                    this.collectionBreakdown = collectionBreakdown;
                    this.branch = $('#branchID').find(':selected').val()
                    axios.get('/MAC-ams/collection-breakdown/' + collectionBreakdown.collection_id, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        }).then(response => {
                            var cb = response.data.data.collections;
                            if (!cb.other_payment) {
                                cb.other_payment = {
                                    cash_amount: 0,
                                    check_amount: 0,
                                    pos_amount: 0,
                                    memo_amount: 0,
                                    interbranch_amount: 0
                                }
                            }
                            this.collectionBreakdown = cb;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    this.calculateCashCount(collectionBreakdown);
                },
                deleteCollectionBreakdown: function(collection_id) {
                    axios.delete('/MAC-ams/collection-breakdown/' + collection_id, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(response => {
                        toastr.success(response.data.message);
                    }).catch(err => {
                        toastr.success(err);
                    })
                },
                processCreateCollection: function() {
                    this.isEdit = false;

                },
                updateStatus: function(collectionBreakdown, status) {
                    this.isUpdateStatus = true;
                    this.collectionBreakdown = collectionBreakdown;
                    this.collectionBreakdown.status = status
                    this.updateCollectionBreakdown();
                },

                updateCollectionBreakdown: function() {
                    if (!this.isUpdateStatus) {
                        var totalCash = parseFloat(this.totalCash.replace(/[^0-9\.-]+/g, ""));
                        this.collectionBreakdown.other_payment.interbranch_amount = parseFloat(this
                            .branchCollectionTotal.replace(/[^0-9\.-]+/g, ""));
                        this.collectionBreakdown.total = totalCash
                        this.collectionBreakdown.other_payment.cash_amount = parseFloat(this.aoCollectionTotal
                            .replace(/[^0-9\.-]+/g, ""));
                    }
                    axios.put('/MAC-ams/collection-breakdown/' + this.collectionBreakdown.collection_id, this
                        .collectionBreakdown, {
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        }).then(response => {
                        toastr.success(response.data.message);
                        this.isUpdateStatus = false;
                    }).catch(err => {
                        toastr.error(err.response.data.message);
                    })
                },
                getBranchName(branchId) {
                    if (!this.branches) {
                        return 'N/A'; // Return 'N/A' if branches is null or undefined
                    }
                    const branch = this.branches.find(b => b.branch_id === branchId);
                    return branch ? branch.branch_name : 'N/A'; // Return 'N/A' if no branch found
                },
                getSelectedBranch(branchId) {
                    this.filter.branch_id = branchId
                },
                print: function() {
                    var content = document.getElementById('printContent').innerHTML;
                    var toPrint = document.getElementById('to-print');
                    toPrint.innerHTML = content;
                    setTimeout(() => {
                        window.print();
                        toPrint.innerHTML = ""
                    }, 500);
                },
                filterCollections: function() {
                    var data = {
                        transaction_date: this.filter.transaction_date,
                        branch_id: this.filter.branch_id
                    }
                    var url = "{{ route('reports.cashTransactionBlotter') }}"
                    axios.post(url, data)
                        .then(response => {
                            this.data = response.data.data
                            toastr.success(response.data.message);
                        }).catch(error => {
                            console.error(error);
                        })


                },
                showCashBlotter: function(id, branch_id) {
                    var url = "{{ route('reports.showCashBlotter', ['id' => 'cid']) }}".replace('cid', id);
                    axios.get(url, {
                            params: {
                                branch_id: branch_id
                            }
                        }) // Replace with your API endpoint
                        .then(response => {
                            this.responseData = response.data;
                            this.entries = response.data['entries'];
                            this.collections = response.data['entries']['collections'];
                            this.arrangeData(response.data['entries']);
                            this.collections.total_accountofficer = 0;
                            for (var i in this.collections.account_officer_collections) {
                                this.collections.total_accountofficer += parseFloat(this.collections
                                    .account_officer_collections[i].total);
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },
                arrangeData: function(data) {
                    for (var i in this.entries) {
                        var entry = this.entries[i];
                        for (var k in data) {
                            if (i == k) {
                                this.entries[i] = data[k];
                            }
                        }
                    }

                },
                upperWords: function(inputString) {
                    var stringWithSpaces = inputString.replace(/_/g, ' ');
                    var words = stringWithSpaces.split(' ');
                    for (var i = 0; i < words.length; i++) {
                        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
                    }
                    var result = words.join(' ');

                    return result;
                },
                noZero: function(val) {
                    return val == 0 ? '' : this.formatCurrency(val);
                },
                formatCurrency: function(amount) {
                    amount = parseFloat(amount);
                    if (isNaN(amount)) {
                        return "Invalid Number";
                    }
                    amount = amount.toFixed(2);

                    amount = amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    return amount;
                },
                formatDate: function(inputDate) {
                    const months = [
                        "January", "February", "March", "April", "May", "June", "July",
                        "August", "September", "October", "November", "December"
                    ];

                    const dateParts = inputDate.split('-');
                    if (dateParts.length !== 3) {
                        return "Invalid Date";
                    }

                    const year = dateParts[0];
                    const month = parseInt(dateParts[1], 10);
                    const day = parseInt(dateParts[2], 10);

                    const formattedDate = new Date(year, month - 1, day).toLocaleDateString('en-US', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    return formattedDate;
                }
            },
            computed: {
                total_interbranch_collection: function() {
                    return this.collections.branch_collections ? this.collections.branch_collections.reduce((
                            sum, item) => sum + item.total_amount,
                        0) : 0;
                },
                otherPayment: function() {
                    var collections = this.collections;
                    if (collections.other_payment) {
                        var otherPayment = collections.other_payment;
                        return {
                            cash_amount: this.formatCurrency(otherPayment.cash_amount),
                            check_amount: this.formatCurrency(otherPayment.check_amount),
                            memo_amount: this.formatCurrency(otherPayment.memo_amount),
                            pos_amount: this.formatCurrency(otherPayment.pos_amount),
                            interbranch_amount: this.formatCurrency(otherPayment.interbranch_amount),
                            total: this.formatCurrency(otherPayment.cash_amount + otherPayment.check_amount +
                                otherPayment.memo_amount + otherPayment.pos_amount + otherPayment
                                .interbranch_amount),
                        };
                    }

                    return this.other_payment;

                },
                collectionsBreakdown: function() {
                    return this.data.collections
                },
                totalCash: function() {
                    var total = parseFloat(this.collectionBreakdown.p_1000 * 1000) +
                        parseFloat(this.collectionBreakdown.p_500 * 500) +
                        parseFloat(this.collectionBreakdown.p_200 * 200) +
                        parseFloat(this.collectionBreakdown.p_100 * 100) +
                        parseFloat(this.collectionBreakdown.p_50 * 50) +
                        parseFloat(this.collectionBreakdown.p_20 * 20) +
                        parseFloat(this.collectionBreakdown.p_10 * 10) +
                        parseFloat(this.collectionBreakdown.p_5 * 5) +
                        parseFloat(this.collectionBreakdown.p_1 * 1) +
                        parseFloat(this.collectionBreakdown.c_25 * 0.25);
                    return this.amountConverter(total);
                },
                aoCollectionTotal: function() {
                    var aoCollection = this.collectionBreakdown.account_officer_collections;
                    var total = 0;
                    if (aoCollection.length > 0) {
                        for (var i in aoCollection) {
                            total += parseFloat(aoCollection[i].total);
                        }
                    }
                    return this.amountConverter(total);
                },
                otherPaymentTotal: function() {

                    var otherPayment = this.collectionBreakdown.other_payment;
                    let total = 0;
                    if (otherPayment) {
                        total = parseFloat(this.aoCollectionTotal.replace(/[^0-9\.-]+/g, "")) +
                            parseFloat(otherPayment.check_amount) +
                            parseFloat(otherPayment.memo_amount) +
                            parseFloat(otherPayment.pos_amount) +
                            parseFloat(otherPayment.interbranch_amount)
                    }
                    return this.amountConverter(total);
                },
                branchCollectionTotal: function() {
                    var branchCollection = this.collectionBreakdown.branch_collections;
                    var total = 0;
                    if (this.collectionBreakdown.other_payment) {
                        if (branchCollection.length > 0) {
                            for (var i in branchCollection) {
                                total += parseFloat(branchCollection[i].total_amount);
                            }

                        }
                    }

                    return this.amountConverter(total);
                },
                filteredCashBlotter: function() {
                    var rows = [];
                    var cashEndingBalance = 0;
                    totalCashIn = 0;
                    totalCashOut = 0;
                    for (var i in this.entries) {
                        var entry = this.entries[i];
                        var row = ['', '', '', '', '', '', '', ''];
                        if (i.toLowerCase() != 'collections') {
                            if (i.toLowerCase() == 'begining_balance') {
                                cashEndingBalance += parseFloat(entry.total);
                                totalCashIn += parseFloat(entry.total);
                                row[0] = '<b>Beginning Balance</b>';
                                row[6] = `<b>` + this.formatCurrency(entry.total) + `</b>`;
                                rows.push(row);
                            } else {
                                row[0] = '<b>' + this.upperWords(i) + '</b>';
                                rows.push(row);
                                for (var k in entry) {
                                    var journal = entry[k];
                                    journal.details.forEach(element => {
                                        totalCashIn += parseFloat(element.cash_in);
                                        totalCashOut += parseFloat(element.cash_out);
                                        if (i == 'cash_received') {
                                            cashEndingBalance += parseFloat(element.cash_in);
                                        } else if (i == 'cash_paid') {
                                            cashEndingBalance -= parseFloat(element.cash_out);
                                        }
                                        var mrow = ['', '', '', '', '', '', '', ''];
                                        mrow[0] = journal.journal_date;
                                        mrow[1] = journal.journal_no;
                                        mrow[2] = journal.branch.branch_name;
                                        mrow[3] = journal.source;
                                        mrow[4] = journal.cheque_date;
                                        mrow[5] = journal.cheque_no;
                                        mrow[6] = element ? this.noZero(element
                                            .cash_in) : '';
                                        mrow[7] = element ? this.noZero(element
                                            .cash_out) : '';
                                        rows.push(mrow);
                                    });
                                }
                                if (i == 'cash_paid') {
                                    rows.push(['<b>Cash Ending Balance</b>', '', '', '', '', '',
                                        cashEndingBalance > 0 ? '<b>' + this.formatCurrency(
                                            cashEndingBalance) + '</b>' : '', cashEndingBalance <= 0 ?
                                        '<b>' + this.formatCurrency(cashEndingBalance) + '</b>' : ''
                                    ])
                                }
                            }
                            //


                        }
                    }

                    return {
                        rows: rows,
                        total: {
                            cashin: totalCashIn,
                            cashout: totalCashOut
                        }
                    };
                }
            },
            mounted() {
                /*                 this.getBranchList(); */
                this.data = @json($cash_blotter);
                this.branches = @json($branches);
            }
        });
    </script>
    <script>
        // Disable keyboard input for the date field
        document.getElementById('transactionDate').addEventListener('keydown', function(e) {
            e.preventDefault();
        });
    </script>
@endsection


@section('footer-scripts')
    @include('scripts.reports.reports')
@endsection
