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
            { 'label':  'fbill_no', 'name': 'fbill_no', },
                { 'label':  'fcaption', 'name': 'fcaption', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator_id', 'name': 'fcreator_id', },
                { 'label':  'fcust_id', 'name': 'fcust_id', },
                { 'label':  'fdays', 'name': 'fdays', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'ffinish_date', 'name': 'ffinish_date', },
                { 'label':  'flog_id', 'name': 'flog_id', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fmodify_id', 'name': 'fmodify_id', },
                { 'label':  'forg_id', 'name': 'forg_id', },
                { 'label':  'frequire', 'name': 'frequire', },
                { 'label':  'freward_amount', 'name': 'freward_amount', },
                { 'label':  'freward_method', 'name': 'freward_method', },
                { 'label':  'fstart_date', 'name': 'fstart_date', },
                { 'label':  'fstatus', 'name': 'fstatus', },
                { 'label':  'fstore_id', 'name': 'fstore_id', },
                { 'label':  'fvalid_begin', 'name': 'fvalid_begin', },
                { 'label':  'fvalid_end', 'name': 'fvalid_end', },
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
            ajax: '/admin/display-policy/pagination',
            columns: [
                    {  'data': 'fbill_no' },
                    {  'data': 'fcaption' },
                    {  'data': 'fcreate_date' },
                    {  'data': 'fcreator_id' },
                    {  'data': 'fcust_id' },
                    {  'data': 'fdays' },
                    {  'data': 'fdocument_status' },
                    {  'data': 'ffinish_date' },
                    {  'data': 'flog_id' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'fmodify_id' },
                    {  'data': 'forg_id' },
                    {  'data': 'frequire' },
                    {  'data': 'freward_amount' },
                    {  'data': 'freward_method' },
                    {  'data': 'fstart_date' },
                    {  'data': 'fstatus' },
                    {  'data': 'fstore_id' },
                    {  'data': 'fvalid_begin' },
                    {  'data': 'fvalid_end' },
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