@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
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
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default" >
                            <form class="form-horizontal filter "  filter-table="#orderTable">
                                <div class="form-group">
                                    <label  class="col-sm-1 control-label">门店</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="st_stores.ffullname" filter-operator="like" >
                                    </div>
                                    <label class="col-sm-1 control-label">业务员</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="bd_employees.fname" filter-operator="like" >
                                    </div>
                                    <label class="col-sm-1 control-label">经销商</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="bd_customers.fname" filter-operator="like" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">开始日期</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="st_sale_orders.fdate" filter-operator=">=" >
                                    </div>
                                    <label class="col-sm-1 control-label">结束日期</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="st_sale_orders.fdate" filter-operator="<=" >
                                    </div>
                                    <div class="col-sm-3 col-sm-offset-1">
                                        <button type="button" class="btn btn-info filter-submit">查询</button>
                                        <button type="button" class="btn btn-default filter-reset">重置</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table id="orderTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>订单号</th>
                                <th>门店</th>
                                <th>订单日期</th>
                                <th>下单日期</th>
                                <th>业务员</th>
                                <th>经销商</th>
                                <th>金额</th>
                                <th>发货状态</th>
                                <th>发货时间</th>
                                <th>来源</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">订单明细列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="orderInfoTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>订单号</th>
                                <th>商品名称</th>
                                <th>数量(箱)</th>
                                <th>数量(瓶)</th>
                                <th>赠送数量(箱)</th>
                                <th>赠送数量(瓶)</th>
                                <th>发货数量(箱)</th>
                                <th>发货数量(瓶)</th>
                                <th>发货状态</th>
                                <th>单价/箱</th>
                                <th>单价/瓶</th>
                                <th>金额</th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="sureFormDialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">发货数量确认</h4>
                </div>
                <form class="form-horizontal" id="sureForm" action="{{url('/admin/sale-order-item/make-sure/')}}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" id="id" name="id" value="" />
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">订单号</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="order_no" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"  id="material" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">单位</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="unit" id="unit">
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
    @include('admin.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="/assets/plugins/bootstrap-validator/js/bootstrapValidator.min.js"></script>
    <script src="/assets/plugins/bootstrap-validator/js/language/zh_CN.js"></script>
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/sale_order.js', function (app) {
                app.index($, 'orderTable', 'orderInfoTable');
            });
        });
    </script>

@endsection