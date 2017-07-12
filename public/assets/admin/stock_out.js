/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,itemTableId,admins,stores,materials) {

        var tableEditCn = $.extend(editorCN, {
            create:{
                title: '新增出库',
                button: "新建",
                submit: "提交"
            },
            edit: {
                title: '出库编辑',
                button: "保存",
                submit: "提交"
            },
        });
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/stock-out',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/stock-out/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/stock-out/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: tableEditCn,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                { 'label': '门店', 'name': 'fstore_id', 'type': 'select', 'options': stores},
                {
                    label: '出库日期:',
                    name:  'fdate',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },
                { 'label': '出库类型', 'name': 'ftype', 'type': 'select', 'options': [
                    // {label: '自动出库', value: 'A'},
                    {label: '经销出库', value: 'B'},
                    {label: '库存调整', value: 'C'}
                    ] ,
                    def: 'B'
                },
                { 'label': '经销商', 'name': 'fcust_id', 'type': 'select', 'options': admins },
                {'label': '来源单号', 'name': 'fsbill_no', 'type':'readonly'},
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
            ajax: {
                url : '/admin/stock-out/pagination'
            },
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
                {'data': 'ftype', render: function (data, type, full) {
                    switch (data){
                        case "A": return '自动出库';
                        case "B": return '经销出库';
                        case "C": return '库存调整';
                        default: return '未知';
                    }
                }},
                // {'data': 'frec_date'},
                // {'data': 'fneed_rec_date'},
                {'data': 'fsbill_no'},
                {
                    'data': 'fuser_id',
                    render: function (data, type, full) {
                        if (full.user != null)
                            return full.user.name
                        else
                            return "";
                    }
                },
                {
                    'data': 'fcust_id',
                    render: function (data, type, full) {
                        if (full.admin != null)
                            return full.admin.fname
                        else
                            return "";
                    }
                },
                {
                    'data': 'frec_status',
                    render: function (data, type, full) {
                        if (data==0)
                            return '未到货'
                        else if(data==1){
                            return '未到货'
                        }else {
                            return "";
                        }
                    }
                },
                {
                    "data": "fdocument_status",
                    render: function ( data, type, full ) {
                        return document_status(data);
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
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                { text: '出库单打印<i class="fa fa-fw fa-print"></i>',action: function () {
                    var row = table.rows('.selected').data();
                    if (row.length==0){
                        layer.alert('请选择一个出库单')
                        return ;
                    }
                    window.location.href= "/admin/stock-out/print-out-order/"+row[0].id
                } },
                {extend: 'colvis', text: '列显示'},
                { text: '审核<i class="fa fa-fw fa-paperclip"></i>',className: 'check', enabled: false },
                { text: '反审核<i class="fa fa-fw fa-unlink"></i>',className: 'uncheck', enabled: false },
            ],
            order: [[3,'desc']]
        });

        table.on( 'select', rowSelect).on( 'deselect', rowSelect);
        function rowSelect() {
            checkEditEnabble(table,['.buttons-edit','.check','.buttons-remove'],['.uncheck']);
            //自动出库的控制
            var data = table.rows({selected: true}).data()[0];
            if(data){
                table.buttons(['.buttons-edit']).enable(data.ftype != 'A' && data.fdocument_status == 'A');
            }
            var count = table.rows({selected: true}).count();
            itemTable.buttons(['.item-add']).enable(count>0);
            itemTable.ajax.reload();
        }

        //审核
        $(".check").on('click',function () {
            setTimeout(function () {
                var rows = itemTable.rows()[0];
                console.log(rows);
                if(rows.length > 0)
                {
                    dataCheck(table,'/admin/stock-out/check');
                }else{
                    layer.msg('您未添加任何出库明细!');
                }
            }, 1000);
        })

        $(".uncheck").on('click',function () {
            //dataCheck(table,'/admin/stock-out/uncheck');
            setTimeout(function () {
                var rows = itemTable.rows()[0];
                console.log(rows);
                if(rows.length > 0)
                {
                    dataCheck(table,'/admin/stock-out/uncheck');
                }else{
                    layer.msg('您未添加任何出库明细!');
                }
            }, 1000);
        })


        var itemEditCn = $.extend(editorCN, {
            create:{
                title: '新增出库明细',
                button: "保存",
                submit: "提交"
            },
            edit: {
                title: '出库明细编辑',
                button: "保存",
                submit: "提交"
            },
        });
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
            i18n: itemEditCn,
            table: "#" + itemTableId,
            idSrc: 'id',
            fields: [
                { 'label': '商品', 'name': 'fmaterial_id', 'type': 'select', 'options': materials},
                {'label': '单价(箱)', 'name': 'fprice_box',},
                {'label': '单价(瓶)', 'name': 'fprice_bottle',},
                {'label': '数量(箱)', 'name': 'box_qty',},
                {'label': '数量(瓶)', 'name': 'bottle_qty',},
                {'label': '赠送数量(箱)', 'name': 'present_box_qty',},
                {'label': '赠送数量(瓶)', 'name': 'present_bottle_qty',},
                {
                    'name': "fstock_out_id",
                    'def': function () {
                        return table.rows('.selected').data()[0].id;
                    },
                    'type': "hidden"
                }
            ]
        });

        var itemTableCn = $.extend(zhCN, {
            'sZeroRecords': '您未添加任何出库明细！'
        });
        var itemTable = $("#" + itemTableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
                url : '/admin/stock-out-item/pagination',
                data : function (data) {
                    data.columns[1]['search']['value'] = table.rows('.selected').data().length>0?table.rows('.selected').data()[0].id:-1;
                }
            },
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
                {'data': 'box_qty'},
                {'data': 'bottle_qty'},
                {'data': 'present_box_qty'},
                {'data': 'present_bottle_qty'},
                {'data': 'fprice_box'},
                {'data': 'fprice_bottle'},
                {'data': 'famount'},
            ],
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
            ],
            buttons: [
                // {
                //     text: '新增',
                //     className: 'item-add',
                //     enabled: false,
                //     action: function () {
                //         $('#stockItemFormDialogTitle').text('新增出库明细');
                //         $('#stockItemForm').get(0).reset();
                //         $('#stockItemForm').bootstrapValidator('resetForm');
                //         var rows = table.rows('.selected').data();
                //         var stock = rows.length > 0 ? rows[0] : null;
                //         if (stock) {
                //             $('#fstock_out_id', '#stockItemForm').val(stock.id);
                //             $('#stockItemFormDialog').modal('show');
                //         }
                //     }
                // },
                // { text: '编辑', className: 'item-edit', enabled: false,  action: function () {
                //         $('#stockItemFormDialogTitle').text('编辑出库明细');
                //         $('#stockItemForm').get(0).reset();
                //         $('#stockItemForm').bootstrapValidator('resetForm');
                //         var rows = itemTable.rows('.selected').data();
                //         var stockItem = rows.length > 0 ? rows[0] : null;
                //         if (stockItem) {
                //             $('#id', '#stockItemForm').val(stockItem.id);
                //             $('#fstock_out_id', '#stockItemForm').val(stockItem.fstock_out_id);
                //             $('#fmaterial_id', '#stockItemForm').val(stockItem.fmaterial_id);
                //             $('#fmaterial_id', '#stockItemForm').trigger('change');
                //             var unit = $("#unit", '#stockItemForm').val();
                //             if(unit == 'sale_unit'){
                //                 $('#qty', '#stockItemForm').val(stockItem.fqty);
                //             }else{
                //                 $('#qty', '#stockItemForm').val(stockItem.fbase_qty);
                //             }
                //             $('#stockItemFormDialog').modal('show');
                //         }
                //     }
                // },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: itemEditor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: itemEditor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: itemEditor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                {extend: 'colvis', text: '列显示'},

            ]
        });

        itemTable.on( 'select', checkBtn).on( 'deselect', checkBtn);

        function checkBtn(e, dt, type, indexes) {
            var count = dt.rows( { selected: true } ).count();
            dt.buttons( ['.item-edit'] ).enable(count > 0);
            var stock = table.rows({selected: true}).data()[0];
            dt.buttons( ['.buttons-remove'] ).enable(stock.fdocument_status == 'A' && stock.ftype != 'A');
        }

        $('#fmaterial_id', '#stockItemForm').on('change', function () {
            var material = $("#fmaterial_id", '#stockItemForm').find("option:selected");
            var sale_unit = material.attr('data-sale-unit');
            var base_unit = material.attr('data-base-unit');
            addOptions(document.getElementById('unit'),
                [
                    {text: sale_unit, value: 'sale_unit'},
                    {text: base_unit, value: 'base_unit'}
                ]
            );
        })

        $('#stockItemForm').bootstrapValidator({
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
            $.post($form.attr('action'), $form.serialize(), function (result) {
                if(result.data)
                {
                    layer.msg('保存成功!');
                    itemTable.ajax.reload();
                    $('#stockItemFormDialog').modal('hide');
                }
            }, 'json');
        });
        
    }

});