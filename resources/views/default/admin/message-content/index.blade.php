@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>bd_message_contents</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">bd_message_contents</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content module" >
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">消息内容列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>标题</th>
                                <th>副标题</th>
                                <th>内容</th>
                                <th>创建时间</th>
                                <th>创建者</th>
                                <th>修改时间</th>
                                <th>修改者</th>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="message-modal">
            <div class="modal-dialog" role="document" style="width: 30%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">发送消息范围选择</h4>
                    </div>
                    <form class="form-horizontal" id="message-form" action="{{url('admin/message-content/send')}}">

                    <div class="modal-body">
                        <div class="box-body">

                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">可见范围</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="scope" name="scope">
                                        <option value="1">公开</option>
                                        <option value="2">部分可见</option>
                                    </select>
                                </div>
                            </div>

                            <div id="scope_hidden" style="display: none">
                                <div class="form-group" >
                                    <label class="col-sm-2 control-label">经销商</label>
                                    <div class="col-sm-10">
                                        <select class="form-control form-select" name="fcust_ids[]" data-live-search="true"  multiple data-actions-box="true">
                                            @foreach($customers as $c)
                                                <option value="{{$c->id}}">{{$c->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label class="col-sm-2 control-label">后台用户</label>
                                    <div class="col-sm-10">
                                        <select class="form-control form-select" name="fadmin_ids[]" data-live-search="true"  multiple data-actions-box="true">
                                            @foreach($admins as $a)
                                                <option value="{{$a->id}}">{{$a->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label class="col-sm-2 control-label">部门</label>
                                    <div class="col-sm-10">
                                        <select class="form-control form-select" name="fdept_ids[]" data-live-search="true"  multiple data-actions-box="true">
                                            @foreach($departments as $d)
                                                <option value="{{$d['value']}}">{{$d['label']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="content_id" name="message_content_id">


                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary" >保存</button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>







@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {

            seajs.use('admin/message_content.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection