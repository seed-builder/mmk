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
                    url: '/admin/fin-statement',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/fin-statement/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/fin-statement/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'abstract', 'name': 'abstract', },
                { 'label':  'bal_amount', 'name': 'bal_amount', },
                { 'label':  'bill_date', 'name': 'bill_date', },
                { 'label':  'bill_no', 'name': 'bill_no', },
                { 'label':  'bill_type', 'name': 'bill_type', },
                { 'label':  'cur_amount', 'name': 'cur_amount', },
                { 'label':  'cust_id', 'name': 'cust_id', },
                { 'label':  'cust_name', 'name': 'cust_name', },
                { 'label':  'cust_num', 'name': 'cust_num', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                    { 'label':  'month', 'name': 'month', },
                { 'label':  'print_status', 'name': 'print_status', },
                { 'label':  'project_no', 'name': 'project_no', },
                { 'label':  'remarks', 'name': 'remarks', },
                { 'label':  'seq', 'name': 'seq', },
                { 'label':  'srcbill_no', 'name': 'srcbill_no', },
                { 'label':  'status', 'name': 'status', },
                { 'label':  'year', 'name': 'year', },
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
            ajax: '/admin/fin-statement/pagination',
            columns: [
                    {  'data': 'abstract' },
                    {  'data': 'bal_amount' },
                    {  'data': 'bill_date' },
                    {  'data': 'bill_no' },
                    {  'data': 'bill_type' },
                    {  'data': 'cur_amount' },
                    {  'data': 'cust_id' },
                    {  'data': 'cust_name' },
                    {  'data': 'cust_num' },
                    {  'data': 'fcreate_date' },
                    {  'data': 'fmodify_date' },
                    {  'data': 'id' },
                    {  'data': 'month' },
                    {  'data': 'print_status' },
                    {  'data': 'project_no' },
                    {  'data': 'remarks' },
                    {  'data': 'seq' },
                    {  'data': 'srcbill_no' },
                    {  'data': 'status' },
                    {  'data': 'year' },
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