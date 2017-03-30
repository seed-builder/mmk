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
                    url: '/admin/kpi',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/kpi/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/kpi/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fapr', 'name': 'fapr', },
                { 'label':  'faug', 'name': 'faug', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator_id', 'name': 'fcreator_id', },
                { 'label':  'fdec', 'name': 'fdec', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'feb', 'name': 'feb', },
                { 'label':  'femp_id', 'name': 'femp_id', },
                { 'label':  'fjan', 'name': 'fjan', },
                { 'label':  'fjul', 'name': 'fjul', },
                { 'label':  'fjun', 'name': 'fjun', },
                { 'label':  'fmar', 'name': 'fmar', },
                { 'label':  'fmay', 'name': 'fmay', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fmodify_id', 'name': 'fmodify_id', },
                { 'label':  'fnov', 'name': 'fnov', },
                { 'label':  'foct', 'name': 'foct', },
                { 'label':  'fsep', 'name': 'fsep', },
                { 'label':  'ftype', 'name': 'ftype', },
                { 'label':  'fyear', 'name': 'fyear', },
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
            ajax: '/admin/kpi/pagination',
            columns: [
                    {  'data': 'fapr' },
                    {  'data': 'faug' },
                    {  'data': 'fcreate_date' },
                    {  'data': 'fcreator_id' },
                    {  'data': 'fdec' },
                    {  'data': 'fdocument_status' },
                    {  'data': 'feb' },
                    {  'data': 'femp_id' },
                    {  'data': 'fjan' },
                    {  'data': 'fjul' },
                    {  'data': 'fjun' },
                    {  'data': 'fmar' },
                    {  'data': 'fmay' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'fmodify_id' },
                    {  'data': 'fnov' },
                    {  'data': 'foct' },
                    {  'data': 'fsep' },
                    {  'data': 'ftype' },
                    {  'data': 'fyear' },
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