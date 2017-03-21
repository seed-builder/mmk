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
                    url: '/admin/visit-todo-temp',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/visit-todo-temp/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/visit-todo-temp/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fchildren_calculate', 'name': 'fchildren_calculate', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator_id', 'name': 'fcreator_id', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'ffunction_id', 'name': 'ffunction_id', },
                { 'label':  'ffunction_number', 'name': 'ffunction_number', },
                { 'label':  'fgroup_id', 'name': 'fgroup_id', },
                { 'label':  'fis_must_visit', 'name': 'fis_must_visit', },
                { 'label':  'flag', 'name': 'flag', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fmodify_id', 'name': 'fmodify_id', },
                { 'label':  'fname', 'name': 'fname', },
                { 'label':  'fnumber', 'name': 'fnumber', },
                { 'label':  'forg_id', 'name': 'forg_id', },
                { 'label':  'fparent_id', 'name': 'fparent_id', },
                { 'label':  'fstore_id', 'name': 'fstore_id', },
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
            ajax: '/admin/visit-todo-temp/pagination',
            columns: [
                    {  'data': 'fchildren_calculate' },
                    {  'data': 'fcreate_date' },
                    {  'data': 'fcreator_id' },
                    {  'data': 'fdocument_status' },
                    {  'data': 'ffunction_id' },
                    {  'data': 'ffunction_number' },
                    {  'data': 'fgroup_id' },
                    {  'data': 'fis_must_visit' },
                    {  'data': 'flag' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'fmodify_id' },
                    {  'data': 'fname' },
                    {  'data': 'fnumber' },
                    {  'data': 'forg_id' },
                    {  'data': 'fparent_id' },
                    {  'data': 'fstore_id' },
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