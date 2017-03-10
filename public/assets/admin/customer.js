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
                    url: '/admin/customer',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/customer/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/customer/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'faddress', 'name': 'faddress', },
                { 'label':  'farea', 'name': 'farea', },
                { 'label':  'fauditor_id', 'name': 'fauditor_id', },
                { 'label':  'faudit_date', 'name': 'faudit_date', },
                { 'label':  'fbusiness_mode', 'name': 'fbusiness_mode', },
                { 'label':  'fcity', 'name': 'fcity', },
                { 'label':  'fcompany_nature', 'name': 'fcompany_nature', },
                { 'label':  'fcompany_scale', 'name': 'fcompany_scale', },
                { 'label':  'fcountry', 'name': 'fcountry', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator_id', 'name': 'fcreator_id', },
                { 'label':  'fcust_type_id', 'name': 'fcust_type_id', },
                { 'label':  'fdiscount_list_id', 'name': 'fdiscount_list_id', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'ffax', 'name': 'ffax', },
                { 'label':  'fforbidder_id', 'name': 'fforbidder_id', },
                { 'label':  'fforbid_date', 'name': 'fforbid_date', },
                { 'label':  'fforbid_status', 'name': 'fforbid_status', },
                { 'label':  'fgroup', 'name': 'fgroup', },
                { 'label':  'finvoice_type', 'name': 'finvoice_type', },
                { 'label':  'fis_credit_check', 'name': 'fis_credit_check', },
                { 'label':  'fmode_transport', 'name': 'fmode_transport', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fmodify_id', 'name': 'fmodify_id', },
                { 'label':  'fname', 'name': 'fname', },
                { 'label':  'fprice_list_id', 'name': 'fprice_list_id', },
                { 'label':  'fprovince', 'name': 'fprovince', },
                { 'label':  'fsale_depart', 'name': 'fsale_depart', },
                { 'label':  'fseller', 'name': 'fseller', },
                { 'label':  'fservice_depart', 'name': 'fservice_depart', },
                { 'label':  'fshort_name', 'name': 'fshort_name', },
                { 'label':  'ftax_rate', 'name': 'ftax_rate', },
                { 'label':  'ftax_register_code', 'name': 'ftax_register_code', },
                { 'label':  'ftax_type', 'name': 'ftax_type', },
                { 'label':  'ftel', 'name': 'ftel', },
                { 'label':  'ftrading_curr_id', 'name': 'ftrading_curr_id', },
                { 'label':  'fwebsite', 'name': 'fwebsite', },
                { 'label':  'fzip', 'name': 'fzip', },
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
            ajax: '/admin/customer/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'fname' },
                {  'data': 'faddress' },
                {  'data': 'ftel' },
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