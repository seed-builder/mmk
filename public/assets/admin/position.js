/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,treeId) {

        //组织结构初始化
        var getTreeData = function () {
            $.ajax({
                url: "../../admin/department/departmentTree",
                type: "POST",
                data: {'_token':$('meta[name="_token"]').attr('content')},
                dataType:'json',
                success:function(data){
                    $("#" + treeId).treeview({
                        color: "#428bca",
                        enableLinks: true,
                        levels: 99,
                        data: data,
                        onNodeSelected: function(event, data) {
                            table.ajax.reload();
                        },
                        onNodeUnselected: function(event, data) {
                            table.ajax.reload();
                        },
                    });
                },
            });
        }

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/position',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/position/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/position/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fauditor_id', 'name': 'fauditor_id', },
                { 'label':  'faudit_date', 'name': 'faudit_date', },
                { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator_id', 'name': 'fcreator_id', },
                { 'label':  'fdept_id', 'name': 'fdept_id', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'fforbidder_id', 'name': 'fforbidder_id', },
                { 'label':  'fforbid_date', 'name': 'fforbid_date', },
                { 'label':  'fforbid_status', 'name': 'fforbid_status', },
                { 'label':  'fis_main', 'name': 'fis_main', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fmodify_id', 'name': 'fmodify_id', },
                { 'label':  'fname', 'name': 'fname', },
                { 'label':  'fnumber', 'name': 'fnumber', },
                { 'label':  'fparpost_id', 'name': 'fparpost_id', },
                { 'label':  'fremark', 'name': 'fremark', },
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
            ajax: {
                url : '/admin/position/pagination',
                data : function (data) {
                    var selectedNode = $('#'+treeId).treeview('getSelected');
                    data['nodeid'] = selectedNode.length>0?selectedNode[0]['dataid']:'';
                }
            },
            columns: [
                {  'data': 'id' },
                {  'data': 'fnumber' },
                {  'data': 'fname' },
                {
                    'data': 'fparpost_id',
                    render: function ( data, type, full ) {
                        if(full.senior!=null)
                            return full.senior.fname
                        else
                            return "无";
                    }
                },
                {
                    'data': 'fdept_id',
                    render: function ( data, type, full ) {
                        if(full.department!=null)
                            return full.department.fname
                        else
                            return "";
                    }
                }
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

        getTreeData();
    }

});