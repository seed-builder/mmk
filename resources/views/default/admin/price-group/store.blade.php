@extends('admin.layout.collapsed-sidebar')
@section('styles')
    <link type="text/css" href="/assets/plugins/bootstrap-select/bootstrap-select.css" rel="stylesheet"/>
    <style>
        .tangram-suggestion-main {
            z-index: 9999;
        }
        .layui-form-label{
            width: 100px;
        }
        .btn-primary{
            color: #ffffff;
        }
    </style>
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            经销商
            <small>售价管理</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">经销商</a></li>
            <li><a href="/admin/price-group">售价管理</a></li>
            <li class="active"><a href="/admin/price-group/{{$entity->id}}/edit">{{$entity->fname}}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">价格组【{{$entity->fname}}】关联选择门店</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="form-horizontal filter " filter-table="#moduleTable">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">门店名称</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control filter-condition" filter-name="ffullname" filter-operator="like" />
                                </div>

                                <label class="col-sm-1 control-label">负责业代</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control filter-condition" filter-name="employee_fname" filter-operator="like" />
                                </div>
                                <label class="col-sm-1 control-label">路线</label>
                                <div class="col-sm-3">
                                    <select class="form-control filter-condition filter-select" filter-name="fline_id" data-live-search="true">
                                        <option value="">--请选择--</option>
                                        @foreach($lines as $l)
                                            <option value="{{$l->id}}">{{$l->fname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">经销商</label>
                                <div class="col-sm-3">
                                    <select class="form-control filter-condition filter-select" filter-name="fcust_id" data-live-search="true">
                                        <option value="">--请选择--</option>
                                        @foreach($cus as $c)
                                            <option value="{{$c->id}}">{{$c->fname}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label class="col-sm-1 control-label">渠道</label>
                                <div class="col-sm-3">
                                    <select class="form-control filter-condition filter-select" filter-name="fchannel" data-live-search="true">
                                        <option value="">--请选择--</option>
                                        @foreach($channels as $c)
                                            <option value="{{$c->id}}">{{$c->fname}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label class="col-sm-1 control-label">是否签约</label>
                                <div class="col-sm-3">
                                    <select class="form-control filter-condition filter-select" filter-name="fis_signed" >
                                        <option value="">--请选择--</option>
                                        <option value="0">未签约</option>
                                        <option value="1">已签约</option>
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
                            <th></th>
                            <th>门店编码</th>
                            <th>门店全称</th>
                            <th>详细地址</th>
                            <th>负责人</th>
                            <th>联系电话</th>
                            <th>负责业代</th>
                            <th>经销商</th>
                            <th>路线</th>
                            <th>渠道</th>
                            <th>是否签约</th>
                            <th>审核状态</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            </div>
            <!-- /.box -->
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@section('js')
    <script src="/assets/plugins/bootstrap-fileinput/js/fileinput.min.js"></script>
    <script src="/assets/plugins/bootstrap-fileinput/js/fileinput_locale_zh_CN.js"></script>
    <script src="/assets/plugins/bootstrap-select/bootstrap-select.js"></script>
    <script src="/assets/plugins/bootstrap-select/i18n/defaults-zh_CN.js"></script>
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        var groupId = {!! $entity->id !!}
        $(function () {
            seajs.use('admin/price_group.js', function (app) {
                app.chooseStore($, 'moduleTable', groupId);
            });
        });

    </script>
@endsection
