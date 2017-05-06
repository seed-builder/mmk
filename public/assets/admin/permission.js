/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId, treeId) {
        // var editor = new $.fn.dataTable.Editor({
        //     ajax: {
        //         create: {
        //             type: 'POST',
        //             url: '/admin/permission',
        //             data: {_token: $('meta[name="_token"]').attr('content')},
        //         },
        //         edit: {
        //             type: 'PUT',
        //             url: '/admin/permission/_id_',
        //             data: {_token: $('meta[name="_token"]').attr('content')},
        //         },
        //         remove: {
        //             type: 'DELETE',
        //             url: '/admin/permission/_id_',
        //             data: {_token: $('meta[name="_token"]').attr('content')},
        //         }
        //     },
        //     i18n: editorCN,
        //     table: "#" + tableId,
        //     idSrc: 'id',
        //     fields: [
        //         { 'label':  '名称', 'name': 'name', },
        //         { 'label':  '显示名称', 'name': 'display_name', },
        //         { 'label':  '描述', 'name': 'description', 'type': 'textarea' }
        //     ]
        // });
        //
        // var table = $("#" + tableId).DataTable({
        //     dom: "lBfrtip",
        //     language: zhCN,
        //     processing: true,
        //     serverSide: true,
        //     select: true,
        //     paging: true,
        //     rowId: "id",
        //     ajax: '/admin/permission/pagination',
        //     columns: [
        //         {  'data': 'id' },
        //         {  'data': 'name' },
        //         {  'data': 'display_name' },
        //         {  'data': 'description' },
        //         {  'data': 'created_at' },
        //         {  'data': 'updated_at' },
        //     ],
        //     buttons: [
        //         // { text: '新增', action: function () { }  },
        //         // { text: '编辑', className: 'edit', enabled: false },
        //         // { text: '删除', className: 'delete', enabled: false },
        //         {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
        //         {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
        //         {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
        //         {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
        //         {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
        //         //{extend: 'colvis', text: '列显示'}
        //     ]
        // });

        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }
        var curNodeData;
        var getTreeData = function () {
            $.ajax({
                url: "/admin/permission/tree",
                type: "GET",
                //data: {'_token':$('meta[name="_token"]').attr('content')},
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
                                $('#'+p, '#permissionForm').val(data.item[p]);
                            }
                            $('.selectpicker').selectpicker('val', data.item['logo']);

                        },
                        onNodeUnselected: function(event, data) {
                            curNodeData=null;
                        },
                    });
                },
            });
        }

        getTreeData();

        //tree btn
        $('#btnAddChild').click(function () {
            if (!curNodeData) {
                layer.alert('请先选择职位!');
                return;
            }
            $('#permissionForm')[0].reset();
            $('#id').val(0);
            $('#pid').val(curNodeData['dataid']);
        });

        $('#btnAddSame').click(function () {
            if (!curNodeData) {
                layer.alert('请先选择职位!');
                return;
            }
            $('#permissionForm')[0].reset();
            $('#id').val(0);
            $('#pid').val(curNodeData['item']['pid']);
        });


        $('#btnRemove').click(function () {
            if (!curNodeData) {
                layer.alert('请先选择职位!');
                return;
            }
            var title = '确定删除 ' + curNodeData.item['display_name']+ ' 及下属所有职位 ?';
            layer.confirm(title, {
                title: '提示',
                buttons: ['确定', '取消'],
            }, function () {
                $.post('/admin/permission/' + curNodeData['dataid'], {
                    _method: 'delete',
                    _token: $('meta[name="_token"]').attr('content')
                }, function (res) {
                    layer.msg('成功!');
                    window.location.reload(true);
                })
            }, function () {
                layer.close();
            });
        });

        $('#permissionForm').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {},
                    }
                },
                display_name: {
                    validators: {
                        notEmpty: {},
                    }
                },
                pid: {
                    validators: {
                        notEmpty: {},
                    }
                },

            }
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();
            // Get the form instance
            var $form = $(e.target);
            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function (result) {
                if(result)
                {
                    layer.msg('保存成功!');
                    window.location.reload(true);
                }
            }, 'json');
        });

    }

});