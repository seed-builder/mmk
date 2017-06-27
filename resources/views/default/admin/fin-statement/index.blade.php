@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>fin_statements</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">fin_statements</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">fin_statements列表</h3>
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
                                <th>abstract</th>
                                <th>bal_amount</th>
                                <th>bill_date</th>
                                <th>bill_no</th>
                                <th>bill_type</th>
                                <th>cur_amount</th>
                                <th>cust_id</th>
                                <th>cust_name</th>
                                <th>cust_num</th>
                                <th>fcreate_date</th>
                                <th>fmodify_date</th>
                                <th>id</th>
                                <th>month</th>
                                <th>print_status</th>
                                <th>project_no</th>
                                <th>remarks</th>
                                <th>seq</th>
                                <th>srcbill_no</th>
                                <th>status</th>
                                <th>year</th>
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
            seajs.use('admin/fin_statement.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection