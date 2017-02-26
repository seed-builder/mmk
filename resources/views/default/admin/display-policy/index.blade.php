@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>exp_display_policy</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">exp_display_policy</li>
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
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">陈列费用政策列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>序号</th>
                                <th>费用类型</th>
                                <th>执行开始日期</th>
                                <th>执行结束日期</th>
                                <th>应用区域</th>
                                <th>总金额</th>
                                <th>项目简述</th>
                                <th>执行门店总数</th>
                                <th>单个门店费用上限</th>
                                <th>已签约门店总数</th>
                                <th>已签约总金额</th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">陈列费用签约门店列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="childTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>编号</th>
                                <th>方案名称</th>
                                <th>负责业代</th>
                                <th>门店方案执行开始日期</th>
                                <th>门店方案执行结束日期</th>
                                <th>应用区域</th>
                                <th>费用总金额</th>
                                <th>项目简述</th>
                                <th>签约门店</th>
                                <th>签约金额</th>
                                <th>核定签约金额</th>
                                <th>验证状态</th>
                                <th>签约状态</th>
                                <th>签约日期</th>
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
            var depts = {!! json_encode($depts) !!}
            seajs.use('admin/display_policy.js', function (app) {
                app.index($, 'moduleTable','childTable','tree',depts);
            });
        });
    </script>

@endsection