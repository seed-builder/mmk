@extends('admin.layout.collapsed-sidebar')

@section('styles')

    @include('admin.layout.datatable-css')

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            基础信息管理
            <small>员工信息</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">用户权限管理</a></li>
            <li class="active">员工管理</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3" >
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">部门架构信息</h3>
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
                        <div id="tree" tree-type="department-tree"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">员工列表</h3>
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
                                            <label class="layui-form-label">姓名</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition" filter-name="bd_employees.fname" filter-operator="like" />
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">工号</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition" filter-name="bd_employees.fnumber" filter-operator="like" />
                                            </div>
                                        </div>
                                        <div class="layui-inline">
                                            <label class="layui-form-label">手机号</label>
                                            <div class="layui-input-inline">
                                                <input type="text" class="layui-input filter-condition" filter-name="bd_employees.fphone" filter-operator="like" />
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
                                <th>顺序</th>
                                <th>姓名</th>
                                <th>工号</th>
                                <th>所属部门</th>
                                <th>职位</th>
                                <th>手机号</th>
                                <th>邮箱</th>
                                <th>设备</th>
                                <th>设备号</th>
                                <th>审核状态</th>
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

@endsection

@section('js')
    @include('admin.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
    <script type="text/javascript">

        $(function () {

            var orgs = {!! json_encode($orgs) !!}
            var depts = {!! json_encode($deptOptions) !!}
            var postions = {!! json_encode($positOptions) !!}
            seajs.use('app-employee', function (employee) {
            	employee.index($, 'moduleTable','tree', orgs, depts, postions);
            });
            
        });

    </script>
@endsection