<?php
$ranges = ['all' => '全部', 'store' => '门店', 'customer' => '经销商'];
$docStatus = ['A' => '未审核', 'C' => '已审核'];
?>
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
                        <h3 class="box-title">新增价格组</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- form start -->
                    <form id="detailForm" class="form-horizontal" method="post" action="{{route('price-group.store')}}">
                        {!! csrf_field() !!}
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
                                    <input type="text" class="form-control datepicker" id="fbegin" name="fbegin" value="{{$entity->fbegin}}" placeholder="起始日期">
                                </div>

                                <label for="fname" class="col-sm-1 control-label">截止日期</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control datepicker" id="fend" name="fend" value="{{$entity->fend}}" placeholder="截止日期">
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
            </section>

        </div>
        <!-- /.row -->
    </section>

@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script type="text/javascript" src="/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/assets/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.js"></script>
    <script src="/assets/plugins/bootstrap-validator/js/bootstrapValidator.min.js"></script>
    <script src="/assets/plugins/bootstrap-validator/js/language/zh_CN.js"></script>
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/price_group.js', function (app) {
                app.create($);
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                language: 'zh-CN'
            });
        });
    </script>

@endsection