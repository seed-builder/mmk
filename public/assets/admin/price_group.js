/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId, detailTableId, materials) {

        var tableEditCn = $.extend(editorCN, {
            create:{
                title: '新增价格组',
                button: "新建",
                submit: "提交"
            },
            edit: {
                title: '价格组编辑',
                button: "保存",
                submit: "提交"
            },
        });

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/price-group',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/price-group/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/price-group/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: tableEditCn,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                { 'label':  '编号', 'name': 'fnumber', },
                { 'label':  '名称', 'name': 'fname', },
                { 'label':  '等级', 'name': 'flevel', type:  "select",
                    options: [
                        { label: "一级",value: "1" },
                        { label: "二级",value: "2" },
                        { label: "三级",value: "3" },
                        { label: "四级",value: "4" },
                        { label: "五级",value: "5" },
                        { label: "六级",value: "6" },
                        { label: "七级",value: "7" },
                        { label: "八级",value: "8" },
                        { label: "九级",value: "9" },
                    ]
                },
                { 'label':  '有效期开始', 'name': 'fbegin',  type:  'datetime', def:   function () { return new Date(); } },
                { 'label':  '有效期截止', 'name': 'fend', type:  'datetime', def:   function () { return new Date(); } },
                { 'label':  '适用范围', 'name': 'fsuit_object', type:  "select",
                    options: [
                        { label: "全部",value: "all" },
                        { label: "门店",value: "store" },
                        { label: "经销商",value: "customer" },
                    ]},
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
            ajax: '/admin/price-group/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'fnumber' },
                {  'data': 'fname' },
                {  'data': 'flevel' },
                {  'data': 'fsuit_object' , render: function (data, type, full) {
                    var txt = '';
                    switch (data){
                        case 'all':
                            txt = '全部';
                            break;
                        case 'store':
                            txt = '门店';
                            break;
                        case 'customer':
                            txt = '经销商';
                            break;
                    }
                    return txt;
                }},
                {  'data': 'fbegin' },
                {  'data': 'fend' },
                {  'data': 'fdocument_status', render: function (data, type, full) {
                    return document_status(data);
                } },
                {  'data': 'fcreate_date' },
                {  'data': 'fmodify_date' },
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

        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

        var detailEditor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/price',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/price/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/price/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + detailTableId,
            idSrc: 'id',
            fields: [
                { 'label':  'fgroup_id', 'name': 'fgroup_id', type: 'hidden', def: function () {
                    return table.rows( { selected: true } ).data()[0].id;
                }},
                { 'label':  '价格组', 'name': 'readonly_group_name', type: 'readonly', def: function () {
                    return table.rows( { selected: true } ).data()[0].fname;
                }},
                { 'label':  '商品', 'name': 'fmaterial_id', type: 'select', options: materials},
                { 'label':  '数量起', 'name': 'fmin_qty', def: 0 },
                { 'label':  '数量止', 'name': 'fmax_qty', def: 10000 },
                { 'label':  '价格', 'name': 'fprice', },
            ]
        });

        var detailTable = $("#" + detailTableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/price/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'fmaterial_id', render: function (data, type, full) {
                    return full.material.fname;
                } },
                {  'data': 'fmaterial_id', render: function (data, type, full) {
                    return full.material.fspecification;
                } },
                {  'data': 'fmaterial_id', render: function (data, type, full) {
                    return full.material.fsale_unit;
                } },
                {  'data': 'fprice' },
                {  'data': 'fmin_qty' },
                {  'data': 'fmax_qty' },
                {  'data': 'fdocument_status', render: function (data, type, full) {
                    return document_status(data);
                } },
                {  'data': 'fcreate_date' },
                {  'data': 'fmodify_date' },
                {  'data': 'fgroup_id' },
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: detailEditor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: detailEditor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: detailEditor},
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