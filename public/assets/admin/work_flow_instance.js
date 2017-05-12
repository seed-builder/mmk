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
                    url: '/admin/work-flow-instance',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/work-flow-instance/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/work-flow-instance/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'bill_no', 'name': 'bill_no', },
                    { 'label':  'desc', 'name': 'desc', },
                    { 'label':  'sponsor', 'name': 'sponsor', },
                { 'label':  'sponsor_id', 'name': 'sponsor_id', },
                { 'label':  'status', 'name': 'status', },
                { 'label':  'title', 'name': 'title', },
                { 'label':  'uid', 'name': 'uid', },
                    { 'label':  'work_flow_id', 'name': 'work_flow_id', },
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
            ajax: '/admin/work-flow-instance/pagination',
            columns: [
                    {  'data': 'bill_no' },
                    {  'data': 'created_at' },
                    {  'data': 'desc' },
                    {  'data': 'id' },
                    {  'data': 'sponsor' },
                    {  'data': 'sponsor_id' },
                    {  'data': 'status' },
                    {  'data': 'title' },
                    {  'data': 'uid' },
                    {  'data': 'updated_at' },
                    {  'data': 'work_flow_id' },
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

    };

    exports.my = function ($, tableId) {
        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
                url: '/admin/work-flow-instance/my-pagination',
            },
            columns: [
                {  'data': 'id' },
                {  'data': 'work_flow_id', render: function (data, type, full) {
                    return full.workflow.desc;
                } },
                {  'data': 'bill_no' },
                {  'data': 'title' },
                {  'data': 'status', render: function (data , type, full) {
                    //0-审批中,1-结束, 2-被撤销, 3-非正常结束
                    var txt = '';
                    switch (data){
                        case 0:
                            txt = '审批中';
                            break;
                        case 1:
                            txt = '审批结束';
                            break;
                        case 2:
                            txt = '被撤销';
                            break;
                        case 3:
                            txt = '非正常结束';
                            break;
                    }
                    return txt;
                } },
                {  'data': 'created_at' },
                {  'data': 'updated_at' },
            ],
            order: [[ 6, 'desc' ]],
            buttons: [
                { text: '撤销', className: 'dismiss', enabled: false ,action: function () {
                    var id = table.rows('.selected').data()[0].id;
                    $.post('/admin/work-flow-instance/dismiss/'+id, {_token: $('meta[name="_token"]').attr('content')}, function (result) {
                        if (!result.cancelled) {
                            // You can reload the current location
                            layer.msg('撤销成功！');
                            table.ajax.reload();
                        } else {
                            layer.msg('撤销失败！' + result.error);
                        }
                    },'json');
                }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ],
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
            ]
        });

        table.on( 'select', checkBtn).on( 'deselect', checkBtn);

        function checkBtn(e, dt, type, indexes) {
            var data = table.rows( { selected: true } ).data()[0];
            table.buttons( ['.dismiss'] ).enable(data.status == 0);
        }
    };
});