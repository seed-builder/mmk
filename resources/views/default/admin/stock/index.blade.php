@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>st_stocks</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">st_stocks</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">st_stocks列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>fbase_eqty</th>
                                <th>fcreate_date</th>
                                <th>fcreator_id</th>
                                <th>fdocument_status</th>
                                <th>feqty</th>
                                <th>fhqty</th>
                                <th>flog_id</th>
                                <th>fmeterial_id</th>
                                <th>fmodify_date</th>
                                <th>fmodify_id</th>
                                <th>fold_eqty</th>
                                <th>fsale_hqty</th>
                                <th>fstore_id</th>
                                <th>ftime</th>
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
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/stock.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection