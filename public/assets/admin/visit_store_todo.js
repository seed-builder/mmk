/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,todos,funs) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/visit-store-todo',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/visit-store-todo/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/visit-store-todo/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': '编号', 'name': 'fnumber',},
                {'label': '名称', 'name': 'fname',},
                { 'label': '父级事项', 'name': 'fparent_id', 'type': 'select', 'options': todos},
                { 'label': '定制功能', 'name': 'ffunction_id', 'type': 'select', 'options': funs},
                { 'label': '是否必巡', 'name': 'fis_must_visit', 'type': 'select', 'options': [
                    { label: "是",value: "0" },
                    { label: "否",value: "1" },
                ]}
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
            ajax: '/admin/visit-store-todo/pagination',
            columns: [
                {'data': 'id'},
                {'data': 'fnumber'},
                {'data': 'fname'},

                {
                    'data': 'fparent_id',
                    render: function (data, type, full) {
                        if (full.parent != null)
                            return full.parent.fname
                        else
                            return "无";
                    }
                },
                {
                    'data': 'ffunction_id',
                    render: function (data, type, full) {
                        if (full.ffunction != null)
                            return full.ffunction.fname
                        else
                            return "无";
                    }
                },
                {'data': 'ffunction_number'},
                {
                    'data': 'fis_must_visit',
                    render: function (data, type, full) {
                        if (data == "0") {
                            return '是'
                        } else {
                            return '否'
                        }
                    }
                },
            ],
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
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