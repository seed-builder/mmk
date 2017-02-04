/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,treeId,childTableId,mapId) {

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
                            // Your logic goes here
							//alert(data.dataid);
//                            table.search( data.dataid ).draw();
                        	searchtable(data.dataid);
                        }
                    });
                },
            });
        }

        //地图初始化
        var map = new BMap.Map(mapId);

        var mapShow = function(){
            // 百度地图API功能
            map.centerAndZoom("厦门", 12);
            map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
            map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
            map.enableInertialDragging();

        }

        //各表初始化
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/visit-line-store',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/visit-line-store/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/visit-line-store/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'fcreate_date', 'name': 'fcreate_date', },
                { 'label':  'fcreator_id', 'name': 'fcreator_id', },
                { 'label':  'fdocument_status', 'name': 'fdocument_status', },
                { 'label':  'femp_id', 'name': 'femp_id', },
                { 'label':  'fline_id', 'name': 'fline_id', },
                { 'label':  'fmodify_date', 'name': 'fmodify_date', },
                { 'label':  'fmodify_id', 'name': 'fmodify_id', },
                { 'label':  'fstore_id', 'name': 'fstore_id', },
                { 'label':  'fweek_day', 'name': 'fweek_day', },
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
            ajax: '/admin/visit-line-store/pagination',
            columns: [
                    {  'data': 'id' },
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
    						if(full.line!=null)
    							return full.employee.fname
    							else
    								return "";
    					}
    				},
    				{
    					"data": 'femp_id',
    					render: function ( data, type, full ) {
    						if(full.employee.department!=null)
    							return full.employee.department.fname
    							else
    								return "";
    					}
    				},
    				{
    					"data": 'femp_id',
    					render: function ( data, type, full ) {
    						if(full.line!=null)
    							return full.employee.fphone
    							else
    								return "";
    					}
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
                {
                	text: '线路门店互调<i class="fa fa-fw fa-random"></i>',
                	className: 'lineAdjust',
                	enabled: false,
                	action: function () {
                		$('#lineAdjust').modal('show');
                	}
                },
                {
                	text: '线路门店调整<i class="fa fa-fw fa-random"></i>',
                	className: 'storeAdjust',
                	enabled: false,
                	action: function () {

                        readyTable.ajax.reload();
                        allotTable.ajax.reload();
                		$('#storeAdjust').modal('show');
                	}
                },
                //{extend: 'colvis', text: '列显示'}
            ]
        });


        //子表
        var childEditor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/store',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/store/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/store/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            table: "#" + childTableId,
            idSrc: 'id',
            fields: [
                {'label': '门店全称', 'name': 'ffullname'},
                {'label': '门店简称', 'name': 'fshortname'},
                {'label': '客户详址', 'name': 'faddress'},
                {'label': '负责人', 'name': 'fcontracts'},
                {'label': '联系电话', 'name': 'ftelephone'},
                {'label': '渠道分类', 'name': 'fchannel'},
            ]
        });

        var childTable = $("#" + childTableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/visit_line_store/pagination',
            columns: [
                {"data": "id"},
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
                    "data": 'fstore_id',
                    render: function ( data, type, full ) {
                        if(full.store!=null)
                            return full.store.fshortname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function ( data, type, full ) {
                        if(full.store!=null)
                            return full.store.faddress
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function ( data, type, full ) {
                        if(full.store!=null)
                            return full.store.fcontracts
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function ( data, type, full ) {
                        if(full.store!=null)
                            return full.store.ftelephone
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
                    "data": 'fline_id',
                },

            ],
            columnDefs: [
                {
                    "targets": [7],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {
                	text: '新增<i class="fa fa-fw fa-plus"></i>',
                	action: function () {
                	}
                },
//                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},


                //{extend: 'colvis', text: '列显示'}
            ]
        });

        //预分配门店列表
        var readyTable = $("#readyTable").DataTable({
        	dom: "Bfrtip",
        	language: zhCN,
        	processing: true,
        	serverSide: true,
        	select: true,
        	scrollX: true,
            scrollY: '350px',
            scrollCollapse: true,
            searching:true,
        	paging: true,
        	rowId: "id",
        	ajax: {
        	    url : '/admin/store/pagination',
                data : function ( data ) {
                    data.columns[5]['search']['value'] = table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].femp_id:'';
                    data['femp_id'] = table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].femp_id:'';
                    data['fname'] = $("#fname").val();
                    data['faddress'] = $("#faddress").val();
                    data['is_allot'] = $("#is_allot").val();
                    data['fnumber'] = $("#fnumber").val();
                    data['fline_id'] = table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].fline_id:'';
                }
            },
        	columns: [
        	          {"data": "id"},
                {"data": "ffullname"},
                {"data": "fshortname"},
                {"data": "faddress"},
                {"data": "fcontracts"},

                  {
                      "data": 'femp_id',
                      render: function ( data, type, full ) {
                          if(full.employee!=null)
                              return full.employee.fname
                              else
                                  return "";
                      }
                  },
                {"data": "ftelephone"},


        	          ],
        	          buttons: []
        });

        //线路已分配门店列表
        var allotTable = $("#allotTable").DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: false,
            scrollX: true,
            scrollY: '700px',
            scrollCollapse: true,
            searching:true,
            paging: true,
            rowId: "id",
            ajax: {
                url : '/admin/visit_line_store/pagination',
                data : function (data) {
                    data.columns[6]['search']['value'] = table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].femp_id:'';
                    data.columns[7]['search']['value'] = table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].fline_id:'';
                    // allotTable.columns( 7 ).search( table.rows('.selected').data()[0].fline_id ).draw();
                }
            },
            columns: [
                {"data": "id"},
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
                    "data": 'fstore_id',
                    render: function ( data, type, full ) {
                        if(full.store!=null)
                            return full.store.fshortname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function ( data, type, full ) {
                        if(full.store!=null)
                            return full.store.faddress
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function ( data, type, full ) {
                        if(full.store!=null)
                            return full.store.fcontracts
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function ( data, type, full ) {
                        if(full.store!=null)
                            return full.store.ftelephone
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
                    "data": 'fline_id',
                },

            ],
            columnDefs: [
                {
                    "targets": [7],
                    "visible": false
                }
            ],
            buttons: []
        });

        //预分配门店 表格查询按钮
        $("#tQueryBtn").on('click',function () {
            readyTable.ajax.reload();
        });

        //预分配门店 表格添加按钮
        $("#tAddBtn").on('click',function () {
            addAllotStore(readyTable.rows('.selected').data()[0].id);
        });

        //预分配门店 地图查询按钮
        $("#mQueryBtn").on('click',function () {
            mapQuery();
        })

        //预分配门店 地图添加按钮
        $("#mAddBtn").on('click',function () {
            addAllotStore($("#map_select_id").val());
        })

        //添加门店至已分配门店列表方法
        var addAllotStore = function (store_id) {
            $.ajax({
                type : "POST",
                url : "/admin/visit_line_store",
                data : {
                    "action" : "create",
                    "data[0][fline_id]" : table.rows('.selected').data()[0].fline_id,
                    "data[0][fstore_id]" :store_id ,
                    "data[0][femp_id]" : table.rows('.selected').data()[0].femp_id,
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                    readyTable.ajax.reload();
                    allotTable.ajax.reload();
                    mapQuery();
                }
            })
        }

        //地图查询方法
        var mapQuery = function () {
            map.clearOverlays();

            $.ajax({
                type : "GET",
                url : "/admin/store/query",
                dataType : "json" ,
                data : {
                    "fprovince":$("#province_id").find("option:selected").text(),
                    "fcity":$("#city_id").find("option:selected").text(),
                    "fcountry":$("#country_id").find("option:selected").text(),
                    "femp_id":table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].femp_id:'',
                    'fline_id' : table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].fline_id:'',
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                    for (index in data){
                        mapAddOverlay(data[index]['flongitude'],data[index]['flatitude'],data[index]);
                    }

                }
            })
        }

        //窗口关闭时清除地图标注
        $('#storeAdjust').on('hide.bs.modal', function () {
            map.clearOverlays();
        })


        var searchtable = function(emp_id){
        	table.columns( 3 ).search( emp_id )
        		 .draw();
        }

        //城市区域联动
        $("#province_id").on('change',function () {
            $.ajax({
                type : "GET",
                url : "/admin/city/list",
                dataType : "json" ,
                data : {
                    "parent_id":$("#province_id").val(),
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                    var html = "";
                    for (index in data){
                        html+='<option value="'+data[index].id+'">'+data[index].Name+'</option>';
                    }

                    $("#city_id").html(html)
                    $("#city_id").trigger('change');
                }
            })

        })

        $("#city_id").on('change',function () {
            $.ajax({
                type : "GET",
                url : "/admin/city/list",
                dataType : "json" ,
                data : {
                    "parent_id":$("#city_id").val(),
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                    var html = "";
                    for (index in data){
                        html+='<option value="'+data[index].id+'">'+data[index].Name+'</option>';
                    }
                    $("#country_id").html(html)
                    mapQuery();
                }
            })
        })

        //地图标注方法
        var mapAddOverlay = function(longitude,latitude,data){
            var point = new BMap.Point(longitude,latitude);
            var marker = new BMap.Marker(point);  // 创建标注

            map.addOverlay(marker);              // 将标注添加到地图中
            map.panTo(point);

            infoWindow(marker,data);
        }

        //信息窗口
        function infoWindow(element,data) {

            var content = "<h3>"+data.ffullname+"</h3>"+
                "<p>地址："+data.faddress+"</p>"+
                "<p>负责人人："+data.fcontracts+"</p>"+
                "<p>电话："+data.ftelephone+"</p>"+
                "<p>负责业代："+data.employee.fname+"</p>"

            var infoWindow = new BMap.InfoWindow(content)  // 创建信息窗口对象

            element.addEventListener("click", function(){
                this.openInfoWindow(infoWindow);
                $("#map_select_id").val(data.id);//store_id
            });
        }


        table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        table.on( 'select', reloadChildTable);

        function checkBtn(e, dt, type, indexes) {
             var count = table.rows( { selected: true } ).count();
             table.buttons( ['.storeAdjust','.lineAdjust'] ).enable(count > 0);
         }

        function reloadChildTable(){
        	var selected_emp_id = table.rows('.selected').data()[0].femp_id
        	childTable.columns( 6 ).search( table.rows('.selected').data()[0].femp_id )
                .columns( 7 ).search( table.rows('.selected').data()[0].fline_id )
   		 	.draw();
        }

        $("#province_id").trigger('change');
        mapShow();
        getTreeData();

    }

});