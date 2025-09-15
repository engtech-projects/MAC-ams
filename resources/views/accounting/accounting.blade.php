<style>
    .btn.btn-secondary.buttons-print,
    .btn.btn-secondary.buttons-csv.buttons-html5 {
        display: none;
    }
</style>

@extends('layouts.app')

@section('content')
    <style type="text/css">
        .dataTables_filter {
            float: left !important;
        }

        .bordered-box-content,
        .bordered-box-header {
            background: #fff;
            border: 1px solid gray;
        }

        .bordered-box-header {
            background: #c5c5c5;
        }
    </style>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="spacer" style="margin-top:20px;"></div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" style="font-size:22px"><b> Accounting </b></h4>
                            <div class="col-md-12 text-right">
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Period Start</th>
                                            <th>Period End</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('footer-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
    @include('scripts.chartofaccounts.chartofaccounts')
@endsection
