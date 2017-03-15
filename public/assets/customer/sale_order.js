/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, orderTableId,orderInfoTableId) {
        var orderEditor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/customer/sale-order',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/customer/sale-order/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/customer/sale-order/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + orderTableId,
            idSrc: 'id',
            fields: [
                {'label': 'fbill_no', 'name': 'fbill_no',},
                {'label': 'fcreate_date', 'name': 'fcreate_date',},
                {'label': 'fcreator_id', 'name': 'fcreator_id',},
                {'label': 'fcust_id', 'name': 'fcust_id',},
                {'label': 'fdate', 'name': 'fdate',},
                {'label': 'fdocument_status', 'name': 'fdocument_status',},
                {'label': 'femp_id', 'name': 'femp_id',},
                {'label': 'flog_id', 'name': 'flog_id',},
                {'label': 'fmodify_date', 'name': 'fmodify_date',},
                {'label': 'fmodify_id', 'name': 'fmodify_id',},
                {'label': 'fsend_status', 'name': 'fsend_status',},
                {'label': 'fstore_id', 'name': 'fstore_id',},
            ]
        });

        var orderTable = $("#" + orderTableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/customer/sale-order/pagination',
            columns: [
                {'data': 'id'},
                {'data': 'fbill_no'},
                {
                    'data': 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.ffullname
                        else
                            return "";
                    }
                },
                {'data': 'fdate'},
                {
                    'data': 'femp_id',
                    render: function (data, type, full) {
                        if (full.employee != null)
                            return full.employee.fname
                        else
                            return "";
                    }
                },
                {
                    'data': 'fcust_id',
                    render: function (data, type, full) {
                        if (full.customer != null)
                            return full.customer.fname
                        else
                            return "";
                    }
                },
                {
                    'data': 'fsend_status',
                    render: function (data, type, full) {
                        if(data=="A"){
                            return '未发货'
                        }else if (data=="B"){
                            return '发货中'
                        }else if (data=="C"){
                            return '已到货'
                        }else{
                            return '状态异常'
                        }
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
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: orderEditor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        var infoEditor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/customer/sale-order-item',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/customer/sale-order-item/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/customer/sale-order-item/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + orderInfoTableId,
            idSrc: 'id',
            fields: [
                {'label': 'fbase_qty', 'name': 'fbase_qty',},
                {'label': 'fbase_unit', 'name': 'fbase_unit',},
                {'label': 'fcreate_date', 'name': 'fcreate_date',},
                {'label': 'fcreator_id', 'name': 'fcreator_id',},
                {'label': 'fdocument_status', 'name': 'fdocument_status',},
                {'label': 'fmaterial_id', 'name': 'fmaterial_id',},
                {'label': 'fmodify_date', 'name': 'fmodify_date',},
                {'label': 'fmodify_id', 'name': 'fmodify_id',},
                {'label': 'fqty', 'name': 'fqty',},
                {'label': 'fsale_order_id', 'name': 'fsale_order_id',},
                {'label': 'fsale_unit', 'name': 'fsale_unit',},
                {'label': 'fsend_base_qty', 'name': 'fsend_base_qty',},
                {'label': 'fsend_qty', 'name': 'fsend_qty',},
            ]
        });

        var infoTable = $("#" + orderInfoTableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
                url : '/customer/sale-order-item/pagination',
                data : function (data) {
                    var order = orderTable.rows('.selected').data();
                    data.columns[1]['search']['value'] = order.length > 0 ? order[0].id : -1;
                }
            },
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
                    'data': 'fmaterial_id',
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
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: infoEditor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: infoEditor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: infoEditor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        orderTable.on( 'select', orderTableRowSelect).on( 'deselect', orderTableRowSelect);

        function orderTableRowSelect() {
            var row = orderTable.rows('.selected').data();
            var order_id = row.length>0?row[0].id:0;
            infoTable.columns( 1 ).search( order_id ).draw();
        }
    }

});