@extends('customer.layout.collapsed-sidebar')
@section('styles')
    @include('customer.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>st_sale_orders</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">st_sale_orders</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">订单列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="orderTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>订单号</th>
                                <th>门店</th>
                                <th>下单日期</th>
                                <th>业务员</th>
                                <th>经销商</th>
                                <th>发货状态</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">订单明细列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="orderInfoTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>订单号</th>
                                <th>商品名称</th>
                                <th>销售单位</th>
                                <th>基本单位</th>
                                <th>订单数量</th>
                                <th>销售基本单位数量</th>
                                <th>发货数量</th>
                                <th>发货基本单位数量</th>
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
            seajs.use('customer/sale_order.js', function (app) {
                app.index($, 'orderTable','orderInfoTable');
            });
        });
    </script>

@endsection