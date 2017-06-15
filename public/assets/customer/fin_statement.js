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
            ajax: '/customer/fin-statement/pagination',
            columns: [
                {  'data': 'seq' },
                {  'data': 'id' },
                {  'data': 'status' },
                {  'data': 'cust_num' },
                {  'data': 'cust_name' },
                {  'data': 'bill_type' },
                {  'data': 'bill_no' },
                {  'data': 'srcbill_no' },
                {  'data': 'project_no' },
                {  'data': 'bill_date' },
                {  'data': 'cur_amount' },
                {  'data': 'bal_amount' },
                {  'data': 'abstract' },
                {  'data': 'remarks' },
            ],
            columnDefs: [
                {
                    "targets": [0,1,2],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
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