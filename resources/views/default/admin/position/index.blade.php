@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>bd_positions</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">bd_positions</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3" >
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">组织架构信息</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="tree"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">职位列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>编号</th>
                                <th>名称</th>
                                <th>上级</th>
                                <th>所属部门</th>
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
    <script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/position.js', function (app) {
                app.index($, 'moduleTable','tree');
            });
        });
    </script>

@endsection