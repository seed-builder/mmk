/**
 * Created by john on 2017-01-11.
 */
define(function(require, exports, module) {
    
    var zhCN = require('datatableZh');
    var editorCN = require('i18n');

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
            i18n: editorCN,
            idSrc: 'id',
//            fields: [
//                {'label': 'name', 'name': 'name',},
//                {'label': 'display_name', 'name': 'display_name',},
//                {'label': 'description', 'name': 'description',},
//                {'label': 'icon', 'name': 'icon',},
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
                url : '/admin/attendance/pagination'
            },
            columns: [
                {"data": "id"},
                {"data": "fname"},
                {"data": "fday", render: function (data, type, full) {
                    return data.replace('00:00:00','');
                }},
                {"data": 'fbegin'},
                {"data": 'bg_address'},
                {"data": 'fcomplete'},
                {"data": 'complete_address'},
                {
                    "data": 'fstatus',
                    render: function ( data, type, full ) {
                        if(data==0){
                            return "<span style='color: red'>未完成</span>";
                        }else if(data==1){
                            return "<span style='color: green'>正常</span>"
                        }else if(data==2){
                            return "<span style='color: red'>异常</span>"
                        }else if(data==3){
                            return "<span style='color: purple'>请假</span>"
                        }else {
                            return "<span style='color: orange'>数据异常</span>"
                        }
                    }
                },
                {
                    "data": 'id',
                    render: function (data, type, full) {
                        return '<a href="/admin/attendance/attendanceInfo/'+data+'" data-target="#attendanceInfo" data-toggle="modal"><i class="fa fa-fw fa-search"></i></a>';
                    }
                },
            ],
            buttons: [
                { text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>', action: function () {
                    exportExcel('#moduleForm','/admin/attendance/export-excel');
                }  },
                // { text: '删除', className: 'delete', enabled: false },
//                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
//                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
//                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
//                 {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ],
            columnDefs: [
                {
                    'targets': 0,
                    'visible': {
                        'selectRow': true
                    }
                }
            ],
            order: [[2,'desc']]
        });

        table.on( 'select', rowselect);

        table.on( 'xhr', function () {
        	map.clearOverlays();
            var data = table.ajax.json();
            for(var i=0;i<data['data'].length;i++){
                var at = data['data'][i];

                if(at.bg_flongitude!=null){
                    mapAddOverlay(at.bg_flongitude,at.bg_flatitude,at);
                }
                if(at.complete_flongitude!=null){
                    mapAddOverlay(at.complete_flongitude,at.complete_flatitude,at);
                }

                line(at);
            }

        });

        var map = new BMap.Map(mapId);

        var params = {
            'zoom': 14
        }
        mapInit(map,params);
        
        var mapAddOverlay = function(longitude,latitude,data){
        	var point = new BMap.Point(longitude,latitude);
        	var marker = new BMap.Marker(point);  // 创建标注
			map.addOverlay(marker);              // 将标注添加到地图中
			map.panTo(point);

			infoWindow(marker,data);
        }
        
        var getTreeData = function () {
        	$.ajax({
            	url: "/admin/employee/employeeTree",
            	type: "POST",
            	data: {'_token':$('meta[name="_token"]').attr('content')},
            	dataType:'json',
            	success:function(data){
            	    //alert(data);
                    console.log(data);
            		$("#" + treeId).treeview({
                        color: "#428bca",
                        enableLinks: true,
                        levels: 99,
                        data: data,
                        onNodeSelected: function(event, data) {
                            treeNodeSelect(treeId,table);
                        },
                        onNodeUnselected: function (event, data) {
                            treeNodeUnSelect(treeId,table);
                        },
                        onSearchComplete: function(event, data) {
                            if (JSON.stringify(data)!="{}"){

                            }
                        }
                    });
                },
            });
        }
        
        var datepicker = $( "#datepicker" ).datepicker({
        		format:'yyyy-mm-dd',
        		language: 'zh-CN',
        });

        var treeSearch = function () {
            $("#treeSearch").keyup(function () {
                searchTreeNode($("#treeSearch").val());
            })
        }
        
        datepicker.on('changeDate', function(ev){
            table.ajax.reload();
        });

        //单点地图标注
        function rowselect() {
            map.clearOverlays();
            var data = table.rows('.selected').data()[0];
            if (data.bg_flongitude!=null){
                mapAddOverlay(data.bg_flongitude,data.bg_flatitude,data);
            }
            if (data.complete_flongitude!=null){
                mapAddOverlay(data.complete_flongitude,data.complete_flatitude,data);
            }

            line(data);
        }

        //签到签退地点连线
        function line(data) {
            if (data.bg_flongitude!=null&&data.complete_flongitude!=null){
                var polyline = new BMap.Polyline([
                    new BMap.Point(data.bg_flongitude, data.bg_flatitude),
                    new BMap.Point(data.complete_flongitude, data.complete_flatitude),
                ], {strokeColor:"blue", strokeWeight:6, strokeOpacity:0.5});
                map.addOverlay(polyline);
            }
        }

        //信息窗口
        function infoWindow(element,data) {
            var begin_time = data.fbegin ? data.fbegin:'无';
            var begin_address = data.bg_address ? data.bg_address:'无';
            var complete_time = data.fcomplete ? data.fcomplete:'无'
            var complete_address = data.complete_address ? data.complete_address:'无'

            var attrs = new Array();
            attrs.push({"name":"日期","value":data.fday})
            attrs.push({"name":"签到时间","value":begin_time})
            attrs.push({"name":"签到地址","value":begin_address})
            attrs.push({"name":"签退时间","value":complete_time})
            attrs.push({"name":"签退地址","value":complete_address})
            if (data.fbegin==null||data.fcomplete==null){
                attrs.push({"name":"签到状态","value":"<span style='color: red;font-weight: bold'>异常</span>"})
            }
            var obj = {"title":data.fname,"attrs":attrs};
            mapWindow(element,obj);
        }

        //组织结构查询
        function searchTreeNode(keywords) {
            $("#" + treeId).treeview('search', [ keywords, {
                ignoreCase: true,     // case insensitive
                exactMatch: true,    // like or equals
                revealResults: false,  // reveal matching nodes
            }]);
        }

        $("#moduleForm").find('.filter-submit').trigger('click');


        treeSearch();
    	getTreeData();
    }
    
});