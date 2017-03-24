@extends('admin.layout.collapsed-sidebar')

@section('styles')

    @include('admin.layout.datatable-css')

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            基础信息管理
            <small>部门信息</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">用户权限管理</a></li>
            <li class="active">角色管理</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3" >
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">组织架构信息</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
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
                        <div id="tree" tree-type="employee-tree"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">线路巡访日历</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default filter" filter-table="#moduleTable">
                            <form class="layui-form">
                                <div class="box-body">
                                    <div class="layui-form-item">
                                        <div class="layui-inline">
                                            <label class="layui-form-label">开始时间</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition" filter-name="fdate" filter-operator=">=" onclick="layui.laydate({elem: this})">
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">结束时间</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition" filter-name="fdate" filter-operator="<=" onclick="layui.laydate({elem: this})">
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">负责业代</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition" filter-name="femp" filter-operator="like">
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">线路名称</label>
                                            <div class="layui-input-inline">
                                                <select class="layui-input filter-condition" filter-name="fline_id">
                                                    <option value="">--请选择--</option>
                                                    @foreach($lines as $l)
                                                        <option value="{{$l->id}}">{{$l->fname}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button> &nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>线路代码</th>
                                <th>线路名称</th>
                                <th>负责业代</th>
                                <th>巡访日期</th>
                                <th>巡访状态</th>
                                <th>创建时间</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">线路门店巡访日历</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default filter" filter-table="#storeTable">
                            <form class="layui-form">
                                <div class="box-body">
                                    <div class="layui-form-item">
                                        <div class="layui-inline">
                                            <label class="layui-form-label">开始时间</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition" filter-name="fdate" filter-operator=">=" onclick="layui.laydate({elem: this})">
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">结束时间</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition" filter-name="fdate" filter-operator="<=" onclick="layui.laydate({elem: this})">
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">负责业代</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition" filter-name="femp" filter-operator="like">
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">门店名称</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition" filter-name="fstore" filter-operator="like">
                                            </div>
                                        </div>

                                        <div class="layui-inline">
                                            <label class="layui-form-label">巡访状态</label>
                                            <div class="layui-input-inline">
                                                <select class="layui-input filter-condition" filter-name="fstatus">
                                                    <option value="">--请选择--</option>
                                                    <option value="1">未开始</option>
                                                    <option value="2">进行中</option>
                                                    <option value="3">已完成</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button> &nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="storeTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>fline_calendar_id</th>
                                <th>门店名称</th>
                                <th>负责业代</th>
                                <th>巡访日期</th>
                                <th>巡访状态</th>
                                <th>拜访时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    <div id="todoInfo" class="modal fade modal-scroll" role="dialog" tabindex="-1" data-replace="true">
        <div class="modal-dialog" style="width: 50%">
            <div class="modal-content">
            </div>
        </div>
    </div>

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
                <form class="form-horizontal" id="makeCalendarForm" action="{{url('/admin/visit_line_calendar/makeVisitLineCalendar')}}">
                <div class="modal-body">
                    <div class="box-body">
                            <div class="form-group">
                                <label>生成周期</label>
                                <select class="form-control" name="week" id="week">
                                    <option value="1">未来一周</option>
                                    <option value="2">未来两周</option>
                                </select>
                            </div>

                    </div>


                </div>

                <div class="modal-footer">
                    <input type="hidden" name="femp_id" id="femp_id">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" id="makeBtn">保存</button>
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
    <script type="text/javascript">

        $(function () {
            seajs.use('app-visit-line-calendar', function (visitline) {
            	visitline.index($, 'moduleTable','storeTable','tree');
            });
            
        });

    </script>
@endsection