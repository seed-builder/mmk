/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, itemTableId) {
        var itemEditor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/stock-out-item',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/stock-out-item/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/stock-out-item/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + itemTableId,
            idSrc: 'id',
            fields: [
                { 'label': '商品', 'name': 'fmeterial_id', 'type': 'select', 'options': materials},
                {'label': '销售单位', 'name': 'fsale_unit',},
                {'label': '基本单位', 'name': 'fbase_unit',},
                {'label': '订单数量', 'name': 'fqty',},
            ]
        });

        var itemTable = $("#" + itemTableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/stock-out-item/pagination',
            columns: [
                {'data': 'id'},
                {
                    'data': 'fstock_out_id',
                    render: function (data, type, full) {
                        if (full.stockout != null)
                            return full.stockout.fbill_no
                        else
                            return "";
                    }
                },
                {
                    'data': 'fmaterial_id',
                    render: function (data, type, full) {
                        if (full.material != null)
                            return full.material.fname
                        else
                            return "";
                    }
                },
                {'data': 'fsale_unit'},
                {'data': 'fbase_unit'},
                {'data': 'fqty'},
                {'data': 'fbase_qty'},

            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: itemEditor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: itemEditor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: itemEditor},
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