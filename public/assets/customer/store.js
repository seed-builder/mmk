/**
 * Created by john on 2017-01-11.
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');

    exports.index = function ($, tableId, treeId, mapId, smapId) {

        //表格初始化
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/customer/store',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/customer/store/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/customer/store/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            table: "#" + tableId,
            idSrc: 'id',
            i18n: editorCN,
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
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
                url : '/customer/store/pagination',
                data : function (data) {
                    var treeNode = $('#'+treeId).treeview('getSelected');
                    if (treeNode.length>0){
                        data['nodeid'] = treeNode[0].dataid;
                    }

                }
            },
            columns: [
                {"data": "id"},
                {"data": "ffullname"},
                // {"data": "fshortname"},
                {"data": "faddress"},
                {"data": "fcontracts"},
                {"data": "ftelephone"},
                {
                    "data": 'femp_id',
                    render: function (data, type, full) {
                        if (full.employee != null)
                            return full.employee.fname
                        else
                            return "";
                    }
                },
                {"data": "flongitude"},
                {"data": "flatitude"},
                {
                    "data": "fis_signed",
                    render: function (data, type, full) {
                        if (data==0){
                            return '未签约';
                        }else {
                            return '已签约';
                        }
                    }
                },
                {
                    "data": 'id',
                    render: function (data, type, full) {
                        return '<a href="/customer/store/storeInfo/'+data+'" data-target="#storeDetail" data-toggle="modal"><i class="fa fa-fw fa-search"></i></a>';
                    }
                },
            ],
            columnDefs: [
                {
                    "targets": [0, 6, 7],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                 
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},

                //{extend: 'colvis', text: '列显示'}
            ]
        });


        table.on('xhr', function () {
            map.clearOverlays();
            var data = table.ajax.json();
            for (var i = 0; i < data['data'].length; i++) {
                var st = data['data'][i];

                mapAddOverlay(st.flongitude, st.flatitude, st);
            }


        });

        table.on('select', rowselect).on( 'deselect', editEnable);

        //主表地图
        var map = new BMap.Map(mapId, {enableMapClick: false});

        //添加/编辑门店 地图选址
        var smap = new BMap.Map(smapId, {enableMapClick: false});

        //地图展示
        var params = {
            'zoom': 14,
        }
        mapInit(map,params);
        mapInit(smap,params);

        //地图点击事件
        var mapClick = function () {
            smap.addEventListener("click", function (e) {
                smap.clearOverlays();
                var point = new BMap.Point(e.point.lng, e.point.lat);
                var marker = new BMap.Marker(point);  // 创建标注
                smap.addOverlay(marker);

                map_address(point);

            });
        }

        var map_address = function (point) {
            var gc = new BMap.Geocoder();//地址解析类
            gc.getLocation(point, function(rs){
                $("#fprovince").val(rs.addressComponents.province);
                $("#fcity").val(rs.addressComponents.city);
                $("#fcountry").val(rs.addressComponents.district);
                $("#fstreet").val(rs.addressComponents.street);
                $("#flongitude").val(point.lng);
                $("#flatitude").val(point.lat);
            });
        }



        var mapAddOverlay = function (longitude, latitude, data) {
            var point = new BMap.Point(longitude, latitude);
            var marker = new BMap.Marker(point);  // 创建标注
            map.addOverlay(marker);              // 将标注添加到地图中
            map.panTo(point);

            if (data != null)
                infoWindow(marker, data);
        }

        //设置添加门店按钮是否可用
        var addEnable = function () {
            table.buttons(['.add']).enable(fempId(treeId,table)!=null);
        }

        //设置编辑门店按钮是否可用
        function editEnable() {
            var count = table.rows({selected: true}).count();
            table.buttons(['.edit']).enable(count > 0);
        }

        //modal关闭时数据清空
        $("#storeinfo").on("hidden.bs.modal", function () {
            smap.clearOverlays();
            $(".fileinput-remove-button").trigger('click')
            $("#storeInfoForm").find(".layui-input").val("");
        });

        //信息窗口
        function infoWindow(element, data) {

            var attrs = new Array();
            attrs.push({"name":"地址","value":data.faddress})
            attrs.push({"name":"负责人","value":data.fcontracts})
            attrs.push({"name":"地址","value":data.ftelephone})
            if(data.employee)
                attrs.push({"name":"负责业代","value":data.employee.fname});
            var obj = {"title":data.ffullname,"attrs":attrs};

            mapWindow(element,obj);
        }

        //表格单行选择事件 单点地图标注
        function rowselect() {
            addEnable();
            editEnable();

            map.clearOverlays();
            var data = table.rows('.selected').data()[0];

            mapAddOverlay(data.flongitude, data.flatitude, data);
        }

        layui.use(['layer', 'form'], function () {
             layer = layui.layer
                , form = layui.form();

            form.verify({
                map: function(){
                    if($("#flongitude").val()==""||$("#flatitude").val()==""){
                        return '请在地图中标注出门店的位置！';
                    }
                }
            })

            form.on('submit(storeInfoForm)', function (data) {
                ajaxForm("#storeInfoForm",function () {
                    $("#storeinfo").modal('hide');
                    table.ajax.reload();
                });
                return false;
            });

        });


        mapClick();

        /*
         *   地图关键字搜索
         */
        function G(id) {
            return document.getElementById(id);
        }


        var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
            {"input" : "suggestId"
                ,"location" : smap
            });

        ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
            var str = "";
            var _value = e.fromitem.value;
            var value = "";
            if (e.fromitem.index > -1) {
                value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            }
            str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

            value = "";
            if (e.toitem.index > -1) {
                _value = e.toitem.value;
                value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            }
            str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
            G("searchResultPanel").innerHTML = str;
        });

        var myValue;
        ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
            var _value = e.item.value;
            myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;

            setPlace();
        });

        function setPlace(){
            smap.clearOverlays();    //清除地图上所有覆盖物
            function myFun(){
                var point = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
                smap.centerAndZoom(point, 18);
                // smap.addOverlay(new BMap.Marker(point));    //添加标注
                //
                // console.log(point);
                map_address(point);

                var marker = new BMap.Marker(point);  // 创建标注
                smap.addOverlay(marker);
            }
            var local = new BMap.LocalSearch(smap, { //智能搜索
                onSearchComplete: myFun
            });
            local.search(myValue);
        }

        /*
         *   地图关键字搜索 end!
         */
    }

});