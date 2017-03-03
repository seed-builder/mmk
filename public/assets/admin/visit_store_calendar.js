/**
 * Created by john on 2017-01-11.
 */
define(function(require, exports, module) {
    
    var zhCN = require('datatableZh');
    var editorCN = require('i18n');

    exports.index = function ($, tableId) {

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/visit_store_calendar',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/visit_store_calendar/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/visit_store_calendar/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            table: "#" + tableId,
            i18n: editorCN,
            idSrc: 'id',
//            fields: [
//                {'label': '线路名称', 'name': 'fname',},
//                {'label': '线路代码', 'name': 'fnumber',},
//                {
//                	'label': '所属组织', 
//                	'name': 'forg_id',
//                	'type': 'select',
//                    'options': orgs
//                },
//            ]
        });

        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/visit_store_calendar/pagination',
            columns: [
				{"data": "id"},
				{
					"data": 'fstore_id',
					render: function ( data, type, full ) {
						if(full.line!=null)
							return full.store.fname
							else
								return "";
					}
				},
				{
					"data": 'femp_id',
					render: function ( data, type, full ) {
						if(full.employee!=null)
							return full.employee.fname
							else
								return "";
					}
				},
				{
					"data": 'forg_id',
				    render: function ( data, type, full ) {
				    	if(full.organization!=null)
				    		return full.organization.fname
				    	else
				    		return "";
				    }
				},
				{
					"data": 'fstatus',
				    render: function ( data, type, full ) {
				    	if(data==1){
				    		return "未开始";
				    	}else if(data==2){
				    		return "进行中";
				    	}else if(data==3){
				    		return "已开始";
				    	}
				    }
				},
				{"data": "fdate"},
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