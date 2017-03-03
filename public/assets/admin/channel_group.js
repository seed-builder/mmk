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
            table: "#" + tableId,
            idSrc: 'id',
            i18n: editorCN,
            fields: [
            { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator_id', 'name': 'fcreator_id', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fmodify_id', 'name': 'fmodify_id', },
                { 'label':  'fname', 'name': 'fname', },
                { 'label':  'fnumber', 'name': 'fnumber', },
                { 'label':  'fparent_id', 'name': 'fparent_id', },
                { 'label':  'fsort', 'name': 'fsort', },
                { 'label':  'ftype', 'name': 'ftype', },
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
            ajax: '/admin/channel-group/pagination',
            columns: [
                    {  'data': 'fcreate_date' },
                    {  'data': 'fcreator_id' },
                    {  'data': 'fdocument_status' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'fmodify_id' },
                    {  'data': 'fname' },
                    {  'data': 'fnumber' },
                    {  'data': 'fparent_id' },
                    {  'data': 'fsort' },
                    {  'data': 'ftype' },
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