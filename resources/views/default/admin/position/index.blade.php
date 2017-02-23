@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>bd_positions</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">bd_positions</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">组织架构信息</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="tree"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">职位列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>编号</th>
                                <th>名称</th>
                                <th>上级</th>
                                <th>所属部门</th>
                                <th>备注</th>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="positionModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">职位信息</h4>
                </div>
                <form class="form-horizontal" id="positionForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="box-body">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3">职位名称</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control form-data" name="fname" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">编号</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control form-data" name="fnumber" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">上级</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="fparpost_id">
                                            @foreach($positions as $p)
                                                <option value="{{$p->id}}">{{$p->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">所属部门</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="fdept_id">
                                            @foreach($depts as $d)
                                                <option value="{{$d->id}}">{{$d->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">备注</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control form-data" name="fremark">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary" >保存</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/position.js', function (app) {
                app.index($, 'moduleTable', 'tree');
            });
        });
    </script>

@endsection