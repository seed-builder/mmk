/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,depts) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/display-policy',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/display-policy/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/display-policy/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': '费用类型', 'name': 'fexp_type',},
                {
                    label: '执行开始日期',
                    name:  'fstart_date',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },
                {
                    label: '执行结束日期',
                    name:  'fend_date',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },
                {
                    'label': '应用区域',
                    'name': 'fcost_dept_id',
                    'type': 'select',
                    'options': depts
                },
                {'label': '总金额', 'name': 'famount',},
                {'label': '项目简述', 'name': 'fsketch',},
                {'label': '执行门店总数', 'name': 'fact_store_num',},
                {'label': '单个门店费用上限', 'name': 'fstore_cost_limit',},
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
            ajax: '/admin/display-policy/pagination',
            columns: [
                {'data': 'id'},
                {'data': 'fbill_no'},
                {'data': 'fexp_type'},
                {'data': 'fstart_date'},
                {'data': 'fend_date'},
                {'data': 'fcost_dept_id'},
                {'data': 'famount'},
                {'data': 'fsketch'},
                {'data': 'fact_store_num'},
                {'data': 'fstore_cost_limit'},
                {'data': 'fsign_store_num'},
                {'data': 'fsign_amount'},

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

    }

});