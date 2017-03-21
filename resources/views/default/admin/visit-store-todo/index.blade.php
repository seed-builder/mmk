@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
    <link type="text/css" href="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.css" rel="stylesheet"/>
    <link type="text/css" href="/assets/plugins/select2/select2.css" rel="stylesheet"/>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>visit_store_todo</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">visit_store_todo</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">拜访事项列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-wrench"></i></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" id="btnAddChild"><i class="fa fa-file"></i>新增下级事项</a></li>
                                    <li><a href="#" id="btnAddSame"><i class="fa fa-file"></i>新增同级事项</a></li>
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
                        <h3 class="box-title">拜访事项编辑</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <form class="form-horizontal" id="todoForm" action="{{url('admin/visit-store-todo/save')}}">
                        <div class="box-body">
                            <div class="col-md-9">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label col-md-3">门店</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="store-list" name="fstore_id">
                                            @foreach($stores as $s)
                                                <option value="{{$s->id}}">{{$s->ffullname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">事项名称</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="fname" id="fname" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">父级事项</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="fparent_id" id="fparent_id">
                                            <option value="0">无</option>
                                            @foreach($todos as $t)
                                                <option value="{{$t->id}}">{{$t->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">拜访功能</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="ffunction_id" id="ffunction_id">
                                            @foreach($functions as $f)
                                                <option value="{{$f->id}}">{{$f->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="template" style="display: none">
                                    <label class="control-label col-md-3">事项来源</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="use_template" id="use_template">
                                            <option value="1">自定义</option>
                                            <option value="2">选择模板</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" name="id" id="id" >
                            </div>



                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">保存</button>
                        </div>
                    </form>
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
    <script src="/assets/plugins/select2/select2.js"></script>
    <script src="/assets/plugins/select2/i18n/zh-CN.js"></script>
    <script type="text/javascript">
        var todos =
                {!! json_encode($todos) !!}
        var funs = {!! json_encode($functions) !!}
        $(function () {
                seajs.use('admin/visit_store_todo.js', function (app) {
                    app.index($, 'tree', todos, funs);
                });
            });
    </script>

@endsection