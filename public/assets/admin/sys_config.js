/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/sys-config',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/sys-config/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/sys-config/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                { 'label':  '名称', 'name': 'name', 'type':'select','options':[
                    {'label':'app端数据隔离', 'value':'app-data-isolate'},
                    {'label':'后端数据隔离', 'value':'mgt-data-isolate'},
                    {'label':'不参与数据隔离的员工', 'value':'no-data-isolate-employees'},
                    {'label':'建议销售系数', 'value':'sale-variable'},
                    {'label':'门店拜访控制距离(单位米)', 'value':'store-visit-distance'},
                ]},
                { 'label':  '描述', 'name': 'desc', },
                { 'label':  '值', 'name': 'value', },
                { 'label':  '状态', 'name': 'status', 'type':'select', 'options': [{'label':'禁用', value:0},{'label': '启用', value: 1}], def: 1},
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
            ajax: '/admin/sys-config/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'name' },
                {  'data': 'desc' },
                {  'data': 'value' },
                {  'data': 'status', 'render': function (data) {
                    return data == 1 ? '启用':'禁用';
                } },
                {  'data': 'created_at' },
                {  'data': 'updated_at' },
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

        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

    }

});