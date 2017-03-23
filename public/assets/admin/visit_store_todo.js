/**
 *
 */
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, treeId) {
        var curNodeData;

        var getTreeData = function () {
            $.ajax({
                url: "/admin/visit-store-todo/todoTree",
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

        $('#btnAddChild').click(function () {
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
                layer.closeAll();
            })

        });
        $('#todoForm').on('submit',function () {
            ajaxForm('#todoForm',function () {
                getTreeData();
            })

            return false;
        })


        getTreeData();
    }

});