@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>visit_todo_temps</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">visit_todo_temps</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">visit_todo_temps列表</h3>
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
                                <th>fchildren_calculate</th>
                                <th>fcreate_date</th>
                                <th>fcreator_id</th>
                                <th>fdocument_status</th>
                                <th>ffunction_id</th>
                                <th>ffunction_number</th>
                                <th>fgroup_id</th>
                                <th>fis_must_visit</th>
                                <th>flag</th>
                                <th>fmodify_date</th>
                                <th>fmodify_id</th>
                                <th>fname</th>
                                <th>fnumber</th>
                                <th>forg_id</th>
                                <th>fparent_id</th>
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
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/visit_todo_temp.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection