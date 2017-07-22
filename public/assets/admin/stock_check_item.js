/**
 *
 */
define(function (require, exports, module) {

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
            searching: false,
            ajax: {
                url: '/admin/stock-check-item/month-pagination',
                data: function (data) {

                }
            },
            columns: [
                {'data': 'cust_name'},
                {'data': 'fyear'},
                {'data': 'fmonth'},
                {'data': 'fcomplete_date'},
                {'data': 'nick_name'},
                {'data': 'material_number'},
                {'data': 'material_name'},
                {'data': 'material_spec'},
                {'data': 'finv_hqty', render: function (data, type, full) {
                    var inv_box_qty = 0;
                    inv_box_qty = parseInt(data)
                    return inv_box_qty;
                }},
                {'data': 'finv_eqty', render: function (data, type, full) {
                    var inv_bottle_qty = 0;
                    inv_bottle_qty = parseInt(data) - parseInt(full.finv_hqty) * parseInt(full.material_fratio);
                    return inv_bottle_qty;
                }},
                {'data': 'box_qty'},
                {'data': 'bottle_qty'},
                {'data': 'fdiff_hqty', render: function (data, type, full) {
                    var diff_box_qty = 0;
                    diff_box_qty = parseInt(data)
                    return diff_box_qty;
                }},
                {'data': 'fdiff_eqty', render: function (data, type, full) {
                    var diff_bottle_qty = 0;
                    diff_bottle_qty = parseInt(data) - parseInt(full.fdiff_hqty) * parseInt(full.material_fratio);
                    return diff_bottle_qty;
                }},
                // {'data': 'box_qty'},
                // {'data': 'bottle_qty'},
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