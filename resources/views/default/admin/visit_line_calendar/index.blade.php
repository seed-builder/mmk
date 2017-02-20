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
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">线路巡访日历</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>线路代码</th>
                                <th>线路名称</th>
                                <th>负责业代</th>
                                <th>巡访日期</th>
                                <th>巡访状态</th>
                                <th>创建时间</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">线路门店巡访日历</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="storeTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>fline_calendar_id</th>
                                <th>门店名称</th>
                                <th>负责业代</th>
                                <th>巡访日期</th>
                                <th>巡访状态</th>
                                <th>拜访时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    <div id="todoInfo" class="modal fade modal-scroll" role="dialog" tabindex="-1" data-replace="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    	
@endsection

@section('js')
    @include('admin.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
    <script type="text/javascript">

        $(function () {
            seajs.use('app-visit-line-calendar', function (visitline) {
            	visitline.index($, 'moduleTable','storeTable','tree');
            });
            
        });

    </script>
@endsection