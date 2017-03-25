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
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">经销商列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="form-horizontal filter " filter-table="#moduleTable">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">名称</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="fname" filter-operator="like" />
                                    </div>

                                    <label class="col-sm-1 control-label">地址</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="faddress" filter-operator="like" />
                                    </div>

                                    <label class="col-sm-1 control-label">电话</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="ftel" filter-operator="like" />
                                    </div>
                                </div>
                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </div>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>名称</th>
                                <th>地址</th>
                                <th>联系电话</th>
                                <th>审核状态</th>
                                <th>后台状态</th>
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
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/customer.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection