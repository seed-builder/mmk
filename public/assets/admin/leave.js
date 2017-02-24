/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/leave',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/leave/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/leave/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fask_type', 'name': 'fask_type', },
                { 'label':  'fauditor_id', 'name': 'fauditor_id', },
                { 'label':  'faudit_date', 'name': 'faudit_date', },
                { 'label':  'fbillno', 'name': 'fbillno', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator_id', 'name': 'fcreator_id', },
                { 'label':  'fdept_id', 'name': 'fdept_id', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'femp_id', 'name': 'femp_id', },
                { 'label':  'fend_time', 'name': 'fend_time', },
                { 'label':  'fforbidder_id', 'name': 'fforbidder_id', },
                { 'label':  'fforbid_date', 'name': 'fforbid_date', },
                { 'label':  'fforbid_status', 'name': 'fforbid_status', },
                { 'label':  'flentime', 'name': 'flentime', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fmodify_id', 'name': 'fmodify_id', },
                { 'label':  'forg_id', 'name': 'forg_id', },
                { 'label':  'freason', 'name': 'freason', },
                { 'label':  'fremarks', 'name': 'fremarks', },
                { 'label':  'fstart_time', 'name': 'fstart_time', },
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
            ajax: '/admin/leave/pagination',
            columns: [
                {  'data': 'id' },
                {
                    "data": 'femp_id',
                    render: function ( data, type, full ) {
                        if(full.employee!=null)
                            return full.employee.fname
                        else
                            return "";
                    }
                },
                {
                    'data': 'fask_type',
                    render: function ( data, type, full ) {
                        switch (data){
                            case 1:
                                return '事假';
                            case 2:
                                return '病假';
                            case 3:
                                return '调休假';
                            case 4:
                                return '婚假';
                            case 5:
                                return '会议培训';
                            case 6:
                                return '其他';
                            default :
                                return '事假';
                        }
                    }
                },
                {  'data': 'freason' },
                {  'data': 'fstart_time' },
                {  'data': 'fend_time' },
                {  'data': 'flentime' },
                {  'data': 'fremarks' },
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

        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

    }

});