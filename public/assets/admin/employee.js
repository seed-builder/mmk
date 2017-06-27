/**
 * Created by john on 2017-01-11.
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId, treeId, orgs, depts, postions) {

        //组织结构初始化
        var getTreeData = function () {
            $.ajax({
                url: "../../admin/department/departmentTree",
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
                            treeNodeSelect(treeId, table);
                        },
                        onNodeUnselected: function (event, data) {
                            treeNodeSelect(treeId, table);
                        },
                    });
                },
            });
        }

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/employee',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/employee/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/employee/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': '姓名', 'name': 'fname',},
                {'label': '工号', 'name': 'fnumber',},
                {'label': '电话', 'name': 'fphone',},
                {'label': '地址', 'name': 'faddress',},
                {'label': '邮箱', 'name': 'femail',},
                // { 'label': '组织', 'name': 'forg_id', 'type': 'select', 'options': orgs},
                {'label': '部门', 'name': 'fdept_id', 'type': 'select', 'options': depts},
                {'label': '职位', 'name': 'fpost_id', 'type': 'select', 'options': postions},
                // {'label': '设备', 'name': 'device',},
                // {'label': '设备号', 'name': 'device_sn',},
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
                url: '/admin/employee/pagination',
            },
            columns: [
                {"data": "id"},
                {"data": "fname"},
                {"data": "fnumber"},
                {
                    "data": 'fdept_id',
                    render: function (data, type, full) {
                        return full.dept_name;
                    }
                },
                {
                    "data": 'fpost_id',
                    render: function (data, type, full) {
                        return full.position_name;
                    }
                },
                {"data": "fphone"},
                {"data": "femail"},
                {"data": "device"},
                {"data": "device_sn"},
                {
                    "data": "fdocument_status",
                    render: function (data, type, full) {
                        return document_status(data);
                    }
                },
                {"data": "login_time"},
                {"data": "fcreate_date"},
                {
                    "data": "fforbid_status",
                    render: function (data, type, full) {
                        if (data == 'A')
                            return '启用'
                        else
                            return '禁用'
                    }
                },

            ],
            "columnDefs": [
                {
                    "targets": [0, 8, 10, 11, 12],
                    "visible": false,
                    "searchable": false
                },
            ],
            createdRow: function (row, data, dataIndex) {
                if (data.fforbid_status=='B'){
                    $(row).css('color','red')
                }

            },
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", className: 'edit', text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                {text: '审核<i class="fa fa-fw fa-paperclip"></i>', className: 'check', enabled: false},
                {text: '反审核<i class="fa fa-fw fa-unlink"></i>', className: 'uncheck', enabled: false},
                {text: '重置密码<i class="fa fa-fw fa-link"></i>', className: 'reset', enabled: false},
                {text: '重置设备<i class="fa fa-fw fa-mobile"></i>', className: 'reset-device', enabled: false},
                {extend: 'colvis', text: '列显示'}
            ]
        });

        table.on('select', rowSelect).on('deselect', rowSelect);


        function rowSelect() {
            checkEditEnabble(table, ['.check'], ['.uncheck']);
            var count = table.rows({selected: true}).count();
            table.buttons(['.edit', '.reset', '.reset-device']).enable(count > 0);
        }

        //审核
        $(".check").on('click', function () {
            dataCheck(table, '/admin/employee/check');
        })

        $(".uncheck").on('click', function () {
            dataCheck(table, '/admin/employee/uncheck');
        });

        $(".reset").on('click', function () {
            //
            var row = table.rows('.selected').data();
            layer.confirm('确认重置该用户密码?', function () {
                $.post('/admin/employee/reset-pwd/' + row[0].id, {_token: $('meta[name="_token"]').attr('content')}, function (res) {
                    if (res.code == 200) {
                        layer.msg('重置密码成功');
                    }
                });
            });
        });

        $(".reset-device").on('click', function () {
            var row = table.rows('.selected').data();
            layer.confirm('确认重置该用户设备和设备号？', function () {
                $.post('/admin/employee/reset-device/' + row[0].id, {_token: $('meta[name="_token"]').attr('content')}, function (res) {
                    if (res.code == 200) {
                        layer.msg('重置设备成功');
                        table.ajax.reload()
                    }
                });
            });
        })
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

        getTreeData();

    }

});