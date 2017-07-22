<?php
$preMonthDate = strtotime('-1 month');
$preMonthYear = date('Y', $preMonthDate);
$preMonth = date('n', $preMonthDate);

$years = [];
$curYear = date('Y');
for($i=-10; $i < 10; $i ++){
	$years[] = $curYear + $i;
}
$months = [1,2,3,4,5,6,7,8,9,10,11,12]
?>
@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>st_stock_check_items</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">st_stock_check_items</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
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
                        <div class="panel panel-default">
                            <form class="form-horizontal filter " filter-table="#moduleTable">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">经销商</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control filter-condition" filter-name="bd_customers.fname" filter-operator="like" />
                                    </div>

                                    <label class="col-sm-2 control-label">物料名称</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control filter-condition" filter-name="bd_materials.fname" filter-operator="like" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">年度</label>
                                    <div class="col-sm-4">
                                        <select id="condition_year" class="form-control filter-condition" filter-name="st_stock_checks.fyear" filter-operator="=">
                                            <option value="">--请选择--</option>
                                            @foreach($years as $y)
                                                <option value="{{$y}}" {{$y == $preMonthYear ? 'selected' : ''}}>{{$y}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-sm-2 control-label">月份</label>
                                    <div class="col-sm-4">
                                        <select id="condition_month" class="form-control filter-condition" filter-name="st_stock_checks.fmonth" filter-operator="=">
                                            <option value="">--请选择--</option>
                                            @foreach($months as $m)
                                                <option value="{{$m}}" {{$m == $preMonth ? 'selected':''}}>{{$m}}</option>
                                            @endforeach
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
                                <th>经销商</th>
                                <th>年度</th>
                                <th>月份</th>
                                <th>完成日期</th>
                                <th>盘点人</th>
                                <th>物料编码</th>
                                <th>物料名称</th>
                                <th>规格型号</th>
                                <th>理论数量（箱）</th>
                                <th>理论数量（瓶）</th>
                                <th>盘点数量（箱）</th>
                                <th>盘点数量（瓶）</th>
                                <th>差异数量（箱）</th>
                                <th>差异数量（瓶）</th>
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
            seajs.use('admin/stock_check_item.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection