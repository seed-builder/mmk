@extends('admin.layout.collapsed-sidebar') @section('styles')
    @include('admin.layout.datatable-css')
    <link rel="stylesheet" href="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.css">
    <link rel="stylesheet" href="/assets/plugins/datepicker/datepicker3.css">
    <style type="text/css">
        #allmap {
            height: 300px;
            width: 100%;
        }

    </style>
@endsection @section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            考勤管理
            <small>考勤情况查看</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">考勤管理</a></li>
            <li class="active">考勤情况查看</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">组织架构信息</h3>
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
                        <div id="tree" tree-type="employee-tree"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box">
                    <div class="box-header">
                        <div class="box-header">
                            <h3 class="box-title">考勤地图定位</h3>
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
                <!-- /.box -->

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">考勤信息</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default">
                            <form class="form-horizontal filter" id="moduleForm" filter-table="#moduleTable" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">姓名</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="bd_employees.fname" filter-operator="like" />
                                    </div>

                                    <label class="col-sm-2 control-label">考勤状态</label>
                                    <div class="col-sm-2">
                                        <select class="form-control filter-condition filter-select" filter-name="attendance_statistics.fstatus">
                                            <option value="">--请选择--</option>
                                            <option value="0">未完成</option>
                                            <option value="1">正常</option>
                                            <option value="2">异常</option>
                                            <option value="3">请假</option>
                                        </select>
                                    </div>

                                    <label class="col-sm-2 control-label">开始时间</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="attendance_statistics.fday" filter-operator=">=" value="{{date('Y-m-d',strtotime('-1 month'))}}"/>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">结束时间</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition filter-date" filter-name="attendance_statistics.fday" filter-operator="<=" value="{{date('Y-m-d')}}"/>
                                    </div>
                                </div>

                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>



                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>姓名</th>
                                <th>日期</th>
                                <th>签到时间</th>
                                <th>签到地点</th>
                                {{--<th>签到图片</th>--}}
                                <th>签退时间</th>
                                <th>签退地点</th>
                                <th>签到状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>


    </section>

    <div id="attendanceInfo" class="modal fade modal-scroll" role="dialog" tabindex="-1" data-replace="true">
        <div class="modal-dialog" style="width: 50%">
            <div class="modal-content">
            </div>
        </div>
    </div>


@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
    <script src="/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="/assets/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.js"></script>
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=D4Bi3270ydgA5HsnWDnmBVwF3zaPdoMC"></script>
    <script type="text/javascript">

        $(function () {
            seajs.use('app-attendance', function (attendance) {
                attendance.index($, 'moduleTable', 'tree', 'allmap');
            });

        });


    </script>
@endsection
