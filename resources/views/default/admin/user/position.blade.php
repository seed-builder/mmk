@extends('admin.layout.collapsed-sidebar')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            用户权限管理
            <small>设置职位</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">用户权限管理</a></li>
            <li><a href="/admin/user">用户管理</a></li>
            <li class="active">设置职位</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">用户【{{$user->name}}】职位设置</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" action="#" >
                            {!! csrf_field() !!}
                            <table id="moduleTable" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" onchange="cball(this)" /> </th>
                                    <th>名称</th>
                                    <th>编号</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($positions as $position)
                                    <tr onclick="cbsingle(this)">
                                        <td><input class="cb" type="checkbox" name="positions[]" value="{{$position['value']}}" {{$user->hasPosition($position['value']) ? 'checked':''}}/></td>
                                        <td>{{$position['label']}}</td>
                                        <td>{{$position['fnumber']}}</td>

                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            <input class="btn btn-primary" type="submit" value="保存">
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

    <script type="text/javascript">
        function cball(cb) {
            //alert(cb.checked);
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