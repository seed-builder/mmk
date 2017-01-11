/**
 * Created by john on 2017-01-11.
 */
define(function(require, exports, module) {
    
    var zhCN = require('datatableZh');

    exports.index = function ($, tableId) {

        var editor = new $.fn.dataTable.Editor( {
            ajax: {
                create: {
                    type: 'POST',
                    url:  '/admin/role',
                    data: { _token: $('meta[name="_token"]').attr('content') },
                },
                edit: {
                    type: 'PUT',
                    url:  '/admin/role/_id_',
                    data: { _token: $('meta[name="_token"]').attr('content') },
                },
                remove: {
                    type: 'DELETE',
                    url:  '/admin/role/_id_',
                    data: { _token: $('meta[name="_token"]').attr('content') },
                }
            },
            table: "#"+tableId,
            idSrc:  'id',
            fields: [
                { 'label':  'name', 'name': 'name', },
                { 'label':  'display_name', 'name': 'display_name', },
                { 'label':  'description', 'name': 'description', },
                { 'label':  'icon', 'name': 'icon', },
            ]
        } );

        var table = $("#"+ tableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/role/pagination',
            columns: [
                { "data": "id" },
                { "data": "name" },
                { "data": "display_name" },
                { "data": "description" },
                { "data": "icon" },
                { "data": "created_at" },
                { "data": "updated_at" },
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                { extend: "create", text: '新增', editor: editor },
                { extend: "edit", text: '编辑',  editor: editor },
                { extend: "remove", text: '删除', editor: editor },
                { extend: 'excel', text: '导出Excel' },
                { extend: 'print', text: '打印' },
                { extend: 'colvis', text: '列显示'}
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