@extends('admin.layout.collapsed-sidebar')
@section('styles')
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote.css">
    <link rel="stylesheet" href="/assets/plugins/bootstrap-fileinput/css/fileinput.min.css">

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>系统管理

            <small>消息内容管理</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-anchor"></i> <span>系统管理</span></li>
            <li>消息内容编辑</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content module">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">编辑消息</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <form class="form-horizontal" action="{{url('admin/message-content/update/'.$entity->id)}}"
                          method="post">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title" value="{{$entity->title}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">副标题</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="subtitle" value="{{$entity->subtitle}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">内容</label>

                                <div class="col-sm-9">
                                    <textarea id="content" class="form-control"
                                              name="content">{{$entity->content}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">附件</label>

                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="sourceFile" multiple>
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
                showUpload: false,
                showRemove: true,
                language: 'zh_CN',
//                allowedPreviewTypes : [ 'image' ],
//                allowedFileExtensions : [ 'jpg', 'png'],
                maxFileSize: 5120,
                uploadUrl: '/admin/upload-file',
                overwriteInitial: false,
                showCaption: true,
                initialPreview: [
                    @if(count($entity->files)>0)
                            @foreach($entity->files as $f)
                            {{--'<img src="/admin/show-image?imageId={{$f->id}}" class="file-preview-image">'+--}}
                        '<input type="hidden" name="files[]" value="{{$f->id}}" />',
                    @endforeach
                    @endif
                ],
                initialPreviewConfig: [
                        @if(count($entity->files)>0)
                        @foreach($entity->files as $f)
                    {
                        type: "{{$f->ext}}",
                        size: '{{$f->size}}',
                        caption: "{{$f->name}}",
                        url: "{{url('/admin/fake-delete')}}",
                        key: '{{$f->id}}'
                    },
                    @endforeach
                    @endif
                ],
            });

            $("input[type='file']").on("fileuploaded", function (event, data, previewId, index) {
                var imgUrl = data.response.data;
                if (imgUrl) {
                    $("<input type='hidden' name='files[]' value='" + imgUrl + "' />").appendTo('#' + previewId);
                }
            })

            $("input[type='file']").on('filedeleted', function (event, key) {
                $('#' + key).remove();
            });

            $("input[type='file']").on('fileloaded', function (event, file, previewId, index, reader) {
                $("input[type='file']").fileinput('upload');
            });
        });
    </script>

@endsection