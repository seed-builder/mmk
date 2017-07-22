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
                    url: '/admin/carousel',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/carousel/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/carousel/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                { 'label':  '名称', 'name': 'fname', },
                { 'label':  '排序', 'name': 'fseq', },
                {
                    label: "Image:",
                    name: "fpicture_id",
                    type: "upload",
                    display: function ( file_id ) {
                        //alert(file_id);
                        return '<img src="/admin/show-image?imageId='+ file_id + '"/>';
                    },
                    clearText: "Clear",
                    noImageText: 'No image'
                }
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
            ajax: '/admin/carousel/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'fname' },
                {  'data': 'fseq' },
                {  'data': 'fcreate_date' },
                {  'data': 'fmodify_date' },
                {
                    data: "fpicture_id",
                    render: function ( file_id ) {
                        return file_id ?
                            '<img src="/admin/show-image?imageId='+ file_id + '" style="max-height: 50px;"/>' :
                            null;
                    },
                    defaultContent: "No image",
                    // title: "Image"
                }
            ],
            order:[[2,'asc']],
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