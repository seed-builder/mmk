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
                    url: '/admin/display-policy-log',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/display-policy-log/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/display-policy-log/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator_id', 'name': 'fcreator_id', },
                { 'label':  'fdate', 'name': 'fdate', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'femp_id', 'name': 'femp_id', },
                { 'label':  'flog_id', 'name': 'flog_id', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fmodify_id', 'name': 'fmodify_id', },
                { 'label':  'forg_id', 'name': 'forg_id', },
                { 'label':  'fphotos', 'name': 'fphotos', },
                { 'label':  'fpolicy_id', 'name': 'fpolicy_id', },
                { 'label':  'fpolicy_store_id', 'name': 'fpolicy_store_id', },
                { 'label':  'fremark', 'name': 'fremark', },
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
            ajax: '/admin/display-policy-log/pagination',
            columns: [
                    {  'data': 'fcreate_date' },
                    {  'data': 'fcreator_id' },
                    {  'data': 'fdate' },
                    {  'data': 'fdocument_status' },
                    {  'data': 'femp_id' },
                    {  'data': 'flog_id' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'fmodify_id' },
                    {  'data': 'forg_id' },
                    {  'data': 'fphotos' },
                    {  'data': 'fpolicy_id' },
                    {  'data': 'fpolicy_store_id' },
                    {  'data': 'fremark' },
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