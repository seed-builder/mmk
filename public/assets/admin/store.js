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
            searching: false,
            ajax: {
                url : '/admin/store/pagination',
            },
            columns: [
                {  "data": "id",render: function (data, type, full) {
                        return '<input type="checkbox" class="editor-active" value="'+data+'">';
                    },
                    className: "dt-body-center"},
                {"data": "flongitude"},
                {"data": "flatitude"},
                {"data": "fnumber"},
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
                {
                    "data": 'fcust_id',
                    render: function (data, type, full) {
                        if (full.customer != null)
                            return full.customer.fname
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
                    "data": 'fchannel',
                    render: function (data, type, full) {
                        if (full.channel != null)
                            return full.channel.fname
                        else
                            return "";
                    }
                },
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
                    "data": "fdocument_status",
                    render: function (data, type, full) {
                       return document_status(data);
                    }
                },
                {
                    "data": "fforbid_status",
                    render: function (data, type, full) {
                        return forbid_status(data);
                    }
                },
                {"data": "fcreate_date"},
                {
                    "data": 'id',
                    render: function (data, type, full) {
                        return '<a href="/admin/store/storeInfo/'+data+'" title="查看详情" data-target="#storeDetail" data-toggle="modal"><i class="fa fa-fw fa-search"></i></a>';
                    }
                },
            ],
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                },
                {
                    "targets": [1,2],
                    "visible": false
                }
            ],
            buttons: [
                {
                    text: '新增<i class="fa fa-fw fa-plus"></i>',
                    className: 'add',
                    enabled: false,
                    action: function () {

                        var femp_id = fempId(treeId,table);
                        if (femp_id==null){
                            layer.msg("请先选择一个业代！")
                            return false;
                        }else {
                            $("#storeInfoForm").attr('action','/admin/store/createStore')
                            $("#femp_id").val(femp_id)
                            $('#storeinfo').modal('show');
                        }

                    }
                },
                {
                    text: '编辑<i class="fa fa-fw fa-pencil"></i>',
                    className: 'edit',
                    enabled: false,
                    action: function () {
                        var id = table.rows('.selected').data()[0].id;
                        $("#storeInfoForm").attr('action','/admin/store/editStore')
                        $("#store_id").val(id);
                        ajaxGetData("/admin/store/getStore/" + id,function (data) {
                            $("#storeInfoForm").find(".layui-input").each(function (index, element){
                                var name = $(element).attr('name');

                                var c = eval("data."+name);

                                $(element).val(c);

                                //地图标注
                                var point = new BMap.Point(data.flongitude, data.flatitude);
                                var marker = new BMap.Marker(point);  // 创建标注
                                smap.addOverlay(marker);
                                smap.panTo(point);
                            });

                            $("#storeInfoForm").find("select").each(function (index, element){
                                var name = $(element).attr('name');

                                var c = eval("data."+name);

                                $(element).val(c);
                                form.render('select')
                            });


                            $("#storeInfoForm").find('textarea').text(data.fremark);

                            //初始化门店图片
                            $('#storepic').fileinput('refresh', {
                                initialPreview: [ //预览图片的设置
                                    "<img src='" + data.image + "' class='file-preview-image'style='width: 260px;height: 160px'>",
                                ],
                            });

                            $('#storeinfo').modal('show');
                        });


                    }
                },
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', className: 'delete', enabled: false, action: function () {
                    layer.confirm("确定删除 ?", ['确定', '取消'], function () {
                        var stores = table.rows({selected: true}).data();
                        var ids = [];
                        for(var i = 0; i < stores.length; i++){
                            ids[ids.length] = stores[i].id;
                        }
                        $.post('/admin/store/batch-remove', { '_token': $('meta[name="_token"]').attr('content'), 'ids': ids }, function (res) {
                            if(res.cancelled == 0){
                                layer.msg('删除成功！');
                                table.ajax.reload();
                            }
                        });
                    })
                }},
                { text: '禁用<i class="fa fa-minus-circle"></i>', className: 'forbidden', enabled: false, action: function () {
                    layer.confirm("确定禁用该项 ?", ['确定', '取消'], function () {
                        var stores = table.rows({selected: true}).data();
                        var ids = [];
                        for(var i = 0; i < stores.length; i++){
                            ids[ids.length] = stores[i].id;
                        }

                        $.post('/admin/store/forbidden', {'_token': $('meta[name="_token"]').attr('content'), 'ids': ids }, function (res) {
                            if(res.cancelled == 0){
                                layer.msg('禁用成功！');
                                table.ajax.reload();
                            }
                        });
                    })
                }},
                { text: '反禁用<i class="fa fa-check-circle"></i>', className: 'unforbidden', enabled: false, action: function () {
                    var data = table.rows({selected: true}).data();
                    layer.confirm("确定反禁用该项 ?", ['确定', '取消'], function () {
                        var stores = table.rows({selected: true}).data();
                        var ids = [];
                        for(var i = 0; i < stores.length; i++){
                            ids[ids.length] = stores[i].id;
                        }
                        $.post('/admin/store/start_use', { '_token': $('meta[name="_token"]').attr('content'), 'ids': ids }, function (res) {
                            if(res.cancelled == 0){
                                layer.msg('反禁用成功！');
                                table.ajax.reload();
                            }
                        });
                    })
                }},
                {
                    text: '更新编码<i class="fa fa-pencil-square-o"></i>',
                    className: 'update-number',
                    enabled: true,
                    action: function () {
                        $.post('/admin/store/update-number',{_token: $('meta[name="_token"]').attr('content')}, function (res) {
                            if(res.cancelled == 0){
                                layer.msg('成功更新了：'+res['data'][0]+'条数据！');
                                table.ajax.reload();
                            }
                        });
                    }
                },
                { text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>', action: function () {
                    exportExcel('#moduleForm','/admin/store/export-excel');
                }  },
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
            ]
        });

        table.on('select', rowselect).on( 'deselect', editEnable);
        //设置编辑门店按钮是否可用
        function editEnable() {
            var data = table.rows({selected: true}).data();
            table.buttons(['.edit', '.delete']).enable(data.length > 0);
            if(data.length > 0){
                var store = data[0];
                table.buttons(['.forbidden']).enable(store.fforbid_status == 'A');
                table.buttons(['.unforbidden']).enable(store.fforbid_status == 'B');
            }else{
                table.buttons(['.forbidden', '.unforbidden']).enable(false);
            }
            checkEditEnabble(table,['.check'],['.uncheck']);
        }

        //审核
        $(".check").on('click',function () {
            dataCheck(table,'/admin/store/check');
        })

        $(".uncheck").on('click',function () {
            dataCheck(table,'/admin/store/uncheck');
        })

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
                            treeNodeSelect(treeId,table);
                        },
                        onNodeUnselected: function (event, data) {
                            editEnable();
                            addEnable();
                            treeNodeSelect(treeId,table);
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


        //modal关闭时数据清空
        $("#storeinfo").on("hidden.bs.modal", function () {
            smap.clearOverlays();
            $(".fileinput-remove-button").trigger('click')
            $("#storeInfoForm").find(".layui-input").val("");
        });

        //信息窗口
        function infoWindow(element, data) {

            var attrs = new Array();
            attrs.push({"name":"地址","value":data.faddress});
            attrs.push({"name":"负责人","value":data.fcontracts});
            attrs.push({"name":"电话","value":data.ftelephone});
            attrs.push({"name":"负责业代","value":data.employee?data.employee.fname:''});
            attrs.push({"name":"所属客户","value":data.customer?data.customer.fname:''});
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
        getTreeData();

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



        //调换门店
        // $("#exchangeForm").on('submit',function () {
        //     layer.confirm('确定将旧员工的所有门店分配给新员工？',function () {
        //         ajaxForm("#exchangeForm",function () {
        //             $("#exchange-modal").modal('hide');
        //         })
        //     })
        //
        //     return false;
        // })

    }

});