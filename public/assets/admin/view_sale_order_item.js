/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId) {

        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
                url: '/admin/view-sale-order-item/pagination',
            },
            columns: [
                {  'data': 'employee_name' },
                {  'data': 'position_name' },
                {  'data': 'fdate' },
                {  'data': 'store_name' },
                {  'data': 'store_number' },
                {  'data': 'store_channel' },
                {  'data': 'customer_name' },
                {  'data': 'material_name' },
                {  'data': 'box_qty' },
                {  'data': 'bottle_qty' },
                {  'data': 'present_box_qty' },
                {  'data': 'present_bottle_qty' },
                {  'data': 'famount' },
                {  'data': 'fsend_status', render: function (data, type, full) {
                    return send_status(data);
                } },
                {  'data': 'fsend_date'},
            ],
            buttons: [
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