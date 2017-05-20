/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId) {

        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/rollcall/pagination',
            columns: [
                {  'data': 'employee_name' , render: function (data, type, full) {
                    return full.employee_name;
                }},
                {  'data': 'position_name' , render: function (data, type, full) {
                    return full.position_name;
                }},
                {  'data': 'fmodify_date' },
                {  'data': 'faddress' },
                {  'data': 'fphotos' ,render: function (data, type, full) {
                    //var arr = data ? data.split(',') : [];
                    return  '<button type="button" class="btn btnImage" ><i class="fa fa-fw fa-search"></i></button>';
                    //arr.length > 0 ? '<img src="/admin/show-image?imageId='+arr[0]+'" />' : '';
                }},
                {  'data': 'flatitude',  render: function (data, type, full) {
                    return '<button type="button" class="btn btnMap" ><i class="fa fa-fw fa-search"></i></button>';
                } },
                {  'data': 'fmode' , render: function (data, type, full) {
                    var txt = '';
                    switch (data){
                        case "0":
                            txt = '日开始';
                            break;
                        case "1":
                            txt = '日完成';
                            break;
                        case "2":
                            txt = '门店拜访';
                            break;
                    }
                    return txt;
                }},
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
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

        function showDialg() {
            var rows = table.rows( { selected: true } ).data();
            //alert(rows.length);
            for(var i = 0; i < rows.length; i++){
                var data = rows[i];
                pointTo(data.flatitude, data.flongitude, data.employee_name, data.position_name);
            }
            $('#mapDialog').modal('show');
        }
        //map = new BMap.Map("allmap");    // 创建Map实例

        function init() {
            //        // 百度地图API功能
            map = new BMap.Map("allmap");    // 创建Map实例
            map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);  // 初始化地图,设置中心点坐标和地图级别
            map.addControl(new BMap.MapTypeControl());   //添加地图类型控件
            map.setCurrentCity("北京");          // 设置地图显示的城市 此项是必须设置的
            map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
        }

        // 百度地图API功能
        function pointTo(latitude, longitude, employee, position) {
            if(!map){
                init();
            }
            var point = new BMap.Point(longitude, latitude);
            map.panTo(point);
            map.enableScrollWheelZoom(true);
            map.centerAndZoom(point, 15);
            var marker = new BMap.Marker(point);  // 创建标注
            map.addOverlay(marker);              // 将标注添加到地图中

            var opts = {
                width : 200,     // 信息窗口宽度
                height: 100,     // 信息窗口高度
                title : employee , // 信息窗口标题
                enableMessage:true,//设置允许信息窗发送短息
                //message:"亲耐滴，晚上一起吃个饭吧？戳下面的链接看下地址喔~"
            }
            var infoWindow = new BMap.InfoWindow("职务：" + position, opts);  // 创建信息窗口对象
            marker.addEventListener("click", function(){
                map.openInfoWindow(infoWindow,point); //开启信息窗口
            });
        }

        init();

        function bindEvt() {
            $('.btnMap').on('click', function () {
                var rows = table.rows( { selected: true } ).data();
                //alert(rows.length);
                for(var i = 0; i < rows.length; i++){
                    var data = rows[i];
                    pointTo(data.flatitude, data.flongitude, data.employee_name, data.position_name);
                }
                $('#mapDialog').modal('show');
            });

            $('.btnImage').on('click', function () {
                var rows = table.rows( { selected: true } ).data();
                if(rows){
                    var photos = rows[0].fphotos ? rows[0].fphotos.split(','):[];
                    $('#commonDialogContent').html('<img src="/admin/show-image?imageId='+photos[0]+'" />')
                    $('#commonDialog').modal('show');
                }
            })
        }



        table.on( 'draw', function () {
            //alert( 'Table redrawn' );
            bindEvt();
        } );
        bindEvt();

    }

});