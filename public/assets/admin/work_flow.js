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
                    url: '/admin/work-flow',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/work-flow/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/work-flow/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                { 'label':  '名称', 'name': 'name', },
                { 'label':  'table', 'name': 'table', },
                { 'label':  '状态', 'name': 'status', 'type':'select', 'options':[{'label':'启用', 'value': 1},{'label': '禁用', 'value': 0}], 'def': 1},
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
            ajax: '/admin/work-flow/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'name' },
                {  'data': 'table' },
                {  'data': 'status', 'render': function (data) {
                    return data == 1 ? '启用':'禁用';
                } },
                {  'data': 'created_at' },
                {  'data': 'updated_at' },
            ],
            buttons: [
                { text: '新增<i class="fa fa-fw fa-plus"></i>', action: function (e, dt, type, indexes) {
                    window.location.href='/admin/work-flow/create';
                }  },
                { text: '编辑<i class="fa fa-fw fa-pencil"></i>', className: 'edit', enabled: false , action: function (e, dt, type, indexes) {
                    //console.log(e);
                    var rows = table.rows( { selected: true } ).data();
                    console.log(rows[0]);
                    if(rows && rows[0]){
                        //弹出即全屏
                        var index = layer.open({
                            title:'工作流编辑',
                            type: 2,
                            content: '/admin/work-flow/'+ rows[0]['id']+'/edit' ,
                            area: ['800px', '600px'],
                            maxmin: true
                        });
                        layer.full(index);
                        //window.location.href='/admin/work-flow/'+ rows[0]['id'] ;
                    }
                    //
                } },
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        table.on( 'select', checkBtn).on( 'deselect', checkBtn);

        function checkBtn(e, dt, type, indexes) {
            var count = table.rows( { selected: true } ).count();
            table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        }

    }

});