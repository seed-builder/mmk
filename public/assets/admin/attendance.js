/**
 * Created by john on 2017-01-11.
 */
define(function(require, exports, module) {
    
    var zhCN = require('datatableZh');

    exports.index = function ($, tableId) {

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/attendance',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/attendance/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/attendance/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            table: "#" + tableId,
            idSrc: 'id',
//            fields: [
//                {'label': 'name', 'name': 'name',},
//                {'label': 'display_name', 'name': 'display_name',},
//                {'label': 'description', 'name': 'description',},
//                {'label': 'icon', 'name': 'icon',},
//            ]
        });

        var table = $("#" + tableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/attendance/pagination',
            columns: [
                {"data": "id"},
                {
                	"data": 'femp_id',
                	render: function ( data, type, full ) {
                		if(full.employee!=null)
                			return full.employee.fname
                			else
                				return "";
                	}
                },
                {"data": "fday"},
                {
                	"data": 'fbegin_id',
                	render: function ( data, type, full ) {
                		if(full.beginAttendance!=null)
                			return full.beginAttendance.fdate
                			else
                				return "";
                	}
                },
                {
                	"data": 'fcomplete_id',
                	render: function ( data, type, full ) {
                		if(full.completeAttendance!=null)
                			return full.completeAttendance.fdate
                			else
                				return "";
                	}
                },
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
//                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
//                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
//                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
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