/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,itemTableId) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/stock-check',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/stock-check/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/stock-check/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': '经销商','name': 'readonly_customer_name', 'data': 'customer.fname', 'type':"readonly"},
                {'label': '年份','name':'readonly_fyear', 'data': 'fyear', 'type':"readonly"},
                {'label': '月份', 'name':'readonly_fmonth','data': 'fmonth', 'type':"readonly"},
                {'label': '完成日期','name':'readonly_fcomplete_date', 'data': 'fcomplete_date', 'type':"readonly"},
                {'label': '盘点状态', 'name': 'fcheck_status', 'type': 'select', 'options':[
                    {"label": "盘点中", 'value': 0},
                    {"label": "盘点完成", 'value': 1},
                    {"label": "取消盘点", 'value': 2},
                    ]
                },
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
            ajax: {
                url : '/admin/stock-check/pagination'
            },
            columns: [
                {'data': 'id'},
                {
                    'data': 'fcust_id',
                    render: function (data, type, full) {
                        return full.customer.fname;
                    }
                },

                {'data': 'fyear'},
                {'data': 'fmonth'},
                {'data': 'fcomplete_date'},
                {
                    'data': 'fcheck_status',
                    render: function (data, type, full) {
                        if (data==0)
                            return '盘点中';
                        if (data==1)
                            return '盘点完成'
                        if (data==2)
                            return '取消盘点'
                    }
                },
                {
                    'data': 'fchecker_id',
                    render: function (data, type, full) {
                        if (full.user!=null)
                            return full.user.nick_name;
                        else
                            return ''
                    }
                },
                {
                    'data': 'id',
                    render: function (data, type, full) {
                        return '<a href="/admin/stock-check/show/'+data+'" title="查看盘点照片" data-target="#show" data-toggle="modal"><i class="fa fa-fw fa-search"></i></a>';
                    }
                },
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
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                // {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        var itemTableCn = $.extend(zhCN, {
            'sZeroRecords': '暂无盘点明细！'
        });
        var itemTable = $("#" + itemTableId).DataTable({
            dom: "lBfrtip",
            language: itemTableCn,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            searching: false,
            ajax: {
                url : '/admin/stock-check-item/pagination',
                data : function (data) {
                    var stock_check = table.rows('.selected').data();
                    data.columns[1]['search']['value'] = stock_check.length > 0 ? stock_check[0].id : -1;
                }
            },
            columns: [
                {'data': 'id'},
                {'data': 'fstock_check_id'},
                {
                    'data': 'fmaterial_id',
                    render: function (data, type, full) {
                        return full.material ? full.material.fname : '';
                    }
                },
                {'data': 'finv_hqty', render: function (data, type, full) {
                    return full.inv_box_qty;
                }},
                {'data': 'finv_eqty', render: function (data, type, full) {
                    return full.inv_bottle_qty;
                }},
                {'data': 'box_qty'},
                {'data': 'bottle_qty'},
                {'data': 'fdiff_hqty', render: function (data, type, full) {
                    return full.diff_box_qty;
                }},
                {'data': 'fdiff_eqty', render: function (data, type, full) {
                    return full.diff_bottle_qty;
                }},
                // {'data': 'box_qty'},
                // {'data': 'bottle_qty'},
            ],
            columnDefs: [
                {
                    "targets": [0,1],
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

        table.on( 'select', rowSelect).on( 'deselect', rowSelect);

        function rowSelect() {
            var row = table.rows('.selected').data();
            var data = row.length > 0 ? row[0] : null;
            if (data){
                itemTable.columns( 1 ).search( data.id ).draw();
            }

        }

    }

});