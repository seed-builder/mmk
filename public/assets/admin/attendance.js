/**
 * Created by john on 2017-01-11.
 */
define(function(require, exports, module) {
    
    var zhCN = require('datatableZh');

    exports.index = function ($, tableId,treeId,mapId) {

    	
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
                		if(full.begin_attendance!=null)
                			return full.begin_attendance.ftime
                			else
                				return "";
                	}
                },
                {
                	"data": 'fcomplete_id',
                	render: function ( data, type, full ) {
                		if(full.complete_attendance!=null)
                			return full.complete_attendance.ftime
                			else
                				return "";
                	}
                },
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
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
        table.on( 'xhr', function () {
        	map.clearOverlays();
            var data = table.ajax.json();
            for(var i=0;i<data['data'].length;i++){
                var at = data['data'][i];
                if(at.begin_attendance){
                    mapAddOverlay(at.begin_attendance.flongitude,at.begin_attendance.flatitude,at);
                }
                if(at.complete_attendance){
                    mapAddOverlay(at.complete_attendance.flongitude,at.complete_attendance.flatitude,at);
                }
            }

        });

        var map = new BMap.Map(mapId);
        
        var mapShow = function(){
        	// 百度地图API功能 
        	map.centerAndZoom(new BMap.Point(),14);
        	map.enableScrollWheelZoom(true);

        	var geolocation = new BMap.Geolocation();
        	geolocation.getCurrentPosition(function(r){
        		if(this.getStatus() == BMAP_STATUS_SUCCESS){
        			var mk = new BMap.Marker(r.point);
//         			map.addOverlay(mk);
        			map.panTo(r.point);
        		}
        		else {
        			alert('获取地图失败'+this.getStatus());
        		}        
        	},{enableHighAccuracy: true})
        }
        
        var mapAddOverlay = function(longitude,latitude,data){
        	var point = new BMap.Point(longitude,latitude);
        	var marker = new BMap.Marker(point);  // 创建标注
			map.addOverlay(marker);              // 将标注添加到地图中
			map.panTo(point);

			if(data && data.begin_attendance && data.begin_attendance.ftime) {
                //添加信息窗口
                var content = `<h3>` + data.employee.fname + `</h3><p>签到时间：` + data.begin_attendance.ftime + `</p><p>签退时间：` + data.complete_attendance.ftime + `</p>`
                var infoWindow = new BMap.InfoWindow(content)  // 创建信息窗口对象
                marker.addEventListener("click", function () {
                    this.openInfoWindow(infoWindow);
                });
            }
        }
        
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
        
        var searchtable = function(emp_id){
        	table.columns( 1 ).search( emp_id )
        		 .columns( 2 ).search( $('#datepicker').val() )
        		 .draw();
        }
        
        var datepicker = $( "#datepicker" ).datepicker({
        		format:'yyyy-mm-dd',
        		language: 'zh-CN',
        });
        
        datepicker.on('changeDate', function(ev){
        	searchtable($(".node-selected").data('id'));
        });
    	
        
        mapShow();
    	getTreeData();
    }
    
});