@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>view_revisit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">view_revisit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">复巡情况列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default" >
                            <form class="form-horizontal filter"  filter-table="#moduleTable">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">复巡主管</label>
                                    <div class="col-sm-2">
                                        <select class="form-control filter-condition filter-select" filter-name="senior_id" data-live-search="true">
                                            <option value="">--请选择--</option>
                                            @foreach($employees as $employee)
                                                <option value="{{$employee->id}}">{{$employee->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-sm-1 control-label">门店</label>
                                    <div class="col-sm-2">
                                        <select class="form-control filter-condition filter-select" filter-name="fstore_id" data-live-search="true">
                                            <option value="">--请选择--</option>
                                            @foreach($stores as $store)
                                                <option value="{{$store->id}}">{{$store->ffullname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-sm-1 control-label">开始时间</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="frevisit_date" filter-operator=">=" value=""/>
                                    </div>
                                    <label class="col-sm-1 control-label">结束时间</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="frevisit_date" filter-operator="<=" value=""/>
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
                                <th>ID</th>
                                <th>复巡主管</th>
                                <th>复巡时间</th>
                                <th>门店名称</th>
                                <th>门店编码</th>
                                <th>复巡状态</th>
                                <th>复巡图片查看</th>
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
    <div id="todoInfo" class="modal fade modal-scroll" role="dialog" tabindex="-1" data-replace="true">
        <div class="modal-dialog" style="width: 80%">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/view_revisit.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection