/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    editorCN.edit.title = "入库情况确认";
    exports.index = function ($, tableId,itemTableId,customers,materials) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/stock-in',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/stock-in/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/stock-in/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {
                    label: '发货日期:',
                    name:  'fsend_date',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },
                {
                    label: '到货日期:',
                    name:  'fin_date',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },
                { 'label': '经销商', 'name': 'fcust_id', 'type': 'select', 'options': customers},
                {
                    label: "发货状态:",
                    name:  "fsend_status",
                    type:  "select",
                    options: [
                        { label: "未发货",value: "A" },
                        { label: "发货中",value: "B" },
                        { label: "已到货",value: "C" },
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
            ajax: '/admin/stock-in/pagination',
            columns: [
                {'data': 'id'},
                {'data': 'fbill_no'},
                {'data': 'fsend_date'},
                {'data': 'fin_date'},
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
                        if (data=="A")
                            return '未到货'
                        else if(data=="B"){
                            return '未到货'
                        }else if(data=="C"){
                            return '已到货'
                        }else {
                            return "";
                        }
                    }
                },
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
                {extend: "edit",className: 'edit', text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                { text: '到货确认<i class="fa fa-fw fa-paperclip"></i>',className: 'check', enabled: false },
                { text: '到货修改<i class="fa fa-fw fa-unlink"></i>',className: 'uncheck', enabled: false },
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        var itemEditor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/stock-in-item',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/stock-in-item/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/stock-in-item/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + itemTableId,
            idSrc: 'id',
            fields: [
                { 'label': '商品', 'name': 'fmaterial_id', 'type': 'select', 'options': materials},
                {'label': '销售单位','type':"readonly", 'name': 'fsale_unit',},
                {'label': '基本单位','type':"readonly",  'name': 'fbase_unit',},
                {'label': '到货 数量（箱）', 'name': 'fqty',},
                {
                    'name': "fstock_in_id",
                    'def': function () {
                        return table.rows('.selected').data()[0].id;
                    },
                    'type': "hidden"
                }
            ]
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
                url : '/admin/stock-in-item/pagination',
                data : function (data) {
                    data.columns[1]['search']['value'] = table.rows('.selected').data().length>0?table.rows('.selected').data()[0].id:null;
                }
            },
            columns: [
                {'data': 'id'},
                {
                    'data': 'fstock_in_id',
                    render: function (data, type, full) {
                        if (full.stockin != null)
                            return full.stockin.fbill_no
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
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: itemEditor},
                {extend: "edit",className: 'edit', text: '入库情况确认<i class="fa fa-fw fa-pencil"></i>', editor: itemEditor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: itemEditor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                {extend: 'colvis', text: '列显示'},

            ]
        });

        table.on( 'select', rowSelect).on( 'deselect', rowSelect);
        function rowSelect() {
            checkEditEnabble(table,['.edit','.check'],['.uncheck']);
            itemTable.ajax.reload();
        }
        itemTable.on( 'select', itemRowSelect).on( 'deselect', itemRowSelect);

        function itemRowSelect() {
            checkEditEnabble(itemTable,['.edit','.check'],['.uncheck']);
        }


        //审核
        $(".check").on('click',function () {
            dataCheck(table,'/admin/stock-in/check');
        })

        $(".uncheck").on('click',function () {
            dataCheck(table,'/admin/stock-in/uncheck');
        })
        table.on( 'select', rowSelect).on( 'deselect', rowSelect);

    }

});