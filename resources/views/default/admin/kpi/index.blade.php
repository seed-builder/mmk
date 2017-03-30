@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>bd_kpis</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">bd_kpis</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">bd_kpis列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>fapr</th>
                                <th>faug</th>
                                <th>fcreate_date</th>
                                <th>fcreator_id</th>
                                <th>fdec</th>
                                <th>fdocument_status</th>
                                <th>feb</th>
                                <th>femp_id</th>
                                <th>fjan</th>
                                <th>fjul</th>
                                <th>fjun</th>
                                <th>fmar</th>
                                <th>fmay</th>
                                <th>fmodify_date</th>
                                <th>fmodify_id</th>
                                <th>fnov</th>
                                <th>foct</th>
                                <th>fsep</th>
                                <th>ftype</th>
                                <th>fyear</th>
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
            seajs.use('admin/kpi.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection