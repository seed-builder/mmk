/**
 * Created by john on 2017-01-11.
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');

    exports.index = function ($, tableId, treeId, mapId, smapId) {

        //表格初始化
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
            ajax: {
                url : '/admin/store/pagination',
                data : function (data) {
                    var treeNode = $('#'+treeId).treeview('getSelected');
                    if (treeNode.length>0){
                        data.columns[6]['search']['value'] = treeNode[0].dataid;
                    }

                }
            },
            columns: [
                {"data": "id"},
                {"data": "ffullname"},
                {"data": "fshortname"},
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

            ],
            columnDefs: [
                {
                    "targets": [7, 8],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {
                    text: '新增<i class="fa fa-fw fa-plus"></i>',
                    className: 'add',
                    enabled: false,
                    action: function () {
                        var treeNode = $('#' + treeId).treeview('getSelected');

                        $("#femp_id").val(treeNode[0].dataid);
                        $("#storeInfoForm").attr('data-action','add')
                        $('#storeinfo').modal('show');
                    }
                },
                {
                    text: '编辑<i class="fa fa-fw fa-pencil"></i>',
                    className: 'edit',
                    enabled: false,
                    action: function () {
                        var id = table.rows('.selected').data()[0].id;
                        $("#storeInfoForm").attr('data-action','edit')
                        $("#store_id").val(id);

                        $.ajax({
                            type: "GET",
                            url: "/admin/store/getStore/" + id,
                            dataType: "json",
                            data: {
                                "_token": $('meta[name="_token"]').attr('content')
                            },
                            success: function (data) {
                                $("#storeInfoForm").find('.form-data').each(function (index, element){
                                    var name = $(element).attr('name');

                                    var c = eval("data."+name);

                                    $(element).val(c);
                                    //$(element).text(c);
                                    $(element).find("option[text='"+c+"']").attr("selected",true);
                                    $(element).find("option[value='"+c+"']").attr("selected",true);

                                    //地图标注
                                    var point = new BMap.Point(data.flongitude, data.flatitude);
                                    var marker = new BMap.Marker(point);  // 创建标注
                                    smap.addOverlay(marker);
                                    smap.panTo(point);
                                });

                                // $("#storeInfoForm").find('select').each(function (index, element){
                                //     var name = $(element).attr('name');
                                //     if (name=='_token'){
                                //         return ;
                                //     }
                                //     var c = eval("data."+name);
                                //
                                //     $(element).find("option[text='"+c+"']").attr("selected",true);
                                //     $(element).find("option[value='"+c+"']").attr("selected",true);
                                // })

                                $("#storeInfoForm").find('textarea').text(data.fremark);

                                //初始化门店图片
                                $('#storepic').fileinput('refresh', {
                                    initialPreview: [ //预览图片的设置
                                        "<img src='" + data.image + "' class='file-preview-image'style='width: 260px;height: 160px'>",
                                    ],
                                });
                            }
                        })

                        $('#storeinfo').modal('show');
                    }
                },
//                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
//                 {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},

                //{extend: 'colvis', text: '列显示'}
            ]
        });

        //组织架构
        var getTreeData = function () {
            $.ajax({
                url: "../../admin/employee/employeeTree",
                type: "POST",
                data: {
                    '_token': $('meta[name="_token"]').attr('content'),
                    'dept_select': true
                },
                dataType: 'json',
                success: function (data) {
                    $("#" + treeId).treeview({
                        color: "#428bca",
                        enableLinks: true,
                        levels: 99,
                        data: data,
                        onNodeSelected: function (event, data) {
                            addEnable();
                            editEnable();
                            // searchtable(data.dataid);
                            table.ajax.reload();
                        },
                        onNodeUnselected: function (event, data) {
                            editEnable();
                            addEnable();
                            table.ajax.reload();
                        },
                        onSearchComplete: function (event, data) {
                            if (JSON.stringify(data) != "{}") {

                            }
                        }
                    });
                },
            });
        }

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
        var mapShow = function () {
            // 百度地图API功能
            map.centerAndZoom(new BMap.Point(), 14);
            map.enableScrollWheelZoom(true);

            smap.centerAndZoom(new BMap.Point(), 13);
            smap.enableScrollWheelZoom(true);

            var geolocation = new BMap.Geolocation();
            geolocation.getCurrentPosition(function (r) {
                if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                    map.panTo(r.point);
                    smap.panTo(r.point);
                }
                else {
                    alert('获取地图失败' + this.getStatus());
                }
            }, {enableHighAccuracy: true})

        }

        //地图点击事件
        var mapClick = function () {
            smap.addEventListener("click", function (e) {
                smap.clearOverlays();
                $("#flongitude").val(e.point.lng);
                $("#flatitude").val(e.point.lat);
                var point = new BMap.Point(e.point.lng, e.point.lat);
                var marker = new BMap.Marker(point);  // 创建标注
                smap.addOverlay(marker);
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
            var count = table.rows({selected: true}).count();
            table.buttons(['.add']).enable(count > 0);
            if (count == 0) {
                var treeNode = $('#' + treeId).treeview('getSelected');
                if (treeNode.length > 0) {
                    table.buttons(['.add']).enable(treeNode[0].nodetype == 'emp');
                }

            }

        }

        //设置编辑门店按钮是否可用
        function editEnable() {
            var count = table.rows({selected: true}).count();
            table.buttons(['.edit']).enable(count > 0);
        }

        var searchtable = function (emp_id) {
            table.columns(6).search(emp_id)
                .draw();
        }

        //门店添加

        $("#storeInfoForm").on('submit', function () {
            var formData = new FormData($("#storeInfoForm")[0]);
            var action = $("#storeInfoForm").data('action');
            var url = "";
            if (action=='add'){
                url= "/admin/store/createStore"
            }else {
                url= "/admin/store/editStore"
            }
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    layer.msg(data['result'])
                    if (data['code'] == 200) {
                        $("#storeinfo").modal('hide');
                        table.ajax.reload();
                    }

                },
            });

            return false;//防止表单同步提交
        })

        //modal关闭时数据清空
        $("#storeinfo").on("hidden.bs.modal", function () {
            // $("#storeinfo").removeData("bs.modal");
            smap.clearOverlays();
            $(".fileinput-remove-button").trigger('click')
            $("#storeInfoForm").find(".form-data").val("");
        });

        //信息窗口
        function infoWindow(element, data) {

            var content = "<h3>" + data.ffullname + "</h3>" +
                "<p>地址：" + data.faddress + "</p>" +
                "<p>负责人人：" + data.fcontracts + "</p>" +
                "<p>电话：" + data.ftelephone + "</p>" +
                "<p>负责业代：" + data.employee.fname + "</p>"

            var infoWindow = new BMap.InfoWindow(content)  // 创建信息窗口对象

            element.addEventListener("click", function () {
                this.openInfoWindow(infoWindow);
            });
        }

        //表格单行选择事件 单点地图标注
        function rowselect() {
            var count = table.rows({selected: true}).count();
            table.buttons(['.edit']).enable(count > 0);

            map.clearOverlays();
            var data = table.rows('.selected').data()[0];

            mapAddOverlay(data.flongitude, data.flatitude, data);
            var point = new BMap.Point(data.flongitude, data.flatitude, data);
            map.panTo(point);

        }


        //城市区域联动
        $("#province_id").on('change', function () {
            $.ajax({
                type: "GET",
                url: "/admin/city/list",
                dataType: "json",
                data: {
                    "parent_id": $("#province_id").val(),
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    var html = "";
                    for (index in data) {
                        html += '<option text="' + data[index].Name + '" value="' + data[index].id + '">' + data[index].Name + '</option>';
                    }

                    $("#city_id").html(html)
                    $("#city_id").trigger('change');
                }
            })

        })

        $("#city_id").on('change', function () {
            $.ajax({
                type: "GET",
                url: "/admin/city/list",
                dataType: "json",
                data: {
                    "parent_id": $("#city_id").val(),
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    var html = "";
                    for (index in data) {
                        html += '<option text="' + data[index].Name + '" value="' + data[index].id + '">' + data[index].Name + '</option>';
                    }
                    $("#country_id").html(html)
                    $("#country_id").trigger('change');
                }
            })
        })

        $("#country_id").on('change', function () {
            $.ajax({
                type: "GET",
                url: "/admin/city/getCity",
                dataType: "json",
                data: {
                    "id": $("#country_id").val(),
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    var point = new BMap.Point(data.lng, data.Lat);
                    smap.panTo(point);
                }
            })
        })

        $("#province_id").trigger('change');
        mapClick();
        getTreeData();
        mapShow();
    }

});