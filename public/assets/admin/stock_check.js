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
                    url: '/admin/stock-check',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/stock-check/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/stock-check/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fchecker_id', 'name': 'fchecker_id', },
                { 'label':  'fcheck_date', 'name': 'fcheck_date', },
                { 'label':  'fcheck_status', 'name': 'fcheck_status', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcust_id', 'name': 'fcust_id', },
                { 'label':  'fcust_user_id', 'name': 'fcust_user_id', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
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
            ajax: '/admin/stock-check/pagination',
            columns: [
                    {  'data': 'fchecker_id' },
                    {  'data': 'fcheck_date' },
                    {  'data': 'fcheck_status' },
                    {  'data': 'fcreate_date' },
                    {  'data': 'fcust_id' },
                    {  'data': 'fcust_user_id' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'id' },
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