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
                    url: '/admin/price-group',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/price-group/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/price-group/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fbegin', 'name': 'fbegin', },
                { 'label':  'fchecker', 'name': 'fchecker', },
                { 'label':  'fcheck_date', 'name': 'fcheck_date', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator', 'name': 'fcreator', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'fend', 'name': 'fend', },
                { 'label':  'flevel', 'name': 'flevel', },
                { 'label':  'fmodifier', 'name': 'fmodifier', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fname', 'name': 'fname', },
                { 'label':  'fnumber', 'name': 'fnumber', },
                { 'label':  'fsuit_object', 'name': 'fsuit_object', },
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
            ajax: '/admin/price-group/pagination',
            columns: [
                    {  'data': 'fbegin' },
                    {  'data': 'fchecker' },
                    {  'data': 'fcheck_date' },
                    {  'data': 'fcreate_date' },
                    {  'data': 'fcreator' },
                    {  'data': 'fdocument_status' },
                    {  'data': 'fend' },
                    {  'data': 'flevel' },
                    {  'data': 'fmodifier' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'fname' },
                    {  'data': 'fnumber' },
                    {  'data': 'fsuit_object' },
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