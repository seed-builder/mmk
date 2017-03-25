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
                        <h3 class="box-title">库存信息列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default" >
                            <form class="form-horizontal filter "  filter-table="#moduleTable">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">经销商</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="bd_customers.fname" filter-operator="like" >
                                    </div>
                                    <label  class="col-sm-1 control-label">门店</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="st_stores.ffullname" filter-operator="like" >
                                    </div>
                                    <label class="col-sm-1 control-label">业务员</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="bd_employees.fname" filter-operator="like" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">开始日期</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control filter-condition" filter-name="st_stocks.ftime" filter-operator="<=" >
                                    </div>
                                    <label class="col-sm-1 control-label">结束日期</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control filter-condition" filter-name="st_stocks.ftime" filter-operator=">=" >
                                    </div>
                                    <div class="col-sm-3 col-sm-offset-1">
                                        <button type="button" class="btn btn-info filter-submit">查询</button>
                                        <button type="button" class="btn btn-default filter-reset">重置</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>经销商</th>
                                <th>门店编码</th>
                                <th>门店名称</th>
                                <th>盘点日期</th>
                                <th>业务员编码</th>
                                <th>业务员名称</th>
                                <th>商品编码</th>
                                <th>商品名称</th>
                                <th>规格型号</th>
                                <th>箱数量</th>
                                <th>瓶数量</th>
                                <th>建议销售数量</th>
                                <th>审核状态</th>
                                <th>审核类型</th>
                                <th>审核时间</th>
                                <th>审核人</th>
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