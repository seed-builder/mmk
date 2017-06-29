/**
*
*/
define(function(require, exports, module) {
    var zhCN = require('datatableZh');
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
                url : '/admin/view-customer-stock-statistic/pagination'
            },
            columns: [
                {  'data': 'cust_id' },
                {  'data': 'cust_name' },
                {  'data': 'material_number' },
                {  'data': 'material_name' },
                {  'data': 'material_specification' },
                {  'data': 'fsale_unit' },
                {  'data': 'fbase_unit' },
                {  'data': 'fqty', render: function (data, type, full) {
                    return full.box_qty;
                } },
                {  'data': 'fbase_qty', render: function (data, type, full) {
                    return full.bottle_qty;
                } },
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                // {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
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