@extends('customer.layout.collapsed-sidebar')
@section('styles')
    @include('customer.layout.datatable-css')
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
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="itemTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>出库单号</th>
                                <th>出库商品</th>
                                <th>出库销售单位数量</th>
                                <th>销售单位</th>
                                <th>出库基本单位数量</th>
                                <th>基本单位</th>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="stockFormDialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">新增出库明细</h4>
                </div>
                <form class="form-horizontal" id="stockForm" action="{{url('/customer/stock-out-item')}}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" id="fstock_out_id" name="fstock_out_id" value="" />
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="fmaterial_id" id="fmaterial_id">
                                        <option value="">--请选择--</option>
                                        @forelse($materials as $material)
                                            <option value="{{$material->id}}" data-sale-unit="{{$material->fsale_unit}}" data-base-unit="{{$material->fbase_unit}}" data-ratio="{{$material->fratio}}" >{{$material->fname}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">单位</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="readonly_unit" id="unit">
                                        <option value="">--请选择--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">数量</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" name="qty" id="qty"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="femp_id" id="femp_id">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary" id="makeBtn">保存</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection
@section('js')
    @include('customer.layout.datatable-js')
    <script type="text/javascript">
        var customers = {!! json_encode($customers) !!}
        var stores = {!! json_encode($stores) !!}
        //var materials = {!! json_encode($materials) !!}
        $(function () {
            seajs.use('customer/stock_out.js', function (app) {
                app.index($, 'moduleTable','itemTable',customers,stores);
            });
        });
    </script>

@endsection