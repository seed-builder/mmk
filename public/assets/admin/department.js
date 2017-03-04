/**
 * Created by john on 2017-01-11.
 */
define(function(require, exports, module) {
    
    var zhCN = require('datatableZh');
    var editorCN = require('i18n');

    exports.index = function ($, tableId,orgs) {

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/department',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/department/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/department/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            table: "#" + tableId,
            i18n: editorCN,
            idSrc: 'id',
            fields: [
                {'label': '部门名称', 'name': 'fname'},
                {'label': '部门全称', 'name': 'ffullname'},
                {'label': '部门号', 'name': 'fnumber'},
                {
                	'label': '所属组织', 
                	'name': 'forg_id',
                	'type': 'select',
                    'options': orgs
                },
                {'label': '备注', 'name': 'fremark'},
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
            ajax: '/admin/department/pagination',
            columns: [
                {"data": "id"},
                {"data": "fname"},
                {"data": "fnumber"},
                {"data": "ffullname"},
                {
                	"data": 'forg_id',
                	render: function ( data, type, full ) {
                		if(full.organization!=null)
                			return full.organization.fname
                			else
                				return "";
                	}
                },
                {"data": "fcreate_date"},
                {
                    "data": "fdocument_status",
                    render: function ( data, type, full ) {
                        return document_status(data);
                    }
                },

            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit",className: 'edit', text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        function rowSelect() {
            checkEditEnabble(table,'.edit');
        }
        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

    }

});