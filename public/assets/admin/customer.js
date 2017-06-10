/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId, mapId) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/customer',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/customer/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/customer/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': '客户名称', 'name': 'fname',},
                {'label': '客户简称', 'name': 'fshort_name',},
                {'label': '通讯地址', 'name': 'faddress',},
                {'label': '联系电话', 'name': 'ftel',},
                {'label': '库存地址', 'name': 'fstock_address',},
                {'label': '盘点位置范围(米)', 'name': 'fcheck_limit',},

                // {'label': '地区', 'name': 'farea',},
                // {'label': '经营模式', 'name': 'fbusiness_mode',},
                // {'label': '城市', 'name': 'fcity',},
                // {'label': '公司性质', 'name': 'fcompany_nature',},
                // {'label': '公司规模', 'name': 'fcompany_scale',},
                // {'label': '国家', 'name': 'fcountry',},
                // {'label': '客户类别', 'name': 'fcust_type_id',},
                // {'label': '折扣表', 'name': 'fdiscount_list_id',},
                // {'label': '传真', 'name': 'ffax',},
                // {'label': '客户分组', 'name': 'fgroup',},
                // {'label': '发票类型', 'name': 'finvoice_type',},
                // {'label': '运输方式', 'name': 'fmode_transport',},
                //
                // {'label': '价目表', 'name': 'fprice_list_id',},
                // {'label': '省份', 'name': 'fprovince',},
                // {'label': '所属服务处', 'name': 'fsale_depart',},
                // {'label': '销售员', 'name': 'fseller',},
                // {'label': '所属营业部', 'name': 'fservice_depart',},
                //
                // {'label': '默认税率', 'name': 'ftax_rate',},
                // {'label': '纳税登记号', 'name': 'ftax_register_code',},
                // {'label': '税分类', 'name': 'ftax_type',},
                //
                // {'label': '结算币别', 'name': 'ftrading_curr_id',},
                // {'label': '公司网址', 'name': 'fwebsite',},
                // {'label': '邮政编码', 'name': 'fzip',},

            ]
        });

        var table = $("#" + tableId).DataTable({
            dom: "lBrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
                url: '/admin/customer/pagination'
            },
            columns: [
                {'data': 'id'},
                {'data': 'fname'},
                {'data': 'faddress'},
                {'data': 'ftel'},
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
                {'data': 'flongitude'},
                {'data': 'flatitude'},
                {'data': 'fstock_address'},
                {'data': 'fcheck_limit'},
                {
                    "data": "login_name",
                    render: function (data, type, full) {
                        if (full.fdocument_status == 'C') {
                            return '<a href="/admin/customer/' + full.id + '/open" data-target="#customerInfo" data-toggle="modal">登陆信息</a> &nbsp;&nbsp;';
                        }
                        return '';
                    }
                },
            ],
            columnDefs: [
                {
                    "targets": [6,7],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", className: 'edit', text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {text: '审核<i class="fa fa-fw fa-paperclip"></i>', className: 'check', enabled: false},
                {text: '反审核<i class="fa fa-fw fa-unlink"></i>', className: 'uncheck', enabled: false},
                {
                    text: '禁用<i class="fa fa-fw fa-ban"></i>',
                    className: 'btnForbid',
                    enabled: false,
                    action: function () {
                        var token = $('meta[name=_token]').attr('content');
                        var curData = table.rows({selected: true}).data()[0];
                        var id = curData.id;
                        var entity = [];
                        entity[0] = {'fforbid_status': 'B'};
                        console.log(entity);
                        layer.confirm('确定禁用该客户的后台管理功能 ?', {icon: 3, title: '提示'}, function () {
                            $.post('/admin/customer/' + id, {
                                data: entity,
                                _method: 'PUT',
                                _token: token
                            }, function (result) {
                                if (result.data) {
                                    // You can reload the current location
                                    layer.msg('禁用成功！');
                                    table.ajax.reload();
                                } else {
                                    layer.msg('禁用失败！');
                                }
                            }, 'json');
                        });
                    }
                },
                {
                    text: '启用<i class="fa fa-fw fa-check"></i>',
                    className: 'btnNoForbid',
                    enabled: false,
                    action: function () {
                        var token = $('meta[name=_token]').attr('content');
                        var curData = table.rows({selected: true}).data()[0];
                        var id = curData.id;
                        var entity = [];
                        entity[0] = {'fforbid_status': 'A'};
                        console.log(entity);
                        layer.confirm('确定启用该客户的后台管理功能 ?', {icon: 3, title: '提示'}, function () {
                            $.post('/admin/customer/' + id, {
                                data: entity,
                                _method: 'PUT',
                                _token: token
                            }, function (result) {
                                if (result.data) {
                                    // You can reload the current location
                                    layer.msg('启用成功！');
                                    table.ajax.reload();
                                } else {
                                    layer.msg('启用失败！');
                                }
                            }, 'json');
                        });
                    }
                },
                { text: '重置位置信息', action: function () {
                    var curData = table.rows({selected: true}).data()[0];
                    var id = curData.id;

                    ajaxLink('/admin/customer/reset-location/' + id,function () {
                        table.ajax.reload()
                    })
                }  },
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},

                //{extend: 'colvis', text: '列显示'}
            ]
        });

        var map = new BMap.Map(mapId, {enableMapClick: false});
        map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
        map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用

        var params = {
            'zoom': 17,
        }
        mapInit(map,params);

        table.on('select', rowSelect).on('deselect', rowSelect);
        function rowSelect() {
            checkEditEnabble(table, ['.edit', '.check'], ['.uncheck']);
            //table.ajax.reload();
            var curData = table.rows({selected: true}).data()[0];
            if (curData) {
                if (curData.fforbid_status == 'A') {
                    table.buttons(['.btnForbid']).enable(true);
                    table.buttons(['.btnNoForbid']).enable(false);
                } else {
                    table.buttons(['.btnForbid']).enable(false);
                    table.buttons(['.btnNoForbid']).enable(true);
                }
            } else {
                table.buttons(['.btnForbid']).enable(false);
                table.buttons(['.btnNoForbid']).enable(false);
            }

            map.clearOverlays();
            mapAddOverlay(curData);
        }


        //审核
        $(".check").on('click', function () {
            dataCheck(table, '/admin/customer/check');
        })

        $(".uncheck").on('click', function () {
            dataCheck(table, '/admin/customer/uncheck');
        })




        table.on('xhr', function () {
            map.clearOverlays();
            var data = table.ajax.json();
            for (var i = 0; i < data['data'].length; i++) {
                var item = data['data'][i];

                mapAddOverlay(item);
            }
        });

        var mapAddOverlay = function (data) {
            if (!data)
                return ;
            if (data.flongitude==null||data.flatitude==null)
                return ;

            var point = new BMap.Point(data.flongitude, data.flatitude);
            var marker = new BMap.Marker(point);  // 创建标注
            map.addOverlay(marker);              // 将标注添加到地图中
            map.addOverlay(new BMap.Circle(point,data.fcheck_limit,{fillColor:"blue", strokeWeight: 1 ,fillOpacity: 0.3, strokeOpacity: 0.3}))
            map.panTo(point);

            if (data != null)
                infoWindow(marker, data);
        }

        function infoWindow(element, data) {

            var attrs = new Array();
            var limit = data.fcheck_limit==0 ? '未设置' : data.fcheck_limit+'米内'
            attrs.push({"name":"库存地址","value":data.fstock_address});
            attrs.push({"name":"盘点距离","value":limit});
            var obj = {"title":data.fname,"attrs":attrs};

            mapWindow(element,obj);
        }


        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

    }

});