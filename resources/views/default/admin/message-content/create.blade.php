@extends('admin.layout.collapsed-sidebar')
@section('styles')
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote.css">
    <link rel="stylesheet" href="/assets/plugins/bootstrap-fileinput/css/fileinput.min.css">

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
                        <h3 class="box-title">新建消息</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <form class="form-horizontal" action="{{url('admin/message-content')}}" method="post">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">内容</label>

                                <div class="col-sm-9">
                                    <textarea id="content" class="form-control" name="content"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">附件</label>

                                <div class="col-sm-9">
                                    <input type="file"  class="form-control" name="sourceFile" multiple>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">提交</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>






@endsection
@section('js')
    <script src="/assets/plugins/summernote/summernote.js"></script>
    <script src="/assets/plugins/summernote/lang/summernote-zh-CN.js"></script>
    <script src="/assets/plugins/bootstrap-fileinput/js/fileinput.min.js"></script>
    <script src="/assets/plugins/bootstrap-fileinput/js/fileinput_locale_zh_CN.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#content').summernote({
                height: 300,
                lang: 'zh-CN'
            });
            $("input[type='file']").fileinput({
                showUpload : false,
                showRemove : true,
                language : 'zh_CN',
//                allowedPreviewTypes : [ 'image' ],
//                allowedFileExtensions : [ 'jpg', 'png'],
                maxFileSize : 5120,
                uploadUrl: '/admin/upload-file',
                initialPreview: [

                ],
            });

            $("input[type='file']").on("fileuploaded", function(event, data, previewId, index) {
                var imgUrl = data.response.data;
                if(imgUrl) {
                    $("<input type='hidden' name='files[]' value='" + imgUrl + "' />").appendTo('#' + previewId);
                }
            })

            $("input[type='file']").on('filedeleted', function(event, key) {
                $('#' + key).remove();
            });

            $("input[type='file']").on('fileloaded', function(event, file, previewId, index, reader) {
                $("input[type='file']").fileinput('upload');
            });
        });
    </script>

@endsection