@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
    <link type="text/css" href="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.css" rel="stylesheet"/>
    <link type="text/css" href="/assets/plugins/bootstrap-select/bootstrap-select.css" rel="stylesheet"/>

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>visit_todo_groups</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">visit_todo_groups</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">模板</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-wrench"></i></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" id="btnOpen"><i class="fa fa-folder-open"></i>展开</a></li>
                                    <li><a href="#" id="btnCollapse"><i class="fa fa-folder"></i>折叠</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="tree-todo"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">拜访方案</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-wrench"></i></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" id="btnRemove"><i class="fa fa-remove"></i>删除</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" id="btnOpen"><i class="fa fa-folder-open"></i>展开</a></li>
                                    <li><a href="#" id="btnCollapse"><i class="fa fa-folder"></i>折叠</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <select class="form-control" id="todo_group_id" data-live-search="true">
                                    <option value="0">请选择一个方案</option>
                                    @foreach($groups as $g)
                                        <option value="{{$g->id}}">{{$g->fname." ".date("Y-m-d",strtotime($g->fstart_date))}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="tree-todo-group"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">门店列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default filter" filter-table="#moduleTable">
                            <form class="layui-form">
                                <div class="box-body">
                                    <div class="layui-form-item">
                                        <div class="layui-inline">
                                            <label class="layui-form-label">门店名称</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition"
                                                       filter-name="ffullname" filter-operator="like"/>
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">经销商</label>
                                            <div class="layui-input-inline">
                                                <select class="layui-input filter-condition" filter-name="fcust_id"
                                                        lay-search>
                                                    <option value="">--请选择--</option>
                                                    @foreach($customers as $c)
                                                        <option value="{{$c->id}}">{{$c->fname}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th></th>
                                <th>门店全称</th>
                                <th>经销商</th>
                                <th>负责人</th>
                                <th>负责业代</th>
                            </tr>

                            </thead>
                        </table>

                    </div>
                    <div class="box-footer" style="text-align: center">
                        <button type="button" class="btn btn-block btn-primary" id="btnMakeTodos">生成</button>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    <div class="modal fade" tabindex="-1" role="dialog" id="makeCalendarModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">生成拜访日历</h4>
                </div>
                <form class="form-horizontal" id="makeCalendarForm"
                      action="{{url('/admin/visit-todo-group/makeCalendar')}}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label>开始时间</label>
                                <input type="date" class="form-control" name="start_date">
                            </div>
                            <div class="form-group">
                                <label>结束时间</label>
                                <input type="date" class="form-control" name="end_date">
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="group_id" id="group_id">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
    <script src="/assets/plugins/bootstrap-select/bootstrap-select.js"></script>
    <script src="/assets/plugins/bootstrap-select/i18n/defaults-zh_CN.js"></script>

    <script type="text/javascript">
        $(function () {
            seajs.use('admin/visit_todo_group_config.js', function (app) {
                app.index($, 'moduleTable', 'tree-todo', 'tree-todo-group');
            });
        });
    </script>

@endsection