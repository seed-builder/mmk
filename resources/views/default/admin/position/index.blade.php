@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
    <link type="text/css" href="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/plugins/bootstrap-validator/css/bootstrapValidator.min.css" />
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            基础信息管理
            <small>职位信息</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">基础信息管理</a></li>
            <li class="active">职位信息</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">职位架构信息</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-wrench"></i></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" id="btnAddChild"><i class="fa fa-file"></i>新增下级职位</a></li>
                                    <li><a href="#" id="btnAddSame"><i class="fa fa-file"></i>新增同级职位</a></li>
                                    {{--<li><a href="#" id="btnEdit"><i class="fa fa-pencil"></i>编辑</a></li>--}}
                                    <li><a href="#" id="btnRemove"><i class="fa fa-remove"></i>删除</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" id="btnOpen"><i class="fa fa-folder-open"></i>展开</a></li>
                                    <li><a href="#" id="btnCollapse"><i class="fa fa-folder"></i>折叠</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="tree"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">职位详情</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="form-horizontal" id="positionForm" action="{{route('position.store')}}">
                            {{ csrf_field() }}
                            <input type="hidden" id="id" name="id" />
                            <div class="modal-body">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">职位名称</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-data" name="fname" id="fname" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">编号</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-data" name="fnumber" id="fnumber" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">上级</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="fparpost_id" id="fparpost_id">
                                                    <option value="">--请选择--</option>
                                                    @foreach($positions as $p)
                                                        <option value="{{$p->id}}">{{$p->fname}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">所属部门</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="fdept_id" id="fdept_id">
                                                    <option value="">--请选择--</option>
                                                    @foreach($depts as $d)
                                                        <option value="{{$d->id}}">{{$d->fname}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">备注</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-data" name="fremark" id="fremark">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" >保存</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
    <script src="/assets/plugins/bootstrap-validator/js/bootstrapValidator.min.js"></script>
    <script src="/assets/plugins/bootstrap-validator/js/language/zh_CN.js"></script>
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/position.js', function (app) {
                app.index($, 'moduleTable', 'tree');
            });
        });
    </script>

@endsection