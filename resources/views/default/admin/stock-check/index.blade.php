@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>st_stock_checks</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">st_stock_checks</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">库存盘点列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default" >
                            <form class="form-horizontal filter" filter-table="#moduleTable">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">经销商</label>
                                    <div class="col-sm-2">
                                        <select class="form-control filter-condition filter-select" filter-name="fcust_id" data-live-search="true">
                                            <option value="">--请选择--</option>
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label class="col-sm-2 control-label">盘点日期</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control filter-condition filter-date" filter-name="fcheck_date" filter-operator=">="/>
                                            <span class="input-group-addon">---</span>
                                            <input type="text" class="form-control filter-condition filter-date" filter-name="fcheck_date" filter-operator="<="/>
                                        </div>

                                    </div>

                                    <label class="col-sm-2 control-label">盘点状态</label>
                                    <div class="col-sm-2">
                                        <select class="form-control filter-condition filter-select" filter-name="fcheck_status">
                                            <option value="">--请选择--</option>
                                            <option value="0">盘点中</option>
                                            <option value="1">盘点完成</option>
                                            <option value="2">取消盘点</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>经销商</th>
                                <th>年份</th>
                                <th>月份</th>
                                <th>完成日期</th>
                                <th>盘点状态</th>
                                <th>盘点人</th>
                                <th>操作</th>
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
                        <h3 class="box-title">盘点明细列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="itemTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>fstock_check_id</th>
                                <th>盘点商品</th>
                                <th>期初库存数量（箱）</th>
                                <th>期初库存数量（瓶）</th>
                                <th>盘点数量（箱）</th>
                                <th>盘点瓶数量（瓶）</th>
                                <th>盘点差异数量（箱）</th>
                                <th>盘点差异数量（瓶）</th>

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

    <div id="show" class="modal fade modal-scroll" role="dialog" tabindex="-1" data-replace="true">
        <div class="modal-dialog" style="width: 50%">
            <div class="modal-content">
            </div>
        </div>
    </div>

@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/stock_check.js', function (app) {
                app.index($, 'moduleTable','itemTable');
            });
        });
    </script>

@endsection