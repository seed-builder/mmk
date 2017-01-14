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
            <li class="active">角色管理</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">角色列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>顺序</th>
                                <th>姓名</th>
                                <th>工号</th>
                                <th>所属组织</th>
                                <th>所属部门</th>
                                <th>职位</th>
                                <th>个人手机号</th>
                                <th>邮箱</th>
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
    <script type="text/javascript">

        $(function () {

            var orgs = {!! json_encode($orgs) !!}
            seajs.use('app-employee', function (employee) {
            	employee.index($, 'moduleTable', orgs);
            });
            
        });

    </script>
@endsection