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
                            if (data.nodetype=='emp'){
                                table.buttons( ['.makeAllLine'] ).enable(true);
                            }
                            table.ajax.reload();
                            childTable.ajax.reload();
                        	//searchtable(data.dataid);

                        },
                        onNodeUnselected: function(event, data) {
                            table.buttons( ['.makeAllLine'] ).enable(false);
                            table.ajax.reload();
                            childTable.ajax.reload();
                        },
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
            ajax: {
                url : '/admin/visit-line-store/pagination',
                data : function ( data ) {
                    var selectedNode = $('#'+treeId).treeview('getSelected');
                    data['nodeid'] = selectedNode.length>0?selectedNode[0]['dataid']:'';
                    data['distinct'] = ['fline_id','femp_id']

                }
            },
            columns: [
                    {  'data': 'fline_id' },
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
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
            ],
            buttons: [
                {
                    text: '生成员工线路<i class="fa fa-fw fa-recycle"></i></i>',
                    className: 'makeAllLine',
                    enabled: false,
                    action: function () {
                        layer.confirm('确定生成该员工所有线路（已有线路不会生成）?', function(){
                            $.ajax({
                                type : "GET",
                                url : "/admin/visit_line_store/makeEmpAllLine",
                                dataType : "json" ,
                                data : {
                                    "id" : $(".list-group").find(".node-selected").data('id'),//组织树选中的数据id
                                    "_token": $('meta[name="_token"]').attr('content')
                                },
                                success : function(data) {
                                    if (data['code']==200)
                                        table.ajax.reload();
                                    layer.msg(data['result'])
                                }
                            })

                        });
                    }
                },
                {
                    text: '线路门店互调<i class="fa fa-fw fa-exchange"></i>',
                    className: 'lineAdjust',
                    enabled: false,
                    action: function () {
                        intermodulation();
                        lineStoreTable.ajax.reload();
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
                // { text: '新增', action: function () {
                //     $("#newLine").modal('show');
                // }  },
                 // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},


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
            ajax: {
                url : '/admin/visit-line-store/pagination',
                data : function ( data ) {
                    if (table.rows('.selected').data()[0]==null){
                        var selectedNode = $('#'+treeId).treeview('getSelected');
                        data['nodeid'] = selectedNode.length>0?selectedNode[0]['dataid']:'';
                    }
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
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                // {
                // 	text: '新增<i class="fa fa-fw fa-plus"></i>',
                // 	action: function () {
                // 	}
                // },
//                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
//                 {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
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

        //线路门店调整 --- 线路已分配门店列表
        var allotTable = $("#allotTable").DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
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
            buttons: [
                { text: '显示线路<i class="fa fa-fw fa-search"></i>', action: function () {
                    map.clearOverlays();
                    $("#map_select_id").val("")
                    var datas = allotTable.rows().data();

                    for (var index=0;index<datas.length;index++){
                        if (datas[index].store!=null){
                            mapAddOverlay(datas[index].store.flongitude,datas[index].store.flatitude,datas[index].store);
                        }
                    }
                    line(datas)
                }  },
                { text: '删除<i class="fa fa-fw fa-trash"></i>', action: function () {
                    if (allotTable.rows('.selected').data().length==0){
                        layer.alert('请先选择要删除的门店！');
                        return;
                    }
                    $.messager.confirm('操作提示','确定删除？',function () {
                        $.ajax({
                            type : "GET",
                            url : "/admin/visit_line_store/destroy/"+allotTable.rows('.selected').data()[0].id,
                            dataType : "json" ,
                            data : {
                                "_token": $('meta[name="_token"]').attr('content')
                            },
                            success : function(data) {
                                readyTable.ajax.reload();
                                allotTable.ajax.reload();
                            }
                        })
                    })

                }  },
                { text: '重置<i class="fa fa-fw fa-exchange"></i>', action: function () {
                    var ids = new Array();

                    var data = allotTable.rows().data();
                    for (var i=0;i<data.length;i++){
                        ids.push(data[i].id);
                    }

                    $.messager.confirm('操作提示','确定重置当前线路上所有门店吗！',function () {
                        $.ajax({
                            type : "POST",
                            url : "/admin/visit_line_store/destroyAll",
                            dataType : "json" ,
                            data : {
                                "ids" : ids,
                                "_token": $('meta[name="_token"]').attr('content')
                            },
                            success : function(data) {
                                readyTable.ajax.reload();
                                allotTable.ajax.reload();

                            }
                        })
                    });

                }  },
            ]
        });

        //线路门店互调 --- 线路已分配门店列表
        var lineStoreTable = $("#lineStoreTable").DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            searching:true,
            paging: true,
            rowId: "id",
            ajax: {
                url : '/admin/visit_line_store/pagination',
                data : function (data) {
                    data.columns[1]['search']['value'] = table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].femp_id:'';
                    data.columns[2]['search']['value'] = table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].fline_id:'';
                    // allotTable.columns( 7 ).search( table.rows('.selected').data()[0].fline_id ).draw();
                }
            },
            columns: [
                {"data": "id"},
                {
                    "data": 'femp_id',
                },
                {
                    "data": 'fline_id',
                },
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
                        if(full.store.channel!=null)
                            return full.store.channel.fname
                        else
                            return "";
                    }
                },


            ],
            columnDefs: [
                {
                    "targets": [0,1,2],
                    "visible": false
                }
            ],
            buttons: [

            ]
        });

        //预分配门店 表格查询按钮
        $("#tQueryBtn").on('click',function () {
            readyTable.ajax.reload();
        });

        //预分配门店 表格添加按钮
        $("#tAddBtn").on('click',function () {
            var is_allot = $("#is_allot").find('option:selected').val();

            if (readyTable.rows('.selected').data().length==0){
                layer.alert('请先选择要添加的门店！');
                return;
            }
            if (is_allot==1){
                $.messager.confirm('操作提示','该门店已分配在其他线路中，是否继续添加？',function () {
                    addAllotStore(readyTable.rows('.selected').data()[0].id);
                })
            }else{

                addAllotStore(readyTable.rows('.selected').data()[0].id);
            }

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
                    $("#map_select_id").val("")//将地图所选id清空
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
                        data[index]['selectable']=true;
                        mapAddOverlay(data[index]['flongitude'],data[index]['flatitude'],data[index]);
                    }

                }
            })
        }

        //地点连线
        function line(datas) {

            var arr = new Array();
            for (var index=0;index<datas.length;index++){
                var point = new BMap.Point(datas[index].store.flongitude, datas[index].store.flatitude)
                arr.push(point)
            }
            var polyline = new BMap.Polyline(arr, {strokeColor:"blue", strokeWeight:6, strokeOpacity:0.5});
            map.addOverlay(polyline);

        }

        //窗口关闭时清除地图标注
        $('#storeAdjust').on('hide.bs.modal', function () {
            map.clearOverlays();
            $("#map_select_id").val("")
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
                if (data['selectable']==true){
                    $("#map_select_id").val(data.id);//store_id
                }
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

        //线路门店互调 数据展示 方法
        var intermodulation = function () {
            dangqian();
            tongzu();
            kauzu();
        }

        //线路门店互调 当前人员
        var dangqian = function () {
            $("#femp_current").val(table.rows('.selected').data()[0].employee.fname);
            $("#fdept_current").val(table.rows('.selected').data()[0].employee.department.fname);
        }

        //线路门店互调 同组业代
        var tongzu = function () {
            $.ajax({
                type : "GET",
                url : "/admin/employee/employees",
                dataType : "json" ,
                data : {
                    "fdept_id" : table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].employee.fdept_id:'',
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                    var html = "";
                    for (index in data){
                        html+= '<option value="'+data[index].id+'">'+data[index].fname+'</option>'
                    }
                    $("#femp_group").html(html);
                    $("#fdept_group").val(table.rows('.selected').data()[0].employee.department.fname);

                }
            })

        }

        //线路门店互调 跨组业代
        var kauzu = function () {
            $.ajax({
                type : "GET",
                url : "/admin/employee/employees",
                dataType : "json" ,
                data : {
                    "fdept_id" :  $("#fdept_org").val(),
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                    var html = "";

                    for (index in data){
                        html+= '<option value="'+data[index].id+'">'+data[index].fname+'</option>'
                    }
                    $("#femp_org").html(html);

                }
            })

        }

        //线路门店互调 保存按钮
        $("#imlSaveBtn").on('click',function () {
            var femp_id = $(".tab-content").find(".active").find(".femp_id").val();
            var fline_id = $(".tab-content").find(".active").find(".fline_id").val();

            if (femp_id==null){
                layer.alert('请选择一个员工！');
                return ;
            }

            var selected = lineStoreTable.rows('.selected').data();
            if (selected.length==0){
                layer.alert('请在左边列表中选中门店！');
                return ;
            }

            var ids = new Array();
            for (var i=0;i<selected.length;i++){
                ids.push(selected[i].id);
            }

            $.ajax({
                type : "POST",
                url : "/admin/visit_line_store/storeLineIml",
                dataType : "json" ,
                data : {
                    "ids" : ids,
                    "femp_id" : femp_id,
                    "fline_id" : fline_id,
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                    layer.alert('保存成功！');
                    table.ajax.reload();
                    $('#lineAdjust').modal('hide')
                }
            })
        })

        //线路门店互调 选择部门
        $("#fdept_org").on('change',function () {
            kauzu();
        })

        $("#province_id").trigger('change');
        mapShow();
        getTreeData();

    }

});