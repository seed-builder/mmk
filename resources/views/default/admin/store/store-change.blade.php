@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css') @endsection @section('content')
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
            <div class="col-xs-6">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">门店基础信息</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="form-horizontal filter " filter-table="#moduleTable">

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">门店名称</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control filter-condition" filter-name="ffullname" filter-operator="like" />
                                    </div>

                                    <label class="col-sm-2 control-label">负责业代</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control filter-condition" filter-name="employee_fname" filter-operator="like" />
                                    </div>




                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">路线</label>
                                    <div class="col-sm-4">
                                        <select class="form-control filter-condition filter-select" filter-name="fline_id" data-live-search="true">
                                            <option value="">--请选择--</option>
                                            @foreach($lines as $l)
                                                <option value="{{$l->id}}">{{$l->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </div>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>门店编码</th>
                                <th>门店全称</th>
                                <th>负责业代</th>
                                <th>路线</th>
                            </tr>

                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-xs-6">
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
                        <div class="panel panel-default">
                            <form class="form-horizontal filter " filter-table="#empTable">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">姓名</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="bd_employees.fname" filter-operator="like" />
                                    </div>

                                    <label class="col-sm-2 control-label">工号</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="bd_employees.fnumber" filter-operator="like" />
                                    </div>

                                    <label class="col-sm-2 control-label">手机号</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="bd_employees.fphone" filter-operator="like" />
                                    </div>
                                </div>

                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="empTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>顺序</th>
                                <th>姓名</th>
                                <th>工号</th>
                                <th>所属部门</th>
                                <th>职位</th>
                                <th>手机号</th>
                                <th>邮箱</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>
    </section>



@endsection
@section('js')

    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/store-change.js', function (store) {
                store.index($, 'moduleTable','empTable');
            });

        });

    </script>
@endsection
