@extends('admin.layout.collapsed-sidebar')
@section('styles')
    <link type="text/css" href="/assets/plugins/bootstrap-select/bootstrap-select.css" rel="stylesheet"/>
    <style>
        .tangram-suggestion-main {
            z-index: 9999;
        }
        .layui-form-label{
            width: 100px;
        }
    </style>
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
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">组织架构信息</h3>
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
                        <div id="tree" tree-type="employee-tree"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">门店地图定位</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div id="allmap" style="height: 300px;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>

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
                                    <label class="col-sm-1 control-label">门店名称</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control filter-condition" filter-name="ffullname" filter-operator="like" />
                                    </div>

                                    <label class="col-sm-1 control-label">负责业代</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control filter-condition" filter-name="employee_fname" filter-operator="like" />
                                    </div>
                                    <label class="col-sm-1 control-label">路线</label>
                                    <div class="col-sm-3">
                                        <select class="form-control filter-condition filter-select" filter-name="fline_id" data-live-search="true">
                                            <option value="">--请选择--</option>
                                            @foreach($lines as $l)
                                                <option value="{{$l->id}}">{{$l->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>



                                </div>
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">经销商</label>
                                    <div class="col-sm-3">
                                        <select class="form-control filter-condition filter-select" filter-name="fcust_id" data-live-search="true">
                                            <option value="">--请选择--</option>
                                            @foreach($cus as $c)
                                                <option value="{{$c->id}}">{{$c->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label class="col-sm-1 control-label">渠道</label>
                                    <div class="col-sm-3">
                                        <select class="form-control filter-condition filter-select" filter-name="fchannel" data-live-search="true">
                                            <option value="">--请选择--</option>
                                            @foreach($channels as $c)
                                                <option value="{{$c->id}}">{{$c->fname}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label class="col-sm-1 control-label">是否签约</label>
                                    <div class="col-sm-3">
                                        <select class="form-control filter-condition filter-select" filter-name="fis_signed" >
                                            <option value="">--请选择--</option>
                                            <option value="0">未签约</option>
                                            <option value="1">已签约</option>
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
                                <th>flongitude</th>
                                <th>flatitude</th>
                                <th>门店编码</th>
                                <th>门店全称</th>
                                <th>详细地址</th>
                                <th>负责人</th>
                                <th>联系电话</th>
                                <th>负责业代</th>
                                <th>经销商</th>
                                <th>路线</th>
                                <th>渠道</th>
                                <th>是否签约</th>
                                <th>审核状态</th>
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
    </section>


    <div class="modal fade" tabindex="-1" role="dialog" id="storeinfo">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">门店信息</h4>
                </div>
                <form class="layui-form" enctype="multipart/form-data" id="storeInfoForm" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#info_tab" data-toggle="tab" aria-expanded="true">基本信息</a></li>
                            <li><a href="#extra_tab" data-toggle="tab" aria-expanded="false">更多信息</a></li>
                            <li><a href="#map_tab" data-toggle="tab">地图选址</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="info_tab">
                                <div class="box-body">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">门店名称</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="ffullname" required lay-verify="required" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">门店简称</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="fshortname" required lay-verify="" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">负责人</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="fcontracts" required lay-verify="required" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">联系电话</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="ftelephone" required lay-verify="required" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>

                                    <div class="layui-form-item">
                                        <label class="layui-form-label">拜访周期</label>
                                        <div class="layui-input-block">
                                            <select name="fline_id" lay-filter="fline">
                                                @foreach($lines as $l)
                                                    <option value="{{$l->id}}">{{$l->fname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">客户详址</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="faddress" required lay-verify="required" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">邮政编码</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="fpostalcode" required lay-verify="required" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="extra_tab">
                                <div class="box-body">
                                    <div class="layui-form-item" style="display: none">
                                        <label class="layui-form-label col-sm-3">经纬度</label>
                                        <div class="layui-input-block">
                                            <input type="text" id="flongitude" name="flongitude" required lay-verify="map" autocomplete="off" class="layui-input">
                                            <input type="text" id="flatitude" name="flatitude" required lay-verify="map" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>

                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">渠道分类</label>
                                        <div class="layui-input-block">
                                            <select name="fchannel" lay-filter="fchannel" lay-search>
                                                @foreach($channels as $f)
                                                    <option value="{{$f->id}}">{{$f->fname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">客户分级</label>
                                        <div class="layui-input-block">
                                            <select name="fcust_id" lay-filter="fcust_id" lay-search>
                                                @foreach($cus as $c)
                                                    <option value="{{$c->id}}">{{$c->fname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">营业执照</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="fbusslicense" required lay-verify="" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">税号</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="fdutyparagraphe" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">开户银行</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="fbankaccount" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>

                                    <div class="layui-form-item layui-form-text">
                                        <label class="layui-form-label">备注</label>
                                        <div class="layui-input-block">
                                            <textarea name="fremark" class="layui-textarea"></textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label col-sm-3">门店照片</label>
                                        <div class="layui-input-block">
                                            <input class="form-data" id="storepic" type="file" name="storephoto">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="map_tab">
                                <div class="modal-body">
                                    <div class="input-group input-group-sm" style="margin-bottom: 20px">
                                        <input class="form-control" id="suggestId" size="20" value="百度" >
                                        <span class="input-group-btn">
                                          <button type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i></button>
                                        </span>
                                        <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
                                    </div>

                                    <div id="smap" style="height: 500px"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <input type="hidden" name="femp_id" id="femp_id" class="layui-input">
                        <input type="hidden" name="id" id="store_id" class="layui-input">
                        <input type="hidden" name="fprovince" id="fprovince" class="layui-input">
                        <input type="hidden" name="fcity" id="fcity" class="layui-input">
                        <input type="hidden" name="fcountry" id="fcountry" class="layui-input">
                        <input type="hidden" name="fstreet" id="fstreet" class="layui-input">

                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        {{--<button type="submit" class="btn btn-primary" id="storeSave">保存</button>--}}
                        <button class="btn btn-primary pull-right" lay-submit lay-filter="storeInfoForm">保存</button>
                    </div>

                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div id="storeDetail" class="modal fade modal-scroll" role="dialog" tabindex="-1" data-replace="true">
        <div class="modal-dialog" style="width: 50%">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div id="exchange-modal" class="modal fade modal-scroll" role="dialog" tabindex="-1" data-replace="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">门店调换</h4>
                </div>
                <form class="form-horizontal" id="exchangeForm" action="{{url('admin/store/exchange')}}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-sm-3">旧员工</label>
                            <div class="col-sm-9">
                                <select class="form-control filter-select" name="old_femp_id" data-live-search="true">
                                    <option value="">--请选择--</option>
                                    @foreach($employees as $e)
                                        <option value="{{$e->id}}">{{$e->fname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">新员工</label>
                            <div class="col-sm-9">
                                <select class="form-control filter-select" name="new_femp_id" data-live-search="true">
                                    <option value="">--请选择--</option>
                                    @foreach($employees as $e)
                                        <option value="{{$e->id}}">{{$e->fname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-right">调换门店</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="/assets/plugins/bootstrap-fileinput/js/fileinput.min.js"></script>
    <script src="/assets/plugins/bootstrap-fileinput/js/fileinput_locale_zh_CN.js"></script>
    <script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
    <script src="/assets/plugins/bootstrap-select/bootstrap-select.js"></script>
    <script src="/assets/plugins/bootstrap-select/i18n/defaults-zh_CN.js"></script>
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=D4Bi3270ydgA5HsnWDnmBVwF3zaPdoMC"></script>

    @include('admin.layout.datatable-js')
    <script type="text/javascript">

        $(function () {
            seajs.use('app-store', function (store) {
                store.index($, 'moduleTable', 'tree', 'allmap','smap');
            });


            $("#storepic").fileinput({
                overwriteInitial: true,
                maxFileSize: 1500,
                showClose: false,
                showCaption: false,
                showBrowse: false,
                browseOnZoneClick: true,
                removeLabel: '',
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                removeTitle: '删除',
                browseLabel: '',
                browseIcon: '<i class="fa fa-fw fa-cloud-upload"></i>',
                browseTitle: '选择你要上传的图片',
                elErrorContainer: '#kv-avatar-errors-2',
                msgErrorClass: 'alert alert-block alert-danger',
                defaultPreviewContent: '',
                layoutTemplates: {main2: '{preview} ' + ' {remove} {browse}'},
                allowedFileExtensions: ["jpg", "png", "gif"]
            });
        });


    </script>
@endsection
