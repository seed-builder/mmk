/**
 * Created by john on 2017-01-11.
 */
define(function(require, exports, module) {
    
    var zhCN = require('datatableZh');

    exports.index = function ($, tableId,storeTableId,treeId) {

        //组织结构初始化
        var getTreeData = function () {
            $.ajax({
                url: "../../admin/employee/employeeTree",
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
							storeTable.ajax.reload();
                            button_enable();

                        },
                        onNodeUnselected: function(event, data) {
                            table.ajax.reload();
                            storeTable.ajax.reload();
                            button_enable();
                        },
                    });
                },
            });
        }

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/visit_line_calendar',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/visit_line_calendar/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/visit_line_calendar/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            table: "#" + tableId,
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
            ajax: {
            	url : '/admin/visit_line_calendar/pagination',
				data : function (data) {
                    var selectedNode = $('#'+treeId).treeview('getSelected');
                    data['nodeid'] = selectedNode.length>0?selectedNode[0]['dataid']:'';
                }
			},
            columns: [
				{"data": "id"},
				{
					"data": 'fline_id',
					render: function ( data, type, full ) {
						if(full.line!=null)
							return full.line.fnumber
							else
								return "";
					}
				},
				{
					"data": 'fline_id',
					render: function ( data, type, full ) {
						if(full.line!=null)
							return full.line.fname
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
					"data": 'fdate',
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
				{"data": "fcreate_date"},
            ],
            buttons: [
                {
                    text: '生成拜访日历<i class="fa fa-fw fa-calendar"></i>',
                    className: 'create',
                    enabled: false,
                    action: function () {
                        var selectedNode = $('#'+treeId).treeview('getSelected');
                        var femp_id = selectedNode.length>0?selectedNode[0]['dataid']:table.rows('.selected').data()[0].femp_id
                        $("#femp_id").val(femp_id);
                        $("#makeCalendarModal").modal('show');
                        //window.location.href = "/admin/visit_store_calendar/makeVisitLineCalendar?week="+week+"&femp_id="+femp_id
                    }
                },
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

        table.on( 'select', rowSelect).on( 'deselect', rowSelect);

        function button_enable() {
            var count = table.rows( { selected: true } ).count();
            table.buttons( ['.create'] ).enable(count > 0);

            if(count==0){
                var treeNode = $('#'+treeId).treeview('getSelected');
                if (treeNode.length>0){
                    table.buttons( ['.create'] ).enable(treeNode[0].nodetype=='emp');
                }

            }
        }

        function rowSelect() {
            button_enable();
            storeTable.ajax.reload();
        }

        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

//         var storeEditor = new $.fn.dataTable.Editor({
//             ajax: {
//                 create: {
//                     type: 'POST',
//                     url: '/admin/visit_store_calendar',
//                     data: {_token: $('meta[name="_token"]').attr('content')},
//                 },
//                 edit: {
//                     type: 'PUT',
//                     url: '/admin/visit_store_calendar/_id_',
//                     data: {_token: $('meta[name="_token"]').attr('content')},
//                 },
//                 remove: {
//                     type: 'DELETE',
//                     url: '/admin/visit_store_calendar/_id_',
//                     data: {_token: $('meta[name="_token"]').attr('content')},
//                 }
//             },
//             table: "#" + tableId,
//             idSrc: 'id',
// //            fields: [
// //                {'label': '线路名称', 'name': 'fname',},
// //                {'label': '线路代码', 'name': 'fnumber',},
// //                {
// //                	'label': '所属组织',
// //                	'name': 'forg_id',
// //                	'type': 'select',
// //                    'options': orgs
// //                },
// //            ]
//         });

        var storeTable = $("#" + storeTableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
            	url : '/admin/visit_store_calendar/pagination',
				data : function (data) {
                    if (table.rows('.selected').data()[0]==null){
                        var selectedNode = $('#'+treeId).treeview('getSelected');
                        data['nodeid'] = selectedNode.length>0?selectedNode[0]['dataid']:'';
					}
                    data.columns[1]['search']['value'] = table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].id:'';
                }
			},
            columns: [
                {"data": "id"},
                {"data": 'fline_calendar_id'},
                {
                    "data": 'fstore_id',
                    render: function ( data, type, full ) {
                        if(full.store!=null)
                            return full.store.ffullname
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
                    "data": 'fdate',
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
                {
                    "data": "id",
                    render: function ( data, type, full ) {
                        return '<a href="/admin/visit_store_calendar/visitStoreCalendarInfo/'+data+'" data-target="#todoInfo" data-toggle="modal"><i class="fa fa-fw fa-search"></i></a>';
                    }
                },
            ],
            columnDefs: [
                {
                    "targets": [1],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
//                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: storeEditor},
//                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: storeEditor},
//                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: storeEditor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });
        
        $("#makeCalendarForm").on('submit',function () {
            $("#makeBtn").val('正在生成中，请稍后....')
            $("#makeBtn").attr('disabled',true);

        })

        getTreeData();

    }

});