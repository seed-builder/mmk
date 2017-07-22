/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId, customers, materials) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/customer-price',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/customer-price/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/customer-price/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                { 'label':  '经销商', 'name': 'fcust_id', 'type': 'select', 'options': customers},
                { 'label':  '产品', 'name': 'fmaterial_id', 'type': 'select', 'options': materials},
                // { 'label':  '销售起数量', 'name': 'fmin_qty', def: 0},
                // { 'label':  '销售止数量', 'name': 'fmax_qty', def: 1000000},
                { 'label':  '单价/箱', 'name': 'fprice_box', },
                { 'label':  '单价/瓶', 'name': 'fprice_bottle', },
            ]
        });

        editor.on('open', function (e, json, data) {
            $("#DTE_Field_fcust_id").selectpicker({liveSearch: true});
            $("#DTE_Field_fmaterial_id").selectpicker({liveSearch: true});
        })
        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/customer-price/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'fcust_id', render: function (data, type, full) {
                    return full.customer ? full.customer.fname : '';
                } },
                {  'data': 'fmaterial_id', render: function (data, type, full) {
                    return full.material ? full.material.fname : '';
                } },
                {  'data': 'fspecification' },
                {  'data': 'fsale_unit' },
                {  'data': 'fmin_qty' },
                {  'data': 'fmax_qty' },
                {  'data': 'fprice_box' },
                {  'data': 'fprice_bottle' },
                {  'data': 'fdocument_status', render: function (data, type, full) {
                    return document_status(data);
                } },
                {  'data': 'fis_valid', render: function (data, type, full) {
                    return data == 1 ? '是' : '否';
                } },
                {  'data': 'fcreate_date' },
                {  'data': 'fmodify_date' },
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {text: '审核<i class="fa fa-fw fa-paperclip"></i>', className: 'check', enabled: false},
                {text: '反审核<i class="fa fa-fw fa-unlink"></i>', className: 'uncheck', enabled: false},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        table.on( 'select', checkBtn).on( 'deselect', checkBtn);

        function checkBtn(e, dt, type, indexes) {
            // var count = table.rows( { selected: true } ).count();
            // table.buttons( ['.edit', '.delete'] ).enable(count > 0);
            checkEditEnabble(table, ['.check'], ['.uncheck']);
        }
        //审核
        $(".check").on('click', function () {
            dataCheck(table, '/admin/customer-price/check');
        })

        $(".uncheck").on('click', function () {
            dataCheck(table, '/admin/customer-price/uncheck');
        })
    }

});