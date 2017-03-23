@extends('customer.layout.collapsed-sidebar')
@section('styles')
    @include('customer.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>view_store_outs</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">门店出库</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">门店出库报表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default" >
                            <form class="form-inline filter "  filter-table="#moduleTable">
                                <div class="form-group">
                                    <label class="">门店编码</label>
                                    <input type="text" class="form-control filter-condition" filter-name="view_store_outs.store_number" filter-operator="like" >
                                </div>
                                <div class="form-group">
                                    <label class="">门店</label>
                                    <input type="text" class="form-control filter-condition" filter-name="view_store_outs.store_name" filter-operator="like" >
                                </div>
                                <div class="form-group">
                                    <label class="">物料编码</label>
                                    <input type="text" class="form-control filter-condition" filter-name="view_store_outs.material_number" filter-operator="like" >
                                </div>
                                <div class="form-group">
                                    <label class="">物料</label>
                                    <input type="text" class="form-control filter-condition" filter-name="view_store_outs.material_name" filter-operator="like" >
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>门店编号</th>
                                <th>门店</th>
                                <th>物料编码</th>
                                <th>物料名称</th>
                                <th>规格型号</th>
                                <th>销售单位</th>
                                <th>出库数量（箱）</th>
                                <th>基本单位</th>
                                <th>出库数量（瓶）</th>
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
            seajs.use('customer/view_store_out.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection