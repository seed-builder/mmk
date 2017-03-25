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
                    url: '/admin/stock',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/stock/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/stock/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': 'fbase_eqty', 'name': 'fbase_eqty',},
                {'label': 'fcreate_date', 'name': 'fcreate_date',},
                {'label': 'fcreator_id', 'name': 'fcreator_id',},
                {'label': 'fdocument_status', 'name': 'fdocument_status',},
                {'label': 'feqty', 'name': 'feqty',},
                {'label': 'fhqty', 'name': 'fhqty',},
                {'label': 'flog_id', 'name': 'flog_id',},
                {'label': 'fmaterial_id', 'name': 'fmaterial_id',},
                {'label': 'fmodify_date', 'name': 'fmodify_date',},
                {'label': 'fmodify_id', 'name': 'fmodify_id',},
                {'label': 'fold_eqty', 'name': 'fold_eqty',},
                {'label': 'fsale_hqty', 'name': 'fsale_hqty',},
                {'label': 'fstore_id', 'name': 'fstore_id',},
                {'label': 'ftime', 'name': 'ftime',},
            ]
        });

        var table = $("#" + tableId).DataTable({
            dom: "lBrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/stock/pagination',
            columns: [
                {'data': 'id'},
                {'data': 'store_number'},
                {'data': 'store_name'},
                {'data': 'ftime'},
                {'data': 'employee_number'},
                { 'data': 'employee_name'},
                {'data': 'material_number'},
                {'data': 'material_name'},
                {'data': 'material_specification',},
                {'data': 'fhqty'},
                {'data': 'feqty'},
                {'data': 'fsale_hqty'},
                {
                    "data": "fdocument_status",
                    render: function ( data, type, full ) {
                        return document_status(data);
                    }
                },
                {
                    "data": "fcheck_type",
                    render: function ( data, type, full ) {
                        var txt = '';
                        switch (data){
                            case 'A':
                                txt = '自动审核';
                                break;
                            case 'B':
                                txt = '手工审核';
                                break;
                            default:
                                break;
                        }
                        return txt;
                    }
                },
                {'data': 'fcheck_date'},
                {'data': 'fchecker'},
            ],
            columnDefs: [
                {
                    "targets": [0,1,4,6],
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
                {extend: 'colvis', text: '列显示'},
                { text: '审核<i class="fa fa-fw fa-paperclip"></i>',className: 'check', enabled: false },
                { text: '反审核<i class="fa fa-fw fa-unlink"></i>',className: 'uncheck', enabled: false },
            ],
            order: [[ 3, 'desc' ]]
        });

        table.on( 'select', rowSelect).on( 'deselect', rowSelect);

        function rowSelect() {
            checkEditEnabble(table,['.edit','.check','.buttons-remove'],['.uncheck']);
        }

        //审核
        $(".check").on('click',function () {
            dataCheck(table,'/admin/stock/check');
        })

        $(".uncheck").on('click',function () {
            dataCheck(table,'/admin/stock/uncheck');
        })

    }

});