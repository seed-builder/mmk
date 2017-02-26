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
                    url: '/admin/display-policy-store',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/display-policy-store/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/display-policy-store/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': 'famount', 'name': 'famount',},
                {'label': 'fbill_no', 'name': 'fbill_no',},
                {'label': 'fcheck_amount', 'name': 'fcheck_amount',},
                {'label': 'fcheck_status', 'name': 'fcheck_status',},
                {'label': 'fcost_dept_id', 'name': 'fcost_dept_id',},
                {'label': 'fcreate_date', 'name': 'fcreate_date',},
                {'label': 'fcreator_id', 'name': 'fcreator_id',},
                {'label': 'fdate', 'name': 'fdate',},
                {'label': 'fdocument_status', 'name': 'fdocument_status',},
                {'label': 'femp_id', 'name': 'femp_id',},
                {'label': 'fend_date', 'name': 'fend_date',},
                {'label': 'fmodify_date', 'name': 'fmodify_date',},
                {'label': 'fmodify_id', 'name': 'fmodify_id',},
                {'label': 'forg_id', 'name': 'forg_id',},
                {'label': 'fpolicy_id', 'name': 'fpolicy_id',},
                {'label': 'fsign_amount', 'name': 'fsign_amount',},
                {'label': 'fsketch', 'name': 'fsketch',},
                {'label': 'fstart_date', 'name': 'fstart_date',},
                {'label': 'fstatus', 'name': 'fstatus',},
                {'label': 'fstore_id', 'name': 'fstore_id',},
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
            ajax: '/admin/display-policy-store/pagination',
            columns: [
                {'data': 'id'},
                {'data': 'fbill_no'},
                {
                    'data': 'fpolicy_id',
                    render: function ( data, type, full ) {
                        if(full.policy!=null)
                            return full.policy.fsketch
                        else
                            return "";
                    }
                },
                {
                    'data': 'femp_id',
                    render: function ( data, type, full ) {
                        if(full.employee!=null)
                            return full.employee.fname
                        else
                            return "";
                    }
                },
                {'data': 'fstart_date'},
                {'data': 'fend_date'},
                {
                    'data': 'fcost_dept_id',
                    render: function ( data, type, full ) {
                        if(full.department!=null)
                            return full.department.fname
                        else
                            return "";
                    }
                },
                {'data': 'famount'},
                {'data': 'fsketch'},
                {'data': 'fstore_id'},
                {'data': 'fsign_amount'},
                {'data': 'fcheck_amount'},
                {'data': 'fcheck_status'},
                {'data': 'fstatus'},
                {'data': 'fdate'},

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
                // {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
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