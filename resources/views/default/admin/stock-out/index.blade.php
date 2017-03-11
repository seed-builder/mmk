@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>st_stock_outs</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">st_stock_outs</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">出库列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>出库单号</th>
                                <th>门店</th>
                                <th>出库日期</th>
                                <th>到货确认日期</th>
                                <th>预计到货日期</th>
                                <th>来源单号</th>
                                <th>到货确认人</th>
                                <th>经销商</th>
                                <th>到货状态</th>
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
                        <h3 class="box-title">出库明细列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="itemTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>出库单号</th>
                                <th>出库商品</th>
                                <th>销售单位</th>
                                <th>基本单位</th>
                                <th>订单数量</th>
                                <th>销售基本单位数量</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>


@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        var customers = {!! json_encode($customers) !!}
        var stores = {!! json_encode($stores) !!}
        var materials = {!! json_encode($materials) !!}
        $(function () {
            seajs.use('admin/stock_out.js', function (app) {
                app.index($, 'moduleTable','itemTable',customers,stores,materials);
            });
        });
    </script>

@endsection