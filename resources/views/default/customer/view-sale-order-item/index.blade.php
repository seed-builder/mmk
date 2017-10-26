@extends('customer.layout.collapsed-sidebar')
@section('styles')
    @include('customer.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>view_sale_order_items</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">view_sale_order_items</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">门店销售记录列表</h3>
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
                                    <label  class="col-sm-1 control-label">门店</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="store_name" filter-operator="like" >
                                    </div>
                                    <label class="col-sm-1 control-label">业务员</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="employee_name" filter-operator="like" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">开始日期</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="fdate" filter-operator=">=" >
                                    </div>
                                    <label class="col-sm-1 control-label">结束日期</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="fdate" filter-operator="<=" >
                                    </div>
                                    <div class="col-sm-3 col-sm-offset-1">
                                        <button type="button" class="btn btn-info filter-submit">查询</button>
                                        <button type="button" class="btn btn-default filter-reset">重置</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>姓名</th>
                                <th>职位</th>
                                <th>下单日期</th>
                                <th>下单门店名称</th>
                                <th>下单门店编号</th>
                                <th>下单门店渠道</th>
                                {{--<th>下单门店所属经销商</th>--}}
                                <th>品项</th>
                                <th>数量（箱）</th>
                                <th>数量（瓶）</th>
                                <th>赠送数量（箱）</th>
                                <th>赠送数量（瓶）</th>
                                <th>金额</th>
                                <th>是否完成配送</th>
                                <th>配送日期</th>
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
    @include('customer.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('customer/view_sale_order_item.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection