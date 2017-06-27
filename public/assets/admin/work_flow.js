/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId, userTable) {
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
                { 'label':  '描述', 'name': 'desc', },
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
                {  'data': 'desc' },
                {  'data': 'default_task_approver_id', 'render':function(data, type, full){
                    return full.default_task_approver ? full.default_task_approver.nick_name : '';
                } },
                {  'data': 'status', 'render': function (data) {
                    return data == 1 ? '启用':'禁用';
                } },
                {  'data': 'created_at' },
                {  'data': 'updated_at' },
            ],
            buttons: [
                // { text: '新增<i class="fa fa-fw fa-plus"></i>', action: function (e, dt, type, indexes) {
                //     window.location.href='/admin/work-flow/create';
                // }  },
                // { text: '编辑<i class="fa fa-fw fa-pencil"></i>', className: 'edit', enabled: false , action: function (e, dt, type, indexes) {
                //     //console.log(e);
                //     var rows = table.rows( { selected: true } ).data();
                //     console.log(rows[0]);
                //     if(rows && rows[0]){
                //         //弹出即全屏
                //         var index = layer.open({
                //             title:'工作流编辑',
                //             type: 2,
                //             content: '/admin/work-flow/'+ rows[0]['id']+'/edit' ,
                //             area: ['800px', '600px'],
                //             maxmin: true
                //         });
                //         layer.full(index);
                //         //window.location.href='/admin/work-flow/'+ rows[0]['id'] ;
                //     }
                //     //
                // } },
                // // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                // {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                { text: '设置缺省处理人', className: 'transfer', enabled: false, action: function () {
                    $('#chooseUserDialog').modal('show');
                    usertable.rows().deselect();
                    usertable.ajax.reload();
                }  },
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        table.on( 'select', checkBtn).on( 'deselect', checkBtn);

        function checkBtn(e, dt, type, indexes) {
            var count = table.rows( { selected: true } ).count();
            table.buttons( ['.transfer'] ).enable(count > 0);
        }

        var usertable = $("#" + userTable).DataTable({
            dom: "frtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: {
                style: 'single'
            },
            paging: true,
            rowId: "id",
            ajax: {
                url: '/admin/user/pagination',
                data : function (data) {
                    data.columns[3]['search']['value'] = 'employee';
                    data.columns[4]['search']['value'] = 1;
                }
            },
            columns: [
                {  'data': 'id',render: function (data, type, full) {
                    return '<input type="checkbox" class="editor-active" value="' + data + '">';
                },
                    className: "dt-body-center"
                },
                {  'data': 'name' },
                {  'data': 'nick_name' },
                {  'data': 'reference_type' },
                {  'data': 'status' },
            ],
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                },
                {
                    "targets": [3,4],
                    "visible": false
                }
            ],
        });

        $('#transferBtn').click(function () {
            var count = usertable.rows( { selected: true } ).count();
            if(count > 0){
                layer.confirm('确定设置缺省处理人 ?', ['确定','取消'], function () {
                    var wf = table.rows( { selected: true } ).data()[0];
                    var user = usertable.rows( { selected: true } ).data()[0];
                    $.post('/admin/work-flow/set-default-approver/' + wf.id,
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            approver_id: user.id
                        }, function (res) {
                            if(res.cancelled == 0){
                                layer.msg('设置成功!');
                                $('#chooseUserDialog').modal('hide');
                                table.ajax.reload();
                            }
                        }
                    );
                })
            }else{
                layer.alert('请选择处理人');
            }
        })


    }

});