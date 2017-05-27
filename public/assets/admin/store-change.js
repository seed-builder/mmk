/**
 * Created by john on 2017-01-11.
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');

    exports.index = function ($, tableId,empTableId) {


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
                {"data": "id"},
                {"data": "fnumber"},
                {"data": "ffullname"},
                // {"data": "fshortname"},
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
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    },
                    'searchable': false,
                    'sortable': false
                }
            ],
            select: {
                'style': 'multi'
            },
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
            ]
        });

        var empTable = $("#" + empTableId).DataTable({
            dom: "lBrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: {
                url : '/admin/employee/pagination',
            },
            columns: [
                {"data": "id"},
                {"data": "fname"},
                {"data": "fnumber"},
                {
                    "data": 'fdept_id',
                    render: function ( data, type, full ) {
                        return full.dept_name;
                    }
                },
                {
                    "data": 'fpost_id',
                    render: function ( data, type, full ) {
                        return full.position_name;
                    }
                },
                {"data": "fphone"},
                {"data": "femail"},

            ],
            buttons: [
                { text: '<i class="fa fa-fw fa-exchange"></i>门店调换', action: function () {
                    var row = table.rows('.selected').data();

                    var store_ids = new Array();
                    for (var i = 0; i < row.length; i++) {
                        store_ids.push(row[i].id);
                    }

                    if (store_ids==''){
                        layer.alert('请选择门店！');
                        return
                    }

                    var row = empTable.rows('.selected').data()[0];
                    if(!row){
                        layer.alert('请选择员工！');
                        return
                    }
                    var user_id = row.id;
                    layer.confirm('确定将所选门店分配给该员工？',function () {
                        ajaxPost('/admin/store/store-exchange',{
                            'store_ids' : store_ids,
                            'user_id' : user_id
                        },function () {
                            table.ajax.reload();
                        })
                    })

                }  },
            ]
        });

    }

});