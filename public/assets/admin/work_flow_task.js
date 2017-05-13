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
                    url: '/admin/work-flow-task',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/work-flow-task/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/work-flow-task/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'action', 'name': 'action', },
                { 'label':  'approver_id', 'name': 'approver_id', },
                        { 'label':  'link_id', 'name': 'link_id', },
                { 'label':  'node_id', 'name': 'node_id', },
                { 'label':  'pre_task_id', 'name': 'pre_task_id', },
                { 'label':  'remark', 'name': 'remark', },
                { 'label':  'status', 'name': 'status', },
                { 'label':  'uid', 'name': 'uid', },
                    { 'label':  'work_flow_id', 'name': 'work_flow_id', },
                { 'label':  'work_flow_instance_id', 'name': 'work_flow_instance_id', },
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
            ajax: '/admin/work-flow-task/pagination',
            columns: [
                    {  'data': 'action' },
                    {  'data': 'approver_id' },
                    {  'data': 'created_at' },
                    {  'data': 'id' },
                    {  'data': 'link_id' },
                    {  'data': 'node_id' },
                    {  'data': 'pre_task_id' },
                    {  'data': 'remark' },
                    {  'data': 'status' },
                    {  'data': 'uid' },
                    {  'data': 'updated_at' },
                    {  'data': 'work_flow_id' },
                    {  'data': 'work_flow_instance_id' },
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

    exports.todo = function ($, tableId) {
        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/work-flow-task/todo-pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'desc' },
                {  'data': 'bill_no' },
                {  'data': 'title' },
                {  'data': 'sponsor' },
                {  'data': 'created_at' },
                {  'data': 'updated_at' },
            ],
            order: [[ 5, 'desc' ]],
            buttons: [
                { text: '同意',  className: 'agree', enabled: false, action: function () {
                    //prompt层
                    layer.prompt({title: '【同意】输入意见', value: '同意', formType: 2}, function(pass, index){
                        layer.close(index);
                        var data = table.rows( { selected: true } ).data()[0];
                        if(data){
                            $.post('/admin/work-flow-task/'+data.id+'/agree', {_token: $('meta[name="_token"]').attr('content')}, function (result) {
                                if(result.data){
                                    layer.msg('审批通过!');
                                    table.ajax.reload();
                                }else{
                                    layer.msg('审批失败!');
                                }
                            }, 'json');
                        }
                    });
                }  },
                { text: '驳回',  className: 'disagree', enabled: false, action: function () {
                    layer.prompt({title: '【驳回】输入意见', value: '不同意', formType: 2}, function(pass, index){
                        layer.close(index);
                        var data = table.rows( { selected: true } ).data()[0];
                        if(data){
                            $.post('/admin/work-flow-task/'+data.id+'/against', {_token: $('meta[name="_token"]').attr('content')}, function (result) {
                                if(result.data){
                                    layer.msg('驳回成功!');
                                    table.ajax.reload();
                                }else{
                                    layer.msg('驳回失败!');
                                }
                            }, 'json');
                        }
                    });
                }  },
                { text: '审批详情',  className: 'info', enabled: false, action: function () {

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
            var count = table.rows( { selected: true } ).count();
            table.buttons( ['.agree', '.disagree', '.info'] ).enable(count > 0);
        }
    }

    exports.done = function ($, tableId) {
        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/work-flow-task/done-pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'desc' },
                {  'data': 'bill_no' },
                {  'data': 'title' },
                {  'data': 'sponsor' },
                {  'data': 'created_at' },
                {  'data': 'updated_at' },
            ],
            order: [[ 5, 'desc' ]],
            buttons: [
                // { text: '新增', action: function () { }  },
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

        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }
    }
});