/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/sale-order-item',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/sale-order-item/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/sale-order-item/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': 'fbase_qty', 'name': 'fbase_qty',},
                {'label': 'fbase_unit', 'name': 'fbase_unit',},
                {'label': 'fcreate_date', 'name': 'fcreate_date',},
                {'label': 'fcreator_id', 'name': 'fcreator_id',},
                {'label': 'fdocument_status', 'name': 'fdocument_status',},
                {'label': 'fmeterial_id', 'name': 'fmeterial_id',},
                {'label': 'fmodify_date', 'name': 'fmodify_date',},
                {'label': 'fmodify_id', 'name': 'fmodify_id',},
                {'label': 'fqty', 'name': 'fqty',},
                {'label': 'fsale_order_id', 'name': 'fsale_order_id',},
                {'label': 'fsale_unit', 'name': 'fsale_unit',},
                {'label': 'fsend_base_qty', 'name': 'fsend_base_qty',},
                {'label': 'fsend_qty', 'name': 'fsend_qty',},
            ]
        });

        var table = $("#" + tableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/sale-order-item/pagination',
            columns: [
                {'data': 'id'},
                {
                    'data': 'fsale_order_id',
                    render: function (data, type, full) {
                        if (full.order != null)
                            return full.order.fbill_no
                        else
                            return "";
                    }
                },
                {
                    'data': 'fmeterial_id',
                    render: function (data, type, full) {
                        if (full.meterial != null)
                            return full.meterial.fname
                        else
                            return "";
                    }
                },
                {'data': 'fsale_unit'},
                {'data': 'fbase_unit'},
                {'data': 'fqty'},
                {'data': 'fbase_qty'},
                {'data': 'fsend_qty'},
                {'data': 'fsend_base_qty'},

            ],
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
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