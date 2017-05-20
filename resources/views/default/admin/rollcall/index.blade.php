@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=D4Bi3270ydgA5HsnWDnmBVwF3zaPdoMC"></script>
    <style type="text/css">
        #allmap {width: 100%;height: 300px;overflow: hidden;margin:0;font-family:"微软雅黑";}
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>bd_rollcalls</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">bd_rollcalls</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="box-header">
                            <h3 class="box-title">地图定位</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="margin-top: -20px;">
                        <div id="allmap"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">实时点名报表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>姓名</th>
                                <th>职务</th>
                                <th>更新时间</th>
                                <th>地址</th>
                                <th>图片</th>
                                <th>位置</th>
                                <th>模式</th>
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
    {{--<div id="mapDialog" class="modal fade" tabindex="-1" role="dialog">--}}
        {{--<div class="modal-dialog" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                    {{--<h4 class="modal-title" id="myModalLabel">位置</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<div id="allmap"></div>--}}
                {{--</div>--}}
            {{--</div><!-- /.modal-content -->--}}
        {{--</div><!-- /.modal-dialog -->--}}
    {{--</div><!-- /.modal -->--}}

@endsection
@section('js')
    @include('admin.layout.datatable-js')

    <script type="text/javascript">
        $(function () {
            seajs.use('admin/rollcall.js', function (app) {
                app.index($, 'moduleTable');
            });
        });

    </script>

@endsection