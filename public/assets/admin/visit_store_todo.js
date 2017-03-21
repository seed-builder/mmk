/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, treeId,todos,funs) {
        var curNodeData;

        var getTreeData = function () {
            $.ajax({
                url: "/admin/visit-store-todo/todoTree",
                type: "GET",
                data: {
                    'fstore_id' : $("#store-list").val(),
                    '_token':$('meta[name="_token"]').attr('content')
                },
                dataType:'json',
                success:function(data){
                    $("#" + treeId).treeview({
                        color: "#428bca",
                        enableLinks: true,
                        levels: 99,
                        data: data,
                        onNodeSelected: function(event, data) {
                            curNodeData = data;

                            for(var p in data.item){
                                $('#'+p, '#todoForm').val(data.item[p]);
                            }
                        },
                        onNodeUnselected: function(event, data) {
                            curNodeData=null;
                        },
                    });
                },
            });
        }

        $("#store-list").select2({
            language: 'zh-CN',
            height : '50px'
        })

        $('#btnAddChild').click(function () {
            if ($("#use_template").val()==2){
                layer.alert('当前为模板，请先保存后在编辑!');
                return;
            }
            if (!curNodeData) {
                layer.alert('请先选择一个事项!');
                return;
            }
            // $('#todoForm')[0].reset();
            $("#fname").val('')
            $('#id').val(0);
            $('#fparent_id').val(curNodeData['dataid']);
        });

        $('#btnAddSame').click(function () {
            if ($("#use_template").val()==2){
                layer.alert('当前为模板，请先保存后在编辑!');
                return;
            }
            if (!curNodeData) {
                layer.alert('请先选择一个事项!');
                return;
            }
            // $('#todoForm')[0].reset();
            $("#fname").val('')
            $('#id').val(0);
            $('#fparent_id').val(curNodeData['item']['fparent_id']);
        });

        $('#btnRemove').click(function () {
            if (!curNodeData) {
                layer.alert('请先选择一个事项!');
                return;
            }
            
            layer.confirm('确定删除 ' + curNodeData.item['fname']+ ' 及其子事项 ?',function () {
                ajaxLink('/admin/visit-store-todo/delete/'+curNodeData['dataid']);
                getTreeData();
                todos();
                layer.closeAll();
            })

        });

        $('#todoForm').on('submit',function () {
            if ($("#use_template").val()==2){
                layer.load(2);
            }
            ajaxForm('#todoForm',function () {
                todos();
                getTreeData();
                $("#use_template").val(1)
                layer.closeAll("loading")
            })

            return false;
        })


        var todos = function () {
            ajaxGetData('/admin/visit-store-todo/todos/'+$("#store-list").val(),function(data){
                if (data.length==0){
                    $("#template").show();
                }else {
                    $("#template").hide();
                }
                var html = "<option value='0'>无</option>"
                for (i in data){
                    html+="<option value='"+data[i].id+"'>"+data[i].fname+"</option>"
                }
                $("#fparent_id").html(html)
            })
        }

        $("#store-list").on('change',function () {
            todos();
            getTreeData();
        })

        $("#use_template").on('change',function () {
            var use = $("#use_template").val();
            if (use==1)
                getTreeData()
            else if (use==2){
                $.ajax({
                    url: "/admin/visit-store-todo/todos-template",
                    type: "GET",
                    data: {
                        '_token':$('meta[name="_token"]').attr('content')
                    },
                    dataType:'json',
                    success:function(data){
                        $("#" + treeId).treeview({
                            color: "#428bca",
                            enableLinks: true,
                            levels: 99,
                            data: data,
                            onNodeSelected: function(event, data) {
                            },
                            onNodeUnselected: function(event, data) {
                            },
                        });
                    },
                });

            }

        })


        todos();
        getTreeData();

    }

});