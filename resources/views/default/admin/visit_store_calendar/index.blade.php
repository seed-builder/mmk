@extends('admin.layout.collapsed-sidebar')

@section('styles')

    @include('admin.layout.datatable-css')

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            基础信息管理
            <small>部门信息</small>
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
                        <h3 class="box-title">门店拜访查看</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>门店名称</th>
                                <th>负责业代</th>
                                <th>所属组织</th>
                                <th>巡访状态</th>
                                <th>拜访时间</th>
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
            seajs.use('app-visit-store-calendar', function (calendar) {
            	calendar.index($, 'moduleTable');
            });

            
        });

    </script>
@endsection