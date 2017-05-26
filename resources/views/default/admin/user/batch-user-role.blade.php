@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">系统用户列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                {{--<th>id</th>--}}
                                <th>登陆名</th>
                                <th>昵称</th>
                                {{--<th>Email</th>--}}
                                <th>类型</th>
                                <th>状态</th>
                                <th>创建时间</th>
                                <th>修改时间</th>
                                <th>操作</th>
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

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">用户角色设置</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form id="form-id" method="post" action="#" >
                            {!! csrf_field() !!}
                            <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" onchange="cball(this)" /> </th>
                                    <th>名称</th>
                                    <th>显示名称</th>
                                    <th>描述</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($roles as $role)
                                    <tr onclick="cbsingle(this)">
                                        <td><input class="cb" type="checkbox" name="roles[]" value="{{$role->id}}"/></td>
                                        <td>{{$role->name}}</td>
                                        <td>{{$role->display_name}}</td>
                                        <td>{{$role->description}}</td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            <input type="hidden" id="user_ids" name="user_ids" value="">

                            <input class="btn btn-primary form-submit" type="button" value="保存">
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
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/batch-user-role.js', function (app) {
                app.index($, 'moduleTable');
            });
        });

        function cball(cb) {
            if(cb.checked){
                $('.cb').each(function(i, el){
                    //alert(el);
                    el.checked = true;
                });
            }else{
                $('.cb').each(function(i, el){
                    //alert(el);
                    el.checked = false;
                });
            }
        }

        function cbsingle(tr) {
            $('input[type=checkbox]', $(tr)).click();
        }
    </script>

@endsection