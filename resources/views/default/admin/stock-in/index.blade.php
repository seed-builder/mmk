@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>st_stock_ins</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">st_stock_ins</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">入库列表</h3>
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
                                        <select class="form-control filter-condition filter-select" filter-name="fcust_id" data-live-search="true">
                                            <option value="">--请选择--</option>
                                            @foreach($customers as $c)
                                                <option value="{{$c['value']}}">{{$c['label']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label class="col-sm-2 control-label">发货起始时间</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="fsend_date" filter-operator=">="/>
                                    </div>

                                    <label class="col-sm-2 control-label">发货结束时间</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="fsend_date" filter-operator="<="/>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-sm-1 control-label">到货状态</label>
                                    <div class="col-sm-2">
                                        <select class="form-control filter-condition filter-select" filter-name="fsend_status">
                                            <option value="">--请选择--</option>
                                            <option value="A">未到货</option>
                                            <option value="B">到货中</option>
                                            <option value="C">已到货</option>
                                        </select>
                                    </div>

                                    <label class="col-sm-2 control-label">到货起始时间</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="fin_date" filter-operator=">="/>
                                    </div>

                                    <label class="col-sm-2 control-label">到货结束时间</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="fin_date" filter-operator="<="/>
                                    </div>

                                </div>
                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>入库单号</th>
                                <th>发货日期</th>
                                <th>到货日期</th>
                                <th>经销商</th>
                                <th>到货状态</th>
                                <th>到货确认人</th>
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
                        <h3 class="box-title">入库明细列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default" >
                            <form class="form-horizontal filter "  filter-table="#itemTable">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">入库单号</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="fstock_in" filter-operator="like"/>
                                    </div>

                                    <label class="col-sm-2 control-label">入库商品</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="fmaterial" filter-operator="like"/>
                                    </div>
                                </div>

                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="itemTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>入库单号</th>
                                <th>入库商品</th>
                                <th>销售单位</th>
                                <th>基本单位</th>
                                <th>到货数量</th>
                                <th>销售基本单位数量</th>
                                <th>审核状态</th>
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
        var materials = {!! json_encode($materials) !!}
        $(function () {
            seajs.use('admin/stock_in.js', function (app) {
                app.index($, 'moduleTable','itemTable',customers,materials);
            });
        });
    </script>

@endsection