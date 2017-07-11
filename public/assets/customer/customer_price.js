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
                    url: '/customer/customer-price',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/customer/customer-price/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/customer/customer-price/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcust_id', 'name': 'fcust_id', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'finvalid_date', 'name': 'finvalid_date', },
                { 'label':  'finvalid_operator', 'name': 'finvalid_operator', },
                { 'label':  'fis_valid', 'name': 'fis_valid', },
                { 'label':  'fmaterial_id', 'name': 'fmaterial_id', },
                { 'label':  'fmax_qty', 'name': 'fmax_qty', },
                { 'label':  'fmin_qty', 'name': 'fmin_qty', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fprice_bottle', 'name': 'fprice_bottle', },
                { 'label':  'fprice_box', 'name': 'fprice_box', },
                { 'label':  'fsale_unit', 'name': 'fsale_unit', },
                { 'label':  'fspecification', 'name': 'fspecification', },
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
            ajax: '/customer/customer-price/pagination',
            columns: [
                    {  'data': 'fcreate_date' },
                    {  'data': 'fcust_id' },
                    {  'data': 'fdocument_status' },
                    {  'data': 'finvalid_date' },
                    {  'data': 'finvalid_operator' },
                    {  'data': 'fis_valid' },
                    {  'data': 'fmaterial_id' },
                    {  'data': 'fmax_qty' },
                    {  'data': 'fmin_qty' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'fprice_bottle' },
                    {  'data': 'fprice_box' },
                    {  'data': 'fsale_unit' },
                    {  'data': 'fspecification' },
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