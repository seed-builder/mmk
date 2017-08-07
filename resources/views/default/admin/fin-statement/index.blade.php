<?php
$years = [];
$curYear = date('Y');
$preMonthDate = strtotime('-1 month');
$preYear = date('Y', $preMonthDate);
$preMonth = date('n', $preMonthDate);
for($i=-10; $i < 10; $i ++){
	$years[] = $curYear + $i;
}
$months = [1,2,3,4,5,6,7,8,9,10,11,12]
?>
@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
    <link rel="stylesheet" href="/assets/plugins/bootstrap-select/bootstrap-select.min.css" />
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>fin_statements</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">fin_statements</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">往来对账列表</h3>
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
                                    {{--<label class="">经销商</label>--}}
                                    {{--<input class="form-control filter-condition" filter-name="cust_name" filter-operator="like" >--}}
                                    <label class="">经销商</label>
                                    <select class="form-control filter-select " id="custId" name="custId" data-live-search="true">
                                        <option value="">--请选择--</option>
                                        @foreach($customers as $c)
                                            <option data-tokens="{{$c->fname}}" value="{{$c->id}}" {{$c->id == $custId ? 'selected':''}}>{{$c->fname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="">年份</label>
                                    <select class="form-control filter-condition" filter-name="year" filter-operator="=">
                                        <option value="">--请选择--</option>
                                        @foreach($years as $y)
                                        <option value="{{$y}}" {{$y == $preYear ? 'selected':''}}>{{$y}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="">月份</label>
                                    <select class="form-control filter-condition" filter-name="month" filter-operator="=">
                                        <option value="">--请选择--</option>
                                        @foreach($months as $m)
                                            <option value="{{$m}}" {{$m == $preMonth ? 'selected':''}}>{{$m}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="">状态</label>
                                    <select class="form-control filter-condition" filter-name="status" filter-operator="=">
                                        <option value="">--请选择--</option>
                                        <option value="0">未对账</option>
                                        <option value="1">已对账</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button id="submitBtn" type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>往来单位代码</th>
                                <th>往来单位名称</th>
                                <th>单据类型</th>
                                <th>单据编码</th>
                                <th>源单编号</th>
                                <th>方案编号</th>
                                <th>业务日期</th>
                                <th>本期发生额</th>
                                <th>金额</th>
                                <th>摘要</th>
                                <th>备注</th>
                                <th>seq</th>
                                <th>status</th>
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
    <script src="/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="/js/dt.ext.js"></script>
    <script type="text/javascript">

        $(function () {
            seajs.use('admin/fin_statement.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection