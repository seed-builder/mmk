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
                    url: '/admin/display-policy',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/display-policy/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/display-policy/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fact_store_num', 'name': 'fact_store_num', },
                { 'label':  'famount', 'name': 'famount', },
                { 'label':  'fbill_no', 'name': 'fbill_no', },
                { 'label':  'fcost_dept_id', 'name': 'fcost_dept_id', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator_id', 'name': 'fcreator_id', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'fend_date', 'name': 'fend_date', },
                { 'label':  'fexp_type', 'name': 'fexp_type', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fmodify_id', 'name': 'fmodify_id', },
                { 'label':  'forg_id', 'name': 'forg_id', },
                { 'label':  'fsign_amount', 'name': 'fsign_amount', },
                { 'label':  'fsign_store_num', 'name': 'fsign_store_num', },
                { 'label':  'fsketch', 'name': 'fsketch', },
                { 'label':  'fstart_date', 'name': 'fstart_date', },
                { 'label':  'fstore_cost_limit', 'name': 'fstore_cost_limit', },
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
            ajax: '/admin/display-policy/pagination',
            columns: [
                    {  'data': 'fact_store_num' },
                    {  'data': 'famount' },
                    {  'data': 'fbill_no' },
                    {  'data': 'fcost_dept_id' },
                    {  'data': 'fcreate_date' },
                    {  'data': 'fcreator_id' },
                    {  'data': 'fdocument_status' },
                    {  'data': 'fend_date' },
                    {  'data': 'fexp_type' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'fmodify_id' },
                    {  'data': 'forg_id' },
                    {  'data': 'fsign_amount' },
                    {  'data': 'fsign_store_num' },
                    {  'data': 'fsketch' },
                    {  'data': 'fstart_date' },
                    {  'data': 'fstore_cost_limit' },
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