/**
 * Created by john on 2017-01-11.
 */
define(function(require, exports, module) {
    
    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,treeId, orgs, depts, postions) {

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
                    url: '/admin/employee',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/employee/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/employee/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': '姓名', 'name': 'fname',},
                {'label': '工号', 'name': 'fnumber',},
                {'label': '电话', 'name': 'fphone',},
                {'label': '地址', 'name': 'faddress',},
                {'label': '邮箱', 'name': 'femail',},
                { 'label': '组织', 'name': 'forg_id', 'type': 'select', 'options': orgs},
                { 'label': '部门', 'name': 'fdept_id', 'type': 'select', 'options': depts},
                { 'label': '职位', 'name': 'fpost_id', 'type': 'select', 'options': postions},
                {'label': '设备', 'name': 'device',},
                {'label': '设备号', 'name': 'device_sn',},
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
            ajax: {
                url : '/admin/employee/pagination',
                data : function (data) {
                    var selectedNode = $('#'+treeId).treeview('getSelected');
                    if(selectedNode) {
                        data['nodeid'] = selectedNode.length > 0 ? selectedNode[0]['dataid'] : '';
                    }
                }
            },
            columns: [
                {"data": "id"},
                {"data": "fname"},
                {"data": "fnumber"},
                {
                	"data": 'fdept_id',
                    render: function ( data, type, full ) {
                    		return full.dept_name;
                    }
                },
                {
                	"data": 'fpost_id',
                    render: function ( data, type, full ) {
                    	 return full.position_name;
                    }
                },
                {"data": "fphone"},
                {"data": "femail"},
                {"data": "device"},
                {"data": "device_sn"},

            ],
            "columnDefs": [
                {
                    "targets": [ 7,8 ],
                    "visible": false,
                    "searchable": false
                },
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
                {extend: 'colvis', text: '列显示'}
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