/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, orderTableId,orderInfoTableId) {
        editorCN.edit.title = '确认接单';
        editorCN.edit.submit = '确认接单';
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
                {'label': '订单号', 'name': 'readonly_fbill_no', 'data': 'fbill_no', 'type': 'readonly'},
                {'label': '订单日期', 'name': 'readonly_fdate',  'data': 'fdate', 'type': 'readonly'},
                {'label': '业务员','name':'readonly_femp_id' , 'data': 'employee.fname',  'type': 'readonly'},
                {'label': '门店', 'name':'readonly_fstore_id', 'data': 'store.ffullname',  'type': 'readonly'},
                {'label': 'fsend_status', 'name': 'fsend_status', 'def': 'C', 'type':'select', 'options':[{ 'label': '已收货', value:'C' }]},
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
                {extend: "edit", text: '接单<i class="fa fa-fw fa-pencil"></i>', editor: orderEditor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: orderEditor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        editorCN.edit.title = '确认发货数量';
        editorCN.edit.submit = '确认';
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
                {'label': '商品', 'name': 'readonly_material_fname', 'data': 'material.fname',  'type': 'readonly'},
                {'label': '销售单位数量', 'name': 'readonly_fqty', 'data': 'fqty', 'type': 'readonly'},
                {'label': '销售单位', 'name': 'readonly_fsale_unit', 'data': 'fsale_unit', 'type': 'readonly'},
                {'label': '基本单位数量', 'name': 'readonly_fbase_qty',  'data': 'fbase_qty', 'type': 'readonly'},
                {'label': '基本单位', 'name': 'readonly_fbase_unit', 'data': 'fbase_unit', 'type': 'readonly'},
                {'label': '确认销售单位数量', 'name': 'fsend_qty' },
                {'label': '确认基本单位数量', 'name': 'fsend_base_qty' },
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
                        //if (full.order)
                            return full.order.fbill_no
                        //else
                        //    return "";
                    }
                },
                {
                    'data': 'fmaterial_id',
                    render: function (data, type, full) {
                        //if (full.meterial)
                            return full.material.fname;
                        //else
                        //    return "";
                    }
                },
                {'data': 'fqty'},
                {'data': 'fsale_unit'},
                {'data': 'fbase_qty'},
                {'data': 'fbase_unit'},
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
                {extend: "edit", text: '发货数量确认<i class="fa fa-fw fa-pencil"></i>', editor: infoEditor},
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