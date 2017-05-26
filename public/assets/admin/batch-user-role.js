/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId) {

        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/user/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'name' },
                {  'data': 'nick_name' },
                // {  'data': 'email' },
                {  'data': 'reference_type' },
                {  'data': 'status', render: function (data, type, full) {
                    return data == 1 ? '启用':'禁用';
                } },
                {  'data': 'created_at' },
                {  'data': 'updated_at' },
            ],
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    },
                    'searchable': false,
                    'sortable': false
                }
            ],
            select: {
                'style': 'multi'
            },
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        $(".form-submit").on('click',function () {
            var row = table.rows('.selected').data();

            var user_ids = new Array();
            for (var i = 0; i < row.length; i++) {
                user_ids.push(row[i].id);
            }

            if (user_ids==''){
                layer.alert('请选择用户！');
                return
            }
            $("#user_ids").val(user_ids);
            $("#form-id").submit();
        })

    }

});