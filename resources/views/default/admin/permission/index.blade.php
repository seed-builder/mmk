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
            top module
            <small>sys_permissions</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">sys_permissions</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-5" >
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">菜单权限树</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
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
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="tree" ></div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">菜单权限详情</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="form-horizontal" id="permissionForm" action="{{route('permission.store')}}">
                            {{ csrf_field() }}
                            <input type="hidden" id="id" name="id" />
                            <div class="modal-body">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">名称</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-data" name="display_name" id="display_name" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">编号</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-data" name="name" id="name" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">链接地址</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-data" name="url" id="url" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">图标</label>
                                            <div class="col-md-9">
                                                <select class="form-control selectpicker" id="logo" name="logo">
                                                    <option value="">--select--</option>
                                                    @forelse($icons as $icon)
                                                        <option value="{{$icon}}" data-content="<span class='{{$icon}}'></span>"></option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">上级</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="pid" id="pid">
                                                    <option value="">--请选择--</option>
                                                    @foreach($perOptions as $p)
                                                        <option value="{{$p['value']}}">{{$p['label']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">类型</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="type" id="type">
                                                    <option value="m">模块</option>
                                                    <option value="f">功能</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">排序</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-data" name="sort" id="sort" value="1">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">备注</label>
                                            <div class="col-md-9">
                                                <textarea  class="form-control form-data" name="description" id="description"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" >保存</button>
                            </div>
                        </form>
                        {{--<table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th>id</th>--}}
                                {{--<th>名称</th>--}}
                                {{--<th>显示名称</th>--}}
                                {{--<th>描述</th>--}}
                                {{--<th>创建时间</th>--}}
                                {{--<th>修改时间</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                        {{--</table>--}}
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
    <script src="/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="/assets/plugins/bootstrap-select/i18n/defaults-zh_CN.min.js"></script>
    <script type="text/javascript">
        $('.selectpicker').selectpicker();

    </script>
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/permission.js', function (app) {
                app.index($, 'moduleTable', 'tree');
            });
        });
    </script>

@endsection