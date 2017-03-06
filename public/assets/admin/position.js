/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,treeId) {
        var curNodeData;
        //组织结构初始化
        var getTreeData = function () {
            $.ajax({
                url: "/admin/position/tree",
                type: "get",
                data: {'_token':$('meta[name="_token"]').attr('content')},
                dataType:'json',
                success:function(data){
                    $("#" + treeId).treeview({
                        color: "#428bca",
                        enableLinks: true,
                        levels: 99,
                        data: data,
                        onNodeSelected: function(event, data) {
                            curNodeData = data;
                            console.log(data);
                            for(var p in data.item){
                                $('#'+p, '#positionForm').val(data.item[p]);
                            }
                            table.ajax.reload();
                        },
                        onNodeUnselected: function(event, data) {
                            curNodeData=null;
                        },
                    });
                },
            });
        }

        //tree btn
        $('#btnAddChild').click(function () {
            if (!curNodeData) {
                layer.alert('请先选择职位!');
                return;
            }
            $('#positionForm')[0].reset();
            $('#id').val(0);
            $('#fparpost_id').val(curNodeData['dataid']);
        });

        $('#btnAddSame').click(function () {
            if (!curNodeData) {
                layer.alert('请先选择职位!');
                return;
            }
            $('#positionForm')[0].reset();
            $('#id').val(0);
            $('#fparpost_id').val(curNodeData['item']['fparpost_id']);
        });


        $('#btnRemove').click(function () {
            if (!curNodeData) {
                layer.alert('请先选择职位!');
                return;
            }
            var title = '确定删除 ' + curNodeData.item['fname']+ ' 及下属所有职位 ?';
            layer.confirm(title, {
                title: '提示',
                buttons: ['确定', '取消'],
            }, function () {
                $.post('/admin/position/' + curNodeData['dataid'], {
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


        getTreeData();

        $('#positionForm').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                fname: {
                    validators: {
                        notEmpty: {},
                    }
                },
                fnumber: {
                    validators: {
                        notEmpty: {},
                    }
                },
                // fparpost_id: {
                //     validators: {
                //         notEmpty: {},
                //     }
                // },
                fdept_id: {
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

        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
                url : '/admin/employee/pagination',
                data : function (data) {
                    var selectedNode = $('#'+ treeId).treeview('getSelected');
                    if(selectedNode && selectedNode.length > 0) {
                        data['columns'][4]['search']['value'] = selectedNode[0]['dataid'];
                    }
                }
            },
            columns: [
                {"data": "id"},
                {"data": "fname"},
                {"data": "fnumber"},
                {
                    "data": 'fdept_id',
                    render: function ( data, type, full ) {
                        return full.dept_name;
                    }
                },
                {
                    "data": 'fpost_id',
                    render: function ( data, type, full ) {
                        return full.position_name;
                    }
                },
                {"data": "fphone"},
                {"data": "femail"},
                {"data": "device"},
                {"data": "device_sn"},

            ],
            "columnDefs": [
                {
                    "targets": [ 6,7,8 ],
                    "visible": false,
                    "searchable": false
                },
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                // {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                // {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                // {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                {extend: 'colvis', text: '列显示'}
            ]
        });
    }

});