/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,treeId,employees) {

        var nodeData;
        //组织结构初始化
        var getTreeData = function () {
            $.ajax({
                url: "../../admin/department/departmentTree",
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
                            treeNodeSelect(treeId,table);
                            nodeData = data;

                        },
                        onNodeUnselected: function(event, data) {
                            treeNodeSelect(treeId,table);
                        },
                    });
                },
            });
        }

        getTreeData();

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/kpi',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/kpi/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/kpi/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                // {'label': '年份', 'name': 'fyear',},
                // { 'label': '指标类型', 'name': 'ftype', 'type': 'select', 'options': [
                //     // {label: '自动出库', value: 'A'},
                //     {label: '目标拜访量', value: 0},
                //     {label: '目标销售额', value: 1}
                // ] ,
                //     def: 0
                // },
                {'label': '1月', 'name': 'fjan',},
                {'label': '2月', 'name': 'feb',},
                {'label': '3月', 'name': 'fmar',},
                {'label': '4月', 'name': 'fapr',},
                {'label': '5月', 'name': 'fmay',},
                {'label': '6月', 'name': 'fjun',},
                {'label': '7月', 'name': 'fjul',},
                {'label': '8月', 'name': 'faug',},
                {'label': '9月', 'name': 'fsep',},
                {'label': '10月', 'name': 'foct',},
                {'label': '11月', 'name': 'fnov',},
                {'label': '12月', 'name': 'fdec',},

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
                url : '/admin/kpi/pagination'
            },
            columns: [
                {'data': 'id'},
                {
                    'data': 'femp_id',
                    render: function (data, type, full) {
                        if (full.employee != null)
                            return full.employee.fname
                        else
                            return "无";
                    }
                },
                {
                    'data': 'femp_id',
                    render: function (data, type, full) {
                        if (full.employee != null)
                            return full.employee.fphone
                        else
                            return "无";
                    }
                },
                {
                    'data': 'ftype',
                    render: function (data, type, full) {
                        return data==1?'目标销售额':'目标拜访量'
                    }
                },
                {'data': 'fyear'},
                {'data': 'fjan'},
                {'data': 'feb'},
                {'data': 'fmar'},
                {'data': 'fapr'},
                {'data': 'fmay'},
                {'data': 'fjun'},
                {'data': 'fjul'},
                {'data': 'faug'},
                {'data': 'fsep'},
                {'data': 'foct'},
                {'data': 'fnov'},
                {'data': 'fdec'},

            ],
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
            ],

            buttons: [
                { text: '新增<i class="fa fa-fw fa-plus"></i>', action: function () {
                    if (!nodeData){
                        layer.alert('请先在左边的部门架构中选择一个部门！');
                        return
                    }

                    ajaxGetData('/admin/employee/employees?fdept_id='+nodeData.dataid,function (data) {
                        var html = "";
                        for (i in data){
                            html+="<option value='"+data[i].id+"'>"+data[i].fname+"</option>"
                        }
                        $("#femp_list").html(html);
                        $("#femp_list").selectpicker('refresh');
                    })
                    $("#kpi-modal").modal('show');

                }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                {extend: 'colvis', text: '列显示'}
            ]
        });

        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

        $(".form-select").selectpicker();

        $('.year').datepicker({
            format: "yyyy",
            language: 'zh-CN',
            showMeridian: true,
            autoclose: true,
            startView: 2,
            maxViewMode : 'years',
            minViewMode : 'years',
            pickerPosition: "bottom-left",
        });
        
        $("#kpi-form").on('submit',function () {
            layer.confirm('若所选员工之前已有设置过的业绩将会被覆盖，确认操作？',function () {
                ajaxForm("#kpi-form",function () {
                    table.ajax.reload();
                    $("#kpi-modal").modal('hide');

                    layer.closeAll();
                })
            })


            return false;
        })

        $('#kpi-modal').on('hide.bs.modal', function () {
            $("#kpi-form")[0].reset();
        })
    }

});