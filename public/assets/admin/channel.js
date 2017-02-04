/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');

    exports.index = function ($, tableId, groupTableId, treeId, groups) {
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
            ]
        });

        var table = $("#" + tableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/channel/pagination',
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
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

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
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/channel-group/pagination',
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
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: groupEditor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: groupEditor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: groupEditor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ],
            columnDefs: [
                {
                    "targets": [3],
                    "visible": false
                }
            ]
        });

        groupTable.on('select', searchChannelTable);

        function searchChannelTable() {
            var selected_group_id = groupTable.rows('.selected').data()[0].id
            table.columns(3).search(selected_group_id)
                .draw();
        }

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
                            searchGroupTable(data.dataid);
                        }
                    });
                },
            });
        }

        var searchGroupTable = function (id) {
            groupTable.columns(0).search(id)
                .draw();
            table.columns(3).search(id)
                .draw();
        }


        getTreeData();

    }

});