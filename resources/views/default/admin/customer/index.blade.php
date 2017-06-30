@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            经销商门户
            <small>经销商</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">经销商门户</a></li>
            <li class="active">经销商</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">经销商地图定位</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div id="allmap" style="height: 300px;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">经销商列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="form-horizontal filter " filter-table="#moduleTable">
                                <div class="form-group">
                                    <label class="col-sm-2 col-md-1 control-label">名称</label>
                                    <div class="col-sm-2 col-md-3">
                                        <input type="text" class="form-control filter-condition" filter-name="fname" filter-operator="like" />
                                    </div>

                                    <label class="col-sm-2 col-md-1 control-label">地址</label>
                                    <div class="col-sm-2 col-md-3">
                                        <input type="text" class="form-control filter-condition" filter-name="faddress" filter-operator="like" />
                                    </div>

                                    <label class="col-sm-2 col-md-1 control-label">电话</label>
                                    <div class="col-sm-2 col-md-3">
                                        <input type="text" class="form-control filter-condition" filter-name="ftel" filter-operator="like" />
                                    </div>
                                    <label class="col-sm-2 col-md-1 control-label">负责业务员</label>
                                    <div class="col-sm-2 col-md-3">
                                        {{--<input type="text" class="form-control filter-condition" filter-name="ftel" filter-operator="like" />--}}
                                        <select class="selectpicker form-control filter-condition" data-live-search="true" filter-name="fseller" filter-operator="=">
                                            <option value="">-- 请选择 --</option>
                                            @foreach($employees as $employee)
                                            <option data-tokens="{{$employee->fname}}" value="{{$employee->id}}">{{$employee->fname}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </div>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>名称</th>
                                <th>地址</th>
                                <th>联系电话</th>
                                <th>负责业务员</th>
                                <th>审核状态</th>
                                <th>后台状态</th>
                                <th>经度</th>
                                <th>纬度</th>
                                <th>库存地址</th>
                                <th>盘点距离</th>
                                <th>盘点距离</th>
                                <th>操作</th>

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

    <div id="customerInfo" class="modal fade modal-scroll" role="dialog" tabindex="-1" data-replace="true">
        <div class="modal-dialog" style="width: 50%">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=D4Bi3270ydgA5HsnWDnmBVwF3zaPdoMC"></script>
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/customer.js', function (app) {
                app.index($, 'moduleTable','allmap');
            });
        });
    </script>

@endsection