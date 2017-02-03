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
            table: "#" + tableId,
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

        var table = $("#" + tableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/store/pagination',
            columns: [
                {"data": "id"},
                {"data": "ffullname"},
                {"data": "fshortname"},
                {"data": "faddress"},
                {"data": "fcontracts"},
                {"data": "ftelephone"},
                {
                	"data": 'femp_id',
                	render: function ( data, type, full ) {
                		if(full.employee!=null)
                			return full.employee.fname
                			else
                				return "";
                	}
                },
                {"data": "flongitude"},
                {"data": "flatitude"},
                
            ],
            columnDefs: [
                {
                    "targets": [7,8],
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
                		$('#storeinfo').modal('show');
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

        table.on( 'xhr', function () {
            map.clearOverlays();
            var data = table.ajax.json();
            for(var i=0;i<data['data'].length;i++){
                var st = data['data'][i];

                mapAddOverlay(st.flongitude,st.flatitude,st);
            }

        });

        table.on( 'select', rowselect);

        var map = new BMap.Map(mapId);

        var mapShow = function(){
            // 百度地图API功能
            map.centerAndZoom(new BMap.Point(),14);
            map.enableScrollWheelZoom(true);

            var geolocation = new BMap.Geolocation();
            geolocation.getCurrentPosition(function(r){
                if(this.getStatus() == BMAP_STATUS_SUCCESS){
                    var mk = new BMap.Marker(r.point);
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
            //map.panTo(point);

            infoWindow(marker,data);
        }

        var getTreeData = function () {
            $.ajax({
                url: "../../admin/employee/employeeTree",
                type: "POST",
                data: {
                    '_token':$('meta[name="_token"]').attr('content'),
                    'dept_select':true
                },
                dataType:'json',
                success:function(data){
                    $("#" + treeId).treeview({
                        color: "#428bca",
                        enableLinks: true,
                        levels: 99,
                        data: data,
                        onNodeSelected: function(event, data) {
                            searchtable(data.dataid);
                        },
                        onSearchComplete: function(event, data) {
                            if (JSON.stringify(data)!="{}"){

                            }
                        }
                    });
                },
            });
        }

        var searchtable = function(emp_id){
            table.columns( 6 ).search( emp_id )
                .draw();
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
            });
        }

        //单点地图标注
        function rowselect() {
            map.clearOverlays();
            var data = table.rows('.selected').data()[0];

            mapAddOverlay(data.flongitude,data.flatitude,data);
            var point = new BMap.Point(data.flongitude,data.flatitude,data);
            map.panTo(point);

        }



        getTreeData();
        mapShow();
    }

});