@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>sys_upgrades</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">sys_upgrades</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">app升级包列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>version_code</th>
                                <th>version_name</th>
                                <th>url</th>
                                <th>content</th>
                                <th>enforce</th>
                                <th>upgrade_date</th>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="appModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">安装包上传</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <form class="form-horizontal" id="appForm" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>版本名称</label>
                                <input type="text" class="form-control" name="version_name">
                            </div>
                            <div class="form-group">
                                <label>更新内容</label>
                                <input type="text" class="form-control" name="content">
                            </div>
                            <div class="form-group">
                                <label>安装包上传</label>
                                <input id="apk" type="file" name="appfile">
                            </div>

                        </form>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="appUpload">保存</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-fileinput/js/fileinput.min.js"></script>
    <script src="/assets/plugins/bootstrap-fileinput/js/fileinput_locale_zh_CN.js"></script>
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/app_upgrade.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection