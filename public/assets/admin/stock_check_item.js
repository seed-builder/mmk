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
                    url: '/admin/stock-check-item',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/stock-check-item/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/stock-check-item/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': 'fcheck_eqty', 'name': 'fcheck_eqty',},
                {'label': 'fcheck_hqty', 'name': 'fcheck_hqty',},
                {'label': 'fcreate_date', 'name': 'fcreate_date',},
                {'label': 'fdiff_eqty', 'name': 'fdiff_eqty',},
                {'label': 'fdiff_hqty', 'name': 'fdiff_hqty',},
                {'label': 'finv_eqty', 'name': 'finv_eqty',},
                {'label': 'finv_hqty', 'name': 'finv_hqty',},
                {'label': 'fmaterial_id', 'name': 'fmaterial_id',},
                {'label': 'fmodify_date', 'name': 'fmodify_date',},
                {'label': 'fstock_check_id', 'name': 'fstock_check_id',},
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
            searching: false,
            ajax: '/admin/stock-check-item/pagination',
            columns: [
                {'data': 'id'},
                {'data': 'fstock_check_id'},
                {
                    'data': 'fmaterial_id',
                    render: function (data, type, full) {
                        return full.material.fname;
                    }
                },
                {'data': 'finv_hqty'},
                {'data': 'finv_eqty'},
                {'data': 'fcheck_hqty'},
                {'data': 'fcheck_eqty'},
                {'data': 'fdiff_hqty'},
                {'data': 'fdiff_eqty'},
                // {'data': 'box_qty'},
                // {'data': 'bottle_qty'},
            ],
            columnDefs: [
                {
                    "targets": [0, 1],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                // {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                // {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                // {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
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