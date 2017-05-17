<?php
$ranges = ['all' => '全部', 'store' => '门店', 'customer' => '经销商'];
$docStatus = ['A' => '未审核', 'C' => '已审核'];
?>
@extends('admin.layout.collapsed-sidebar')
@section('styles')
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
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">经销商</a></li>
            <li class="active">售价管理</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="col-lg-12 connectedSortable">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">价格组详情</h3>
                        <div class="box-tools pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">操作
                                    <i class="fa fa-wrench"></i></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" id="btnAddChild"><i class="fa fa-file"></i>新增下级菜单功能</a></li>
                                    <li><a href="#" id="btnAddSame"><i class="fa fa-file"></i>新增同级菜单功能</a></li>
                                    {{--<li><a href="#" id="btnEdit"><i class="fa fa-pencil"></i>编辑</a></li>--}}
                                    <li><a href="#" id="btnRemove"><i class="fa fa-remove"></i>删除</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" id="btnOpen"><i class="fa fa-folder-open"></i>展开</a></li>
                                    <li><a href="#" id="btnCollapse"><i class="fa fa-folder"></i>折叠</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- form start -->
                    <form class="form-horizontal">
                        {!! csrf_field() !!}
                        <input type="hidden" id="id" name="id" value="{{$entity->id}}" />
                        <div class="box-body">
                            <div class="form-group">
                                <label for="fnumber" class="col-sm-1 control-label">编号</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="fnumber" name="fnumber" value="{{$entity->fnumber}}" placeholder="编号">
                                </div>

                                <label for="fname" class="col-sm-1 control-label">名称</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="fname" name="fname" value="{{$entity->fname}}" placeholder="名称">
                                </div>

                                <label for="fname" class="col-sm-1 control-label">等级</label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="flevel" name="flevel" >
                                        @for($i = 1; $i < 10; $i ++ )
                                            <option value="{{$i}}" {{$i == $entity->flevel ? 'selected':''}}>{{$i}} 级</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fnumber" class="col-sm-1 control-label">适用范围</label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="fsuit_object" name="fsuit_object" >
                                        @foreach($ranges as $k => $v)
                                            <option value="{{$k}}" {{$k == $entity->fsuit_object ? 'selected':''}}>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label for="fname" class="col-sm-1 control-label">起始日期</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control editor-datetime" id="fbegin" name="fbegin" value="{{$entity->fbegin}}" placeholder="起始日期">
                                </div>

                                <label for="fname" class="col-sm-1 control-label">截止日期</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control editor-datetime" id="fend" name="fend" value="{{$entity->fend}}" placeholder="起始日期">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fnumber" class="col-sm-1 control-label">审核状态</label>
                                <div class="col-sm-3">
                                    <select disabled="disabled" readonly="readonly" class="form-control readonly" id="fdocument_status" >
                                        @foreach($docStatus as $k => $v)
                                            <option value="{{$k}}" {{$k == $entity->fdocument_status ? 'selected':''}}>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label for="fname" class="col-sm-1 control-label">创建日期</label>
                                <div class="col-sm-3">
                                    <input readonly="readonly" disabled="disabled" type="text" class="form-control readonly" id="fcreate_date" value="{{$entity->fcreate_date}}" placeholder="创建日期">
                                </div>

                                <label for="fname" class="col-sm-1 control-label">修改日期</label>
                                <div class="col-sm-3">
                                    <input readonly="readonly" disabled="disabled" type="text" class="form-control readonly" id="fmodify_date" value="{{$entity->fmodify_date}}" placeholder="修改日期">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="/admin/price-group" class="btn btn-default">取消</a>
                            <button type="submit" class="btn btn-info pull-right">保存</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
                <!-- /.box -->
                <!-- Custom tabs (Charts with tabs)-->
                <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">
                        <li><a href="#group-stores" data-toggle="tab">门店</a></li>
                        <li><a href="#group-customers" data-toggle="tab">经销商</a></li>
                        <li class="active"><a href="#group-prices" data-toggle="tab">商品价格</a></li>
                        <li class="pull-left header"><i class="fa fa-inbox"></i> 价格组详情</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="group-prices" style="position: relative; height: 300px;">
                            <table id="detailTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>商品名称</th>
                                    <th>规格</th>
                                    <th>销售单位</th>
                                    <th>价格</th>
                                    <th>数量起</th>
                                    <th>数量止</th>
                                    <th>审核状态</th>
                                    <th>创建时间</th>
                                    <th>修改时间</th>
                                    <th>group_id</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="chart tab-pane" id="group-stores" style="position: relative; height: 300px;">

                        </div>
                        <div class="chart tab-pane" id="group-customers" style="position: relative; height: 300px;">

                        </div>
                    </div>
                </div>
                <!-- /.nav-tabs-custom -->
            </section>

        </div>
        <!-- /.row -->
    </section>

@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script type="text/javascript" src="/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/assets/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.js"></script>
    <script type="text/javascript">
        var options = {!! json_encode($materials) !!}
        $(function () {
            seajs.use('admin/price_group.js', function (app) {
                app.index($, 'moduleTable', 'detailTable', options);
            });

            $(function () {
                $('.datetimepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    language: 'zh-CN'
                });
            });
        });
    </script>

@endsection