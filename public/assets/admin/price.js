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
                    url: '/admin/price',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/price/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/price/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fchecker', 'name': 'fchecker', },
                { 'label':  'fcheck_date', 'name': 'fcheck_date', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'fgroup_id', 'name': 'fgroup_id', },
                { 'label':  'fmaterial_id', 'name': 'fmaterial_id', },
                { 'label':  'fmax_qty', 'name': 'fmax_qty', },
                { 'label':  'fmin_qty', 'name': 'fmin_qty', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fprice', 'name': 'fprice', },
                { 'label':  'fsale_unit', 'name': 'fsale_unit', },
                { 'label':  'fspecification', 'name': 'fspecification', },
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
            ajax: '/admin/price/pagination',
            columns: [
                    {  'data': 'fchecker' },
                    {  'data': 'fcheck_date' },
                    {  'data': 'fcreate_date' },
                    {  'data': 'fdocument_status' },
                    {  'data': 'fgroup_id' },
                    {  'data': 'fmaterial_id' },
                    {  'data': 'fmax_qty' },
                    {  'data': 'fmin_qty' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'fprice' },
                    {  'data': 'fsale_unit' },
                    {  'data': 'fspecification' },
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