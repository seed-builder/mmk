@extends('customer.layout.collapsed-sidebar')
@section('styles')
    @include('customer.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>bd_customer_prices</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">bd_customer_prices</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">bd_customer_prices列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>fcreate_date</th>
                                <th>fcust_id</th>
                                <th>fdocument_status</th>
                                <th>finvalid_date</th>
                                <th>finvalid_operator</th>
                                <th>fis_valid</th>
                                <th>fmaterial_id</th>
                                <th>fmax_qty</th>
                                <th>fmin_qty</th>
                                <th>fmodify_date</th>
                                <th>fprice_bottle</th>
                                <th>fprice_box</th>
                                <th>fsale_unit</th>
                                <th>fspecification</th>
                                <th>fstore_id</th>
                                <th>id</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

@endsection
@section('js')
    @include('customer.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('customer/customer_price.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection