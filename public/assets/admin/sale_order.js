/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, orderTableId, orderInfoTableId,  stores, employees) {

        var orderEditor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/sale-order',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/sale-order/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/sale-order/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            // i18n: orderEditCn,
            table: "#" + orderTableId,
            idSrc: 'id',
            fields: [
                {'label': '订单号', 'name': 'readonly_fbill_no', 'data': 'fbill_no', 'type': 'readonly'},
                {
                    'label': '订单日期', 'name': 'fdate', 'data': 'fdate', type: 'datetime',
                    def: function () {
                        return new Date();
                    }
                },
                {'label': '业务员', 'name': 'femp_id', 'data': 'employee.fname', 'type': 'select', 'options': employees},
                {'label': '门店', 'name': 'fstore_id', 'data': 'store.ffullname', 'type': 'select', 'options': stores},
                {'label': 'source', 'name': 'source', 'data': 'source', 'def': 'admin', 'type': 'hidden'}
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
            ajax: {
                url: '/admin/sale-order/pagination',
            },
            columns: [
                {'data': 'id'},
                {'data': 'fbill_no'},
                {'data': 'store_name',},
                {'data': 'fdate'},
                {'data': 'fcreate_date'},
                {'data': 'employee_name'},
                {'data': 'customer_name'},
                {'data': 'ftotal_amount'},
                {
                    'data': 'fsend_status',
                    render: function (data, type, full) {
                        return send_status(data);
                    }
                },
                {'data': 'fsend_date'},
                {'data': 'source'},
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
                // {
                //     text: '接单<i class="fa fa-fw fa-arrow-circle-right"></i>',
                //     className: 'accept',
                //     enabled: false,
                //     action: function (e, dt, node, config) {
                //         //dt.ajax.reload();
                //         layer.confirm('确认接单?', {btn: ['确定', '取消']}, function () {
                //             var row = dt.rows('.selected').data();
                //             var order = row.length > 0 ? row[0] : null;
                //             if(order){
                //                 $.post('/admin/sale-order/accept/'+ order.id,
                //                     {_token: $('meta[name="_token"]').attr('content')},
                //                     function (result) {
                //                         if(result.data){
                //                             layer.msg('接单成功!');
                //                             infoTable.ajax.reload();
                //                             dt.ajax.reload();
                //                         }else{
                //                             layer.msg('接单失败, 错误：' + result.error);
                //                         }
                //                     }
                //                 )
                //             }
                //         }, function () {
                //             layer.close();
                //         })
                //     }
                // },
                {
                    text: '确认配送<i class="fa fa-fw fa-send"></i>',
                    className: 'send',
                    enabled: false,
                    action: function (e, dt, node, config) {
                        layer.confirm('确认配送?', {btn: ['确定', '取消']}, function () {
                            var orders = dt.rows('.selected').data();
                            if(orders.length > 0){
                                var ids = [] ;
                                for(var i = 0; i < orders.length; i++){
                                    ids[ids.length] = orders[i].id;
                                }
                                $.post('/admin/sale-order/send',
                                    {_token: $('meta[name="_token"]').attr('content'), ids: ids},
                                    function (result) {
                                        if(result.cancelled == 0){
                                            layer.msg('确认配送成功!');
                                            dt.ajax.reload();
                                            infoTable.ajax.reload();
                                        }else{
                                            layer.msg('确认配送失败, 错误：' + result.error);
                                        }
                                    }
                                )
                            }
                        }, function () {
                            layer.close();
                        })
                    }
                },
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: orderEditor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                {extend: 'colvis', text: '列显示'}
            ],
            order: [[3, 'desc']]
        });

        var infoEditor = new $.fn.dataTable.Editor({
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
                    success: function () {
                        orderTable.ajax.reload();
                        infoTable.ajax.reload();
                        $(".modal").modal('hide')
                    }
                }
            },
            i18n: editorCN,
            table: "#" + orderInfoTableId,
            idSrc: 'id',
            fields: [
                {'label': '商品', 'name': 'readonly_material_fname', 'data': 'material.fname', 'type': 'readonly'},
                {'label': '销售单位数量', 'name': 'readonly_fqty', 'data': 'fqty', 'type': 'readonly'},
                {'label': '销售单位', 'name': 'readonly_fsale_unit', 'data': 'fsale_unit', 'type': 'readonly'},
                {'label': '基本单位数量', 'name': 'readonly_fbase_qty', 'data': 'fbase_qty', 'type': 'readonly'},
                {'label': '基本单位', 'name': 'readonly_fbase_unit', 'data': 'fbase_unit', 'type': 'readonly'},
            ]
        });

        var infoTable = $("#" + orderInfoTableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            paging: true,
            rowId: "id",
            ajax: {
                url : '/admin/sale-order-item/pagination',
                data : function (data) {
                    var order = orderTable.rows('.selected').data();
                    data.columns[1]['search']['value'] = order.length > 0 ? order[0].id : -1;
                }
            },
            columns: [
                {
                    'data': 'id',
                    render: function (data, type, full) {
                        return '<input type="checkbox" class="editor-active" value="'+data+'">';
                    },
                    className: "dt-body-center"
                },
                {
                    'data': 'fsale_order_id',
                    render: function (data, type, full) {
                            return full.order.fbill_no
                    }
                },
                {
                    'data': 'fmaterial_id',
                    render: function (data, type, full) {
                            return full.material.fname;
                    }
                },
                {'data': 'box_qty'},
                {'data': 'bottle_qty'},
                {'data': 'present_box_qty'},
                {'data': 'present_bottle_qty'},
                {'data': 'fsend_qty', render: function (data, type, full) {
                    return full.box_qty + full.present_box_qty;
                }},
                {'data': 'fsend_base_qty', render: function (data, type, full) {
                    return full.bottle_qty + full.present_bottle_qty;
                }},
                {
                    'data': 'fsend_status',
                    render: function (data, type, full) {
                        return send_status(data);
                    }
                },
                {'data': 'fprice_box'},
                {'data': 'fprice_bottle'},
                {'data': 'famount'},
            ],
            buttons: [
                // {
                //     text: '发货数量确认<i class="fa fa-fw fa-info"></i>',
                //     className: 'sure',
                //     enabled: false,
                //     action: function (e, dt, node, config) {
                //         $('#sureForm').get(0).reset();
                //         $('#sureForm').bootstrapValidator('resetForm');
                //         var detailrows = infoTable.rows('.selected').data();
                //         var detail = detailrows.length > 0 ? detailrows[0] : null;
                //         if(detail){
                //             $('#id', '#sureForm').val(detail.id);
                //             $('#material', '#sureForm').val(detail.material.fname);
                //             $('#order_no', '#sureForm').val(detail.order.fbill_no);
                //             //$('#unit', '#sureForm').val(detail.id);
                //             addOptions(document.getElementById('unit'),
                //                 [
                //                     { text: detail.material.fsale_unit, value:  'sale_unit' },
                //                     { text: detail.material.fbase_unit, value:  'base_unit' }
                //                 ]
                //             );
                //             $('#sureForm').attr('')
                //             $('#sureFormDialog').modal('show');
                //         }
                //     }
                // },
                // {
                //     text: '确认配送<i class="fa fa-fw fa-send"></i>',
                //     className: 'send',
                //     enabled: false,
                //     action: function (e, dt, node, config) {
                //         layer.confirm('确认配送?', {btn: ['确定', '取消']}, function () {
                //             var orders = dt.rows('.selected').data();
                //             if(orders.length > 0){
                //                 var ids = [] ;
                //                 var orderId = 0
                //                 for(var i = 0; i < orders.length; i++){
                //                     ids[ids.length] = orders[i].id;
                //                 }
                //                 orderId = orders[0].fsale_order_id;
                //                 $.post('/admin/sale-order-item/send',
                //                     {_token: $('meta[name="_token"]').attr('content'), ids: ids, order_id: orderId},
                //                     function (result) {
                //                         if(result.data){
                //                             layer.msg('确认配送成功!');
                //                             dt.ajax.reload();
                //                             orderTable.ajax.reload();
                //                         }else{
                //                             layer.msg('确认配送失败, 错误：' + result.error);
                //                         }
                //                     }
                //                 )
                //             }
                //         }, function () {
                //             layer.close();
                //         })
                //     }},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: infoEditor, enabled: false},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                {extend: 'colvis', text: '列显示'}
            ],
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                },
                {
                    'targets': [1],
                    "visible": false
                }
            ],
            select: {
                'style': 'multi'
            },
            //order: [[ 1, 'asc' ]]
        });

        orderTable.on( 'select', orderTableRowSelect).on( 'deselect', orderTableRowSelect);

        function orderTableRowSelect() {
            var row = orderTable.rows('.selected').data();
            var order = row.length > 0 ? row[0] : null;
            //console.log(order);
            if(order){
                infoTable.columns( 1 ).search( order.id ).draw();
                orderTable.buttons( ['.accept','.send'] ).enable(order.fsend_status == 'A');
                orderTable.buttons( ['.buttons-edit'] ).enable(order.source != 'phone' && order.fsend_status == 'A');
                orderTable.buttons( ['.buttons-remove'] ).enable(order.fsend_status == 'A');
                infoTable.buttons( ['.buttons-create']).enable(order.source != 'phone');

            }
        }

        infoTable.on( 'select', infoTableRowSelect).on( 'deselect', infoTableRowSelect);

        function infoTableRowSelect() {
            var row = orderTable.rows('.selected').data();
            var order = row.length > 0 ? row[0] : null;

            var detailrows = infoTable.rows('.selected').data();
            var detail = detailrows.length > 0 ? detailrows[0] : null;
            //console.log(order);
            if(order && detail){
                infoTable.buttons( ['.buttons-edit','.buttons-remove']).enable(detail.fsend_status == 'A');
                infoTable.buttons( ['.sure', '.send']).enable(detail.fsend_status == 'B');
            }
        }

        //
        $('#sureForm').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                qty: {
                    validators: {
                        notEmpty: {},
                        numeric: {}
                    }
                },
            }
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();
            // Get the form instance
            var $form = $(e.target);
            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
            // Use Ajax to submit form data
            //var data = $form.serialize();
            //console.log(data);
            $.post($form.attr('action') + '/' + $('#id', '#sureForm').val(), $form.serialize(), function (result) {
                if(result.data)
                {
                    layer.msg('保存成功!');
                    infoTable.ajax.reload();
                    $('#sureFormDialog').modal('hide');
                }
            }, 'json');
        });
    }

});