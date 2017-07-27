/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/visit-todo-group',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/visit-todo-group/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/visit-todo-group/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': 'fcategory', 'name': 'fcategory', type: 'hidden', def: 2},
                {'label': '拜访方案名称', 'name': 'fname',},
                {'label': '备注', 'name': 'fremark',},
                {
                    'label': '开始时间',
                    'name': 'fstart_date',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },

                {
                    'label': '结束时间',
                    'name': 'fend_date',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },
                { 'label':  '是否为默认方案', 'name': 'fis_default', 'type':'select', 'options': [{'label':'否', value:0},{'label': '是', value: 1}]},
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
                url: '/admin/visit-todo-group/pagination',
                data: function (data) {
                    data.columns[1]['search']['value'] = 2
                }
            },
            columns: [
                {'data': 'id'},
                {'data': 'fcategory'},
                {'data': 'fname'},
                {'data': 'fremark'},
                {'data': 'fstart_date'},
                {'data': 'fend_date'},
                {'data': 'fis_default', render: function (data) {
                    return data == 1 ? '是':"否";
                }},
                {'data': 'fcreate_date'},

            ],
            columnDefs: [
                {
                    "targets": [0,1],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                // {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                {extend: 'colvis', text: '列显示'}
            ]
        });

        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

    }

});