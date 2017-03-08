/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,itemTableId,customers,stores,materials) {
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
            i18n: editorCN,
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
                {
                    label: '到货确认日期:',
                    name:  'frec_date',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },
                {
                    label: '预计到货日期:',
                    name:  'fneed_rec_date',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },
                {'label': '来源单号', 'name': 'fsbill_no',},
                // { 'label': '到货确认人', 'name': 'fuser_id', 'type': 'select', 'options': customers},
                { 'label': '经销商', 'name': 'fcust_id', 'type': 'select', 'options': customers},
                {
                    label: "到货状态:",
                    name:  "frec_status",
                    type:  "select",
                    options: [
                        { label: "未到货",value: "0" },
                        { label: "已到货",value: "1" },
                    ]
                },


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
            ajax: '/admin/stock-out/pagination',
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
                {'data': 'frec_date'},
                {'data': 'fneed_rec_date'},
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
                        if (full.customer != null)
                            return full.customer.fname
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
                    'data': 'id',
                    render: function (data, type, full) {
                        return '<a style="cursor: pointer" data-target="#itemModal" data-toggle="modal"><i class="fa fa-fw fa-list"></i></a>'
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
                //{extend: 'colvis', text: '列显示'}
            ]
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
            i18n: editorCN,
            table: "#" + itemTableId,
            idSrc: 'id',
            fields: [
                { 'label': '商品', 'name': 'fmeterial_id', 'type': 'select', 'options': materials},
                {'label': '销售单位', 'name': 'fsale_unit',},
                {'label': '基本单位', 'name': 'fbase_unit',},
                {'label': '订单数量', 'name': 'fqty',},
                {
                    'name': "fstock_out_id",
                    'def': function () {
                        return table.rows('.selected').data()[0].id;
                    },
                    'type': "hidden"
                }
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
            ajax: {
                url : '/admin/stock-out-item/pagination',
                data : function (data) {
                    data.columns[1]['search']['value'] = table.rows('.selected').data().length>0?table.rows('.selected').data()[0].id:null;
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
                    'data': 'fmeterial_id',
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
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: itemEditor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: itemEditor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: itemEditor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        $('#itemModal').on('show.bs.modal', function () {
            itemTable.ajax.reload();
        })

    }

});