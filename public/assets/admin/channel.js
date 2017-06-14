/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');

    exports.index = function ($, tableId, groupTableId, treeId, groups) {


        var groupEditor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/channel-group',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/channel-group/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/channel-group/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            table: "#" + groupTableId,
            i18n: editorCN,
            idSrc: 'id',
            fields: [
                {'label': '渠道代码', 'name': 'fnumber',},
                {'label': '渠道名称', 'name': 'fname',},
                {
                    'label': '父渠道组',
                    'name': 'fparent_id',
                    'type': 'select',
                    'options': groups
                },
            ],

        });

        var groupTable = $("#" + groupTableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
                url: '/admin/channel-group/pagination',
                data: function (data) {
                    var treeNode = $('#'+treeId).treeview('getSelected');
                    if (treeNode.length>0){
                        data['nodeid'] = treeNode[0].dataid;
                    }
                }
            },
            columns: [
                {'data': 'id'},
                {'data': 'fnumber'},
                {'data': 'fname'},
                {
                    "data": 'fparent_id',
                    render: function (data, type, full) {
                        if (full.parent_group != null)
                            return full.parent_group.fname
                        else
                            return "无";
                    }
                },
                {
                    "data": "fdocument_status",
                    render: function (data, type, full) {
                        return document_status(data);
                    }
                },
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: groupEditor},
                {
                    extend: "edit",
                    className: 'groupTableEdit',
                    text: '编辑<i class="fa fa-fw fa-pencil"></i>',
                    editor: groupEditor
                },
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: groupEditor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                {text: '审核<i class="fa fa-fw fa-paperclip"></i>', className: 'groupTableCheck', enabled: false},
                {text: '反审核<i class="fa fa-fw fa-unlink"></i>', className: 'groupTableUncheck', enabled: false},
                //{extend: 'colvis', text: '列显示'}
            ],
            columnDefs: [
                {
                    "targets": [3],
                    "visible": false
                }
            ]
        });

        groupTable.on('select', function () {
            table.ajax.reload();
        });

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/channel',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/channel/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/channel/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            table: "#" + tableId,
            i18n: editorCN,
            idSrc: 'id',
            fields: [
                {'label': '渠道代码', 'name': 'fnumber',},
                {'label': '渠道名称', 'name': 'fname',},
                {
                    'label': '所属渠道组',
                    'name': 'fgroup_id',
                    'type': 'select',
                    'options': groups
                },
                {'label': '备注', 'name': 'fremark', 'type': 'textarea'},
            ]
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
                url : '/admin/channel/pagination',
                data : function (data) {
                    var treeNode = $('#'+treeId).treeview('getSelected');
                    if (treeNode.length>0){
                        data['nodeid'] = treeNode[0].dataid;
                    }
                    data.columns[3]['search']['value'] = groupTable.rows('.selected').data()[0] != null ? groupTable.rows('.selected').data()[0].id : '';
                }
            },
            columns: [
                {'data': 'id'},
                {'data': 'fnumber'},
                {'data': 'fname'},
                {
                    "data": 'fgroup_id',
                    render: function (data, type, full) {
                        if (full.group != null)
                            return full.group.fname
                        else
                            return "";
                    }
                },
                {'data': 'fremark'},
                {
                    "data": "fdocument_status",
                    render: function (data, type, full) {
                        return document_status(data);
                    }
                },
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", className: 'tableEdit', text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                {text: '审核<i class="fa fa-fw fa-paperclip"></i>', className: 'tableCheck', enabled: false},
                {text: '反审核<i class="fa fa-fw fa-unlink"></i>', className: 'tableUncheck', enabled: false},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        var getTreeData = function () {
            $.ajax({
                url: "../../admin/channel-group/channelGroupTree",
                type: "POST",
                data: {'_token': $('meta[name="_token"]').attr('content')},
                dataType: 'json',
                success: function (data) {
                    $("#" + treeId).treeview({
                        color: "#428bca",
                        enableLinks: true,
                        levels: 99,
                        data: data,
                        onNodeSelected: function (event, data) {
                            groupTable.ajax.reload();
                            table.ajax.reload();
                        }
                    });
                },
            });
        }


        table.on('select', tableRowSelect).on('deselect', tableRowSelect);

        groupTable.on('select', groupTableRowSelect).on('deselect', groupTableRowSelect);

        function tableRowSelect() {
            checkEditEnabble(table, ['.tableEdit', '.tableCheck'], ['.tableUncheck']);
        }

        function groupTableRowSelect() {
            checkEditEnabble(groupTable, ['.groupTableEdit', '.groupTableCheck'], ['.groupTableUncheck']);
        }

        //渠道审核
        $(".tableCheck").on('click', function () {
            dataCheck(table, '/admin/channel/check');
        })

        $(".tableUncheck").on('click', function () {
            dataCheck(table, '/admin/channel/uncheck');
        })

        //渠道组审核
        $(".groupTableCheck").on('click', function () {
            dataCheck(groupTable, '/admin/channel-group/check');
        })

        $(".groupTableUncheck").on('click', function () {
            dataCheck(groupTable, '/admin/channel-group/uncheck');
        })

        getTreeData();

    }

});