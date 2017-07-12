@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
    <link rel="stylesheet" href="/assets/plugins/bootstrap-validator/css/bootstrapValidator.min.css" />
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            经销商
            <small>出库管理</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">经销商</a></li>
            <li class="active">出库管理</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">出库列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default" >
                            <form class="form-horizontal filter" id="moduleForm"  filter-table="#moduleTable">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">经销商</label>
                                    <div class="col-sm-2">
                                        <select class="form-control filter-condition filter-select" filter-name="fcust_id" data-live-search="true">
                                            <option value="">--请选择--</option>
                                            @foreach($customers as $c)
                                                <option value="{{$c['value']}}">{{$c['label']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label class="col-sm-2 control-label">门店</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="store_ffullname" filter-operator="like"/>
                                    </div>

                                    <label class="col-sm-2 control-label">出库单号</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="fbill_no" filter-operator="like"/>
                                    </div>

                                </div>
                                <div class="form-group">

                                    <label class="col-sm-2 control-label">出库起始时间</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="fdate" filter-operator=">="/>
                                    </div>

                                    <label class="col-sm-2 control-label">出库结束时间</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="fdate" filter-operator="<="/>
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
                                <th>出库单号</th>
                                <th>门店</th>
                                <th>出库日期</th>
                                <th>出库类型</th>
                                {{--<th>到货确认日期</th>--}}
                                {{--<th>预计到货日期</th>--}}
                                <th>来源单号</th>
                                <th>到货确认人</th>
                                <th>经销商</th>
                                <th>到货状态</th>
                                <th>审核状态</th>
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
                                <th>出库单号</th>
                                <th>出库商品</th>
                                <th>数量(箱)</th>
                                <th>数量(瓶)</th>
                                <th>赠送数量(箱)</th>
                                <th>赠送数量(瓶)</th>
                                <th>单价(箱)</th>
                                <th>单价(瓶)</th>
                                <th>金额</th>
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

    {{--<div class="modal fade" tabindex="-1" role="dialog" id="stockItemFormDialog">--}}
        {{--<div class="modal-dialog" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal"--}}
                            {{--aria-label="Close">--}}
                        {{--<span aria-hidden="true">&times;</span>--}}
                    {{--</button>--}}
                    {{--<h4 class="modal-title" id="stockItemFormDialogTitle">出库明细</h4>--}}
                {{--</div>--}}
                {{--<form class="form-horizontal" id="stockItemForm" action="{{url('/admin/stock-out-item')}}" method="post">--}}
                    {{--{!! csrf_field() !!}--}}
                    {{--<input type="hidden" id="id" name="id" value="" />--}}
                    {{--<input type="hidden" id="fstock_out_id" name="fstock_out_id" value="" />--}}
                    {{--<div class="modal-body">--}}
                        {{--<div class="box-body">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-sm-2 control-label">商品</label>--}}
                                {{--<div class="col-sm-10">--}}
                                    {{--<select class="form-control" name="fmaterial_id" id="fmaterial_id">--}}
                                        {{--<option value="">--请选择--</option>--}}
                                        {{--@forelse($materials as $material)--}}
                                            {{--<option value="{{$material->id}}" data-sale-unit="{{$material->fsale_unit}}" data-base-unit="{{$material->fbase_unit}}" >{{$material->fname}}</option>--}}
                                        {{--@empty--}}
                                        {{--@endforelse--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-sm-2 control-label">单位</label>--}}
                                {{--<div class="col-sm-10">--}}
                                    {{--<select class="form-control" name="unit" id="unit">--}}
                                        {{--<option value="">--请选择--</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-sm-2 control-label">数量</label>--}}
                                {{--<div class="col-sm-10">--}}
                                    {{--<input class="form-control" type="number" name="qty" id="qty"/>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                        {{--<input type="hidden" name="femp_id" id="femp_id">--}}
                        {{--<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>--}}
                        {{--<button type="submit" class="btn btn-primary" id="makeBtn">保存</button>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
            {{--<!-- /.modal-content -->--}}
        {{--</div>--}}
        {{--<!-- /.modal-dialog -->--}}
    {{--</div>--}}

@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-validator/js/bootstrapValidator.min.js"></script>
    <script src="/assets/plugins/bootstrap-validator/js/language/zh_CN.js"></script>
    <script type="text/javascript">
        var admins = {!! json_encode($customers) !!} ;
        var stores = {!! json_encode($stores) !!} ;
        var materials = {!! json_encode($materials) !!} ;

        $(function () {
            seajs.use('admin/stock_out.js', function (app) {
                app.index($, 'moduleTable','itemTable',admins,stores,materials);
            });
        });
    </script>

@endsection