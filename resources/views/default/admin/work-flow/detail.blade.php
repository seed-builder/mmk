@extends('admin.layout.collapsed-sidebar')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            工作流
            <small>配置管理</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">工作流</a></li>
            <li><a href="/admin/work-flow">配置管理</a></li>
            <li class="active">配置详情</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">工作流配置</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                         <iframe src="/admin/work-flow/{{$id}}/edit" style="width: 100%; height: 600px;" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/work_flow.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection