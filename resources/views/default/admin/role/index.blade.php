@extends('admin.layout.collapsed-sidebar')

@section('styles')

    <link rel="stylesheet" href="/packages/admin/datatable/css/dataTables.bootstrap.css" />
    <link rel="stylesheet" href="/packages/admin/datatable/extensions/Buttons/css/buttons.dataTables.css" />
    <link rel="stylesheet" href="/packages/admin/datatable/extensions/Buttons/css/buttons.bootstrap.css" />
    <link rel="stylesheet" href="/packages/admin/datatable/extensions/Select/css/select.dataTables.css" />
    <link rel="stylesheet" href="/packages/admin/datatable/extensions/Select/css/select.bootstrap.css" />

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            用户权限管理
            <small>角色管理</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">用户权限管理</a></li>
            <li class="active">角色管理</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">角色列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>名称</th>
                                <th>显示名称</th>
                                <th>描述</th>
                                <th>图标</th>
                                <th>创建时间</th>
                                <th>修改时间</th>
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
    <script src="/packages/admin/datatable/js/jquery.dataTables.js"></script>
    <script src="/packages/admin/datatable/js/dataTables.bootstrap.js"></script>
    <script src="/packages/admin/datatable/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script src="/packages/admin/datatable/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
    <script src="/packages/admin/datatable/extensions/Select/js/dataTables.select.min.js"></script>
    <script src="/packages/admin/datatable/js/pipeline.js"></script>
    <script src="/packages/admin/datatable/js/zh_CN.js"></script>
    <script src="/packages/admin/AdminLTE/dist/js/demo.js"></script>
    <script type="text/javascript">
        var table;
        $(function () {

            function reload() {
                //editor.close();
                setTimeout(function () {
                    table.clearPipeline().draw();
                }, 100);
            }

            table = $("#moduleTable").DataTable({
                dom: "Bfrtip",
                language: zhCN,
                processing: true,
                serverSide: true,
                select: true,
                paging: true,
                ajax: $.fn.dataTable.pipeline({
                    url: '/admin/role/pagination',
                    pages: 5
                }),
                columns: [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "display_name" },
                    { "data": "description" },
                    { "data": "icon" },
                    { "data": "created_at" },
                    { "data": "updated_at" },
                ],
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });


        });

    </script>
@endsection