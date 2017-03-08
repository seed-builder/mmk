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
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
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
                                <th> 库存基本单位数量（瓶）</th>
                                <th>建议销售数量(箱)</th>
                                <th>上次盘点库存基本单位数量（瓶）</th>

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