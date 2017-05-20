/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId, treeId, childTableId, mapId) {

        //组织结构初始化
        var getTreeData = function () {
            $.ajax({
                url: "/admin/employee/employeeTree",
                type: "POST",
                data: {'_token': $('meta[name="_token"]').attr('content')},
                dataType: 'json',
                success: function (data) {
                    $("#" + treeId).treeview({
                        color: "#428bca",
                        enableLinks: true,
                        levels: 99,
                        data: data,
                        onNodeSelected: function (event, data) {
                            makeLineEnable();
                            treeNodeSelect(treeId,table);
                            treeNodeSelect(treeId,childTable);

                        },
                        onNodeUnselected: function (event, data) {
                            //table.buttons( ['.makeAllLine'] ).enable(false);
                            makeLineEnable();
                            treeNodeUnSelect(treeId,table);
                            treeNodeUnSelect(treeId,childTable);
                        },
                    });
                },
            });
        }

        //地图初始化
        var map = new BMap.Map(mapId);

        var params = {
            'zoom': 14,
            'location': '厦门'
        }
        mapInit(map, params);

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
                {'label': 'fcreate_date', 'name': 'fcreate_date',},
                {'label': 'fcreator_id', 'name': 'fcreator_id',},
                {'label': 'fdocument_status', 'name': 'fdocument_status',},
                {'label': 'femp_id', 'name': 'femp_id',},
                {'label': 'fline_id', 'name': 'fline_id',},
                {'label': 'fmodify_date', 'name': 'fmodify_date',},
                {'label': 'fmodify_id', 'name': 'fmodify_id',},
                {'label': 'fstore_id', 'name': 'fstore_id',},
                {'label': 'fweek_day', 'name': 'fweek_day',},
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
                url: '/admin/visit-line-store/pagination',
                data: function (data) {
                    data['init_filter'] = {
                        'distinct' : ['fline_id', 'femp_id']
                    }
                }
            },
            columns: [
                {'data': 'fline_id'},
                {
                    "data": 'fline_id',
                    render: function (data, type, full) {
                        if (full.line != null)
                            return full.line.fnumber
                        else
                            return "";
                    }
                },
                {
                    "data": 'femp_id',
                    render: function (data, type, full) {
                        if (full.line != null)
                            return full.employee.fname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fline_id',
                    render: function (data, type, full) {
                        if (full.line != null)
                            return full.line.fname
                        else
                            return "";
                    }
                },
                {
                    "data": 'femp_id',
                    render: function (data, type, full) {
                        if (full.employee.department != null)
                            return full.employee.department.fname
                        else
                            return "";
                    }
                },
                {
                    "data": 'femp_id',
                    render: function (data, type, full) {
                        if (full.line != null)
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

        var childTable = $("#" + childTableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
                url: '/admin/visit-line-store/pagination',

            },
            columns: [
                {"data": "id"},
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.ffullname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.fshortname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.faddress
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.fcontracts
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.ftelephone
                        else
                            return "";
                    }
                },
                {
                    "data": 'femp_id',
                    render: function (data, type, full) {
                        if (full.employee != null)
                            return full.employee.fname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fline_id',
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        return '<a href="/admin/store/storeInfo/'+data+'" title="查看详情" data-target="#storeDetail" data-toggle="modal"><i class="fa fa-fw fa-search"></i></a>';
                    }
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
            scrollCollapse: true,
            searching: false,
            paging: true,
            rowId: "id",
            ajax: {
                url: '/admin/store/pagination',
                data: function (data) {
                    // data.columns[5]['search']['value'] = fempId(treeId,table);
                    data['femp_id'] = fempId(treeId,table);
                    data['fname'] = $("#fname").val();
                    data['faddress'] = $("#faddress").val();
                    data['is_allot'] = $("#is_allot").val();
                    data['fnumber'] = $("#fnumber").val();
                    data['fline_id'] = table.rows('.selected').data()[0] != null ? table.rows('.selected').data()[0].fline_id : '';
                }
            },
            columns: [
                {"data": "id"},
                {"data": "ffullname"},
                {"data": "faddress"},
                {"data": "fcontracts"},
                {
                    "data": 'femp_id',
                    render: function (data, type, full) {
                        if (full.employee != null)
                            return full.employee.fname
                        else
                            return "";
                    }
                },
                {"data": "ftelephone"},


            ],
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
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
            searching: false,
            paging: true,
            rowId: "id",
            ajax: {
                url: '/admin/visit_line_store/pagination',
                data: function (data) {
                    data['init_filter'] = {
                        'femp_id' : fempId(treeId,table),
                        'fline_id' : table.rows('.selected').data()[0] != null ? table.rows('.selected').data()[0].fline_id : ''
                    }
                }
            },
            columns: [
                {"data": "id"},
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.ffullname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.faddress
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.fcontracts
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.ftelephone
                        else
                            return "";
                    }
                },
                {
                    "data": 'femp_id',
                    render: function (data, type, full) {
                        if (full.employee != null)
                            return full.employee.fname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fline_id',
                    render: function (data, type, full) {
                        if (full.line != null)
                            return full.line.fname
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
                    text: '显示线路<i class="fa fa-fw fa-search"></i>', action: function () {
                    map.clearOverlays();
                    $("#map_select_id").val("")
                    var datas = allotTable.rows().data();

                    for (var index = 0; index < datas.length; index++) {
                        if (datas[index].store != null) {
                            mapAddOverlay(datas[index].store.flongitude, datas[index].store.flatitude, datas[index].store);
                        }
                    }
                    line(datas)
                }
                },
                {
                    text: '删除<i class="fa fa-fw fa-trash"></i>', action: function () {
                    if (allotTable.rows('.selected').data().length == 0) {
                        layer.alert('请先选择要删除的门店！');
                        return;
                    }
                    layer.confirm('确定删除？', function () {
                        var load = layer.load(1);
                        ajaxLink("/admin/visit_line_store/destroy/" + allotTable.rows('.selected').data()[0].id,function () {
                            readyTable.ajax.reload();
                            allotTable.ajax.reload();
                            layer.close(load);
                        })

                    });

                }
                },
                {
                    text: '重置<i class="fa fa-fw fa-exchange"></i>', action: function () {
                    var ids = new Array();

                    var data = allotTable.rows().data();
                    for (var i = 0; i < data.length; i++) {
                        ids.push(data[i].id);
                    }

                    layer.confirm('确定重置当前线路上所有门店吗！', function () {
                        var load = layer.load(1);


                        $.ajax({
                            type: "POST",
                            url: "/admin/visit_line_store/destroyAll",
                            dataType: "json",
                            data: {
                                "ids": ids,
                                "_token": $('meta[name="_token"]').attr('content')
                            },
                            success: function (data) {
                                readyTable.ajax.reload();
                                allotTable.ajax.reload();
                                layer.closeAll();
                            }
                        })
                    });

                }
                },
            ]
        });

        //线路门店互调 --- 线路已分配门店列表
        var lineStoreTable = $("#lineStoreTable").DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            searching: true,
            paging: true,
            rowId: "id",
            ajax: {
                url: '/admin/visit_line_store/pagination',
                data: function (data) {
                    data.columns[1]['search']['value'] = fempId(treeId,table);
                    data.columns[2]['search']['value'] = table.rows('.selected').data()[0] != null ? table.rows('.selected').data()[0].fline_id : '';
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
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.ffullname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.fshortname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store != null)
                            return full.store.faddress
                        else
                            return "";
                    }
                },
                {
                    "data": 'fstore_id',
                    render: function (data, type, full) {
                        if (full.store.channel)
                            return full.store.channel.fname
                        else
                            return "";
                    }
                },


            ],
            columnDefs: [
                {
                    "targets": [0, 1, 2],
                    "visible": false
                }
            ],
            buttons: []
        });

        //预分配门店 表格查询按钮
        $("#tQueryBtn").on('click', function () {
            readyTable.ajax.reload();
        });

        //预分配门店 表格添加按钮
        $("#tAddBtn").on('click', function () {

            var is_allot = $("#is_allot").find('option:selected').val();

            if (readyTable.rows('.selected').data().length == 0) {
                layer.alert('请先选择要添加的门店！');
                return;
            }

            if (is_allot == 1) {
                layer.confirm('该门店已在其他线路中分配，确定继续？', function () {
                    var load = layer.load(1);
                    layer.close(load)
                    addAllotStore(readyTable.rows('.selected').data()[0].id);
                });
            } else {

                addAllotStore(readyTable.rows('.selected').data()[0].id);
            }

        });

        //预分配门店 地图查询按钮
        $("#mQueryBtn").on('click', function () {
            mapQuery();
        })

        //预分配门店 地图添加按钮
        $("#mAddBtn").on('click', function () {
            addAllotStore($("#map_select_id").val());
        })

        //设置生成员工路线按钮是否可用
        var makeLineEnable = function () {
            table.buttons(['.makeAllLine']).enable(fempId(treeId,table) != null);
        }

        //添加门店至已分配门店列表方法
        var addAllotStore = function (store_id) {
            $.ajax({
                type: "POST",
                url: "/admin/visit_line_store",
                data: {
                    "action": "create",
                    "data[0][fline_id]": table.rows('.selected').data()[0].fline_id,
                    "data[0][fstore_id]": store_id,
                    "data[0][femp_id]": fempId(treeId,table),
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    $("#map_select_id").val("")//将地图所选id清空
                    map.clearOverlays();
                    readyTable.ajax.reload();
                    allotTable.ajax.reload();
                    layer.closeAll();
                }
            })
        }

        //地图查询方法
        var mapQuery = function () {
            map.clearOverlays();

            $.ajax({
                type: "GET",
                url: "/admin/store/query",
                dataType: "json",
                data: {
                    "fprovince": $("#province_id").find("option:selected").text(),
                    "fcity": $("#city_id").find("option:selected").text(),
                    "fcountry": $("#country_id").find("option:selected").text(),
                    "femp_id": fempId(treeId,table),
                    'fline_id': table.rows('.selected').data()[0] != null ? table.rows('.selected').data()[0].fline_id : '',
                    "_token": $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    if (data.length==0){
                        layer.msg("当前人员在该区域内没有所负责的门店！")
                        return ;
                    }
                    for (index in data) {
                        data[index]['selectable'] = true;
                        mapAddOverlay(data[index]['flongitude'], data[index]['flatitude'], data[index]);
                    }

                }
            })
        }

        //地点连线
        function line(datas) {

            var arr = new Array();
            for (var index = 0; index < datas.length; index++) {
                var point = new BMap.Point(datas[index].store.flongitude, datas[index].store.flatitude)
                arr.push(point)
            }
            var polyline = new BMap.Polyline(arr, {strokeColor: "blue", strokeWeight: 6, strokeOpacity: 0.5});
            map.addOverlay(polyline);

        }

        //窗口关闭时清除地图标注
        $('#storeAdjust').on('hide.bs.modal', function () {
            map.clearOverlays();
            $("#map_select_id").val("")
        })


        //城市区域联动
        $("#province_id").on('change', function () {
            regionFun($("#province_id").val(),"#city_id",function () {
                $("#city_id").trigger('change');
            });
        })

        $("#city_id").on('change', function () {
            regionFun($("#city_id").val(),"#country_id",function () {
                $("#country_id").trigger('change')
            });
        })

        $("#country_id").on('change', function () {
            map.centerAndZoom($("#country_id").find("option:selected").text(), params['zoom']);
        })

        //地图标注方法
        var mapAddOverlay = function (longitude, latitude, data) {
            var point = new BMap.Point(longitude, latitude);
            var marker = new BMap.Marker(point);  // 创建标注

            map.addOverlay(marker);              // 将标注添加到地图中
            map.panTo(point);

            infoWindow(marker, data);
        }

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
                if (data['selectable'] == true) {
                    $("#map_select_id").val(data.id);//store_id
                }
            });
        }


        table.on('select', checkBtn).on('deselect', checkBtn);
        table.on('select', reloadChildTable);

        function checkBtn(e, dt, type, indexes) {
            var count = table.rows({selected: true}).count();
            table.buttons(['.storeAdjust', '.lineAdjust']).enable(count > 0);
            makeLineEnable();
        }

        function reloadChildTable() {
            var selected_emp_id = fempId(treeId,table)
            childTable.columns(6).search(fempId(treeId,table))
                .columns(7).search(table.rows('.selected').data()[0].fline_id)
                .draw();
        }

        //线路门店互调 数据展示 方法
        var intermodulation = function () {
            var femp = table.rows('.selected').data()[0].employee.fname;
            var fdept = table.rows('.selected').data()[0].employee.department.fname;
            $("input[class='form-control fdept']").val(femp)
            $("input[class='form-control femp']").val(fdept)

            tongzu();
            kauzu();
        }


        //线路门店互调 同组业代
        var tongzu = function () {
            var fdept_id = table.rows('.selected').data()[0] != null ? table.rows('.selected').data()[0].employee.fdept_id : '';
            getEmployees(fdept_id,'#form2')
        }

        //线路门店互调 跨组业代
        var kauzu = function () {
            getEmployees($('#form3').find(".fdept").val(),'#form3')
        }
        
        var getEmployees = function (fdept_id,form_id) {

            ajaxGetData("/admin/employee/employees?fdept_id="+fdept_id,function (data) {
                var html = "";

                for (index in data) {
                    html += '<option value="' + data[index].id + '">' + data[index].fname + '</option>'
                }
                

                $(form_id).find("select[name='femp_id']").html(html);
            })
        }

        //线路门店互调 保存按钮
        $("#imlSaveBtn").on('click', function () {
            var active = $(".tab-content").find(".active").attr("id")
            if (active=="emp_current"){
                var femp_id = fempId(treeId,table)
            }else {
                var femp_id = $(".tab-content").find(".active").find(".femp").val();
            }


            if (femp_id == null) {
                layer.alert('请选择一个员工！');
                return;
            }

            var selected = lineStoreTable.rows('.selected').data();
            if (selected.length == 0) {
                layer.alert('请在左边列表中选中门店！');
                return;
            }

            var ids = new Array();
            for (var i = 0; i < selected.length; i++) {
                ids.push(selected[i].id);
            }

            var form = $(".tab-content").find(".active").find(".adjustForm");
            form.append("<input type='hidden' name='ids' value='"+ids+"' />");
            ajaxForm('#'+form.attr('id'),function () {
                table.ajax.reload();
                $('#lineAdjust').modal('hide')
            })

        })

        //线路门店互调 选择部门
        $(".fdept").on('change', function () {
            kauzu();
        })

        $("#province_id").trigger('change');

        getTreeData();

    }

});