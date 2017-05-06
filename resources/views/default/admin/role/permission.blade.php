@extends('admin.layout.collapsed-sidebar')
@section('styles')
    <link type="text/css" href="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.css" rel="stylesheet" />
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            用户权限管理
            <small>设置权限</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">用户权限管理</a></li>
            <li class="active">设置权限</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">角色【{{$role->display_name}}】权限设置</h3>
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
                        <div id="tree" ></div>
                        <form id="saveForm" method="post" action="#" >
                            {!! csrf_field() !!}
                            <input name="perms" id="perms" type="hidden">
                        </form>
                        <input class="btn btn-primary" type="button" value="保存" onclick="saveRolePerm()">
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
    <script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
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
        var treeData = {!! json_encode($perms) !!} ;
        $(function () {
            $("#tree").treeview({
                color: "#428bca",
                levels: 99,
                data: treeData,
                showIcon: false,
                showCheckbox:true,
                onNodeChecked:nodeChecked ,
                onNodeUnchecked:nodeUnchecked
            });
        });

        function saveRolePerm() {
            var nodes = $("#tree").treeview('getChecked');
            var ids = [];
            for(var i = 0; i < nodes.length; i++){
                ids[ids.length] = nodes[i].dataid;
            }
            //alert(ids.join(','));
            $('#perms').val(ids.join(','));
            $('#saveForm').submit();
        }
    </script>
    <script>
        var nodeCheckedSilent = false;
        function nodeChecked (event, node){
            if(nodeCheckedSilent){
                return;
            }
            nodeCheckedSilent = true;
            checkAllParent(node);
            checkAllSon(node);
            nodeCheckedSilent = false;
        }

        var nodeUncheckedSilent = false;
        function nodeUnchecked  (event, node){
            if(nodeUncheckedSilent)
                return;
            nodeUncheckedSilent = true;
            uncheckAllParent(node);
            uncheckAllSon(node);
            nodeUncheckedSilent = false;
        }

        //选中全部父节点
        function checkAllParent(node){
            $('#tree').treeview('checkNode',node.nodeId,{silent:true});
            var parentNode = $('#tree').treeview('getParent',node.nodeId);
            if(!("id" in parentNode)){
                return;
            }else{
                checkAllParent(parentNode);
            }
        }
        //取消全部父节点
        function uncheckAllParent(node){
            $('#tree').treeview('uncheckNode',node.nodeId,{silent:true});
            var siblings = $('#tree').treeview('getSiblings', node.nodeId);
            var parentNode = $('#tree').treeview('getParent',node.nodeId);
            if(!("id" in parentNode)) {
                return;
            }
            var isAllUnchecked = true;  //是否全部没选中
            for(var i in siblings){
                if(siblings[i].state.checked){
                    isAllUnchecked=false;
                    break;
                }
            }
            if(isAllUnchecked){
                uncheckAllParent(parentNode);
            }

        }

        //级联选中所有子节点
        function checkAllSon(node){
            $('#tree').treeview('checkNode',node.nodeId,{silent:true});
            if(node.nodes!=null&&node.nodes.length>0){
                for(var i in node.nodes){
                    checkAllSon(node.nodes[i]);
                }
            }
        }
        //级联取消所有子节点
        function uncheckAllSon(node){
            $('#tree').treeview('uncheckNode',node.nodeId,{silent:true});
            if(node.nodes!=null&&node.nodes.length>0){
                for(var i in node.nodes){
                    uncheckAllSon(node.nodes[i]);
                }
            }
        }
    </script>

@endsection