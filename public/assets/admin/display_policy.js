/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,childTableId,treeId,depts) {
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
                            table.ajax.reload();
                            chlidTable.ajax.reload();

                        },
                        onNodeUnselected: function(event, data) {
                            table.ajax.reload();
                            chlidTable.ajax.reload();
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
                    url: '/admin/display-policy',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/display-policy/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/display-policy/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': '编号', 'name': 'fbill_no',},
                {'label': '费用类型', 'name': 'fexp_type',},
                {
                    label: '执行开始日期',
                    name:  'fstart_date',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },
                {
                    label: '执行结束日期',
                    name:  'fend_date',
                    type:  'datetime',
                    def:   function () { return new Date(); }
                },
                {
                    'label': '应用区域',
                    'name': 'fcost_dept_id',
                    'type': 'select',
                    'options': depts
                },
                {'label': '总金额', 'name': 'famount',},
                {'label': '项目简述', 'name': 'fsketch',},
                {'label': '执行门店总数', 'name': 'fact_store_num',},
                {'label': '单个门店费用上限', 'name': 'fstore_cost_limit',},
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
                url : '/admin/display-policy/pagination',
                data : function (data) {
                    var selectedNode = $('#'+treeId).treeview('getSelected');
                    data['nodeid'] = selectedNode.length>0?selectedNode[0]['dataid']:'';
                }
            },
            columns: [
                {'data': 'id'},
                {'data': 'fbill_no'},
                {'data': 'fexp_type'},
                {'data': 'fstart_date'},
                {'data': 'fend_date'},
                {
                    'data': 'fcost_dept_id',
                    render: function (data, type, full) {
                        if (full.department != null)
                            return full.department.fname
                        else
                            return "无";
                    }
                },
                {'data': 'famount'},
                {'data': 'fsketch'},
                {'data': 'fact_store_num'},
                {'data': 'fstore_cost_limit'},
                {'data': 'fsign_store_num'},
                {'data': 'fsign_amount'},

            ],
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        table.on( 'select', rowSelect).on( 'deselect', rowSelect);

        function rowSelect() {
            chlidTable.ajax.reload();
        }
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

        var chlidTable = $("#" + childTableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax:
                {
                    url : '/admin/display-policy-store/pagination',
                    data : function (data) {
                        if (table.rows('.selected').data()[0]==null){
                            var selectedNode = $('#'+treeId).treeview('getSelected');
                            data['nodeid'] = selectedNode.length>0?selectedNode[0]['dataid']:'';
                        }
                        data.columns[2]['search']['value'] = table.rows('.selected').data()[0]!=null?table.rows('.selected').data()[0].id:'';
                    }
                },
            columns: [
                {'data': 'id'},
                {'data': 'fbill_no'},
                {
                    'data': 'fpolicy_id',
                    render: function ( data, type, full ) {
                        if(full.policy!=null)
                            return full.policy.fsketch
                        else
                            return "";
                    }
                },
                {
                    'data': 'femp_id',
                    render: function ( data, type, full ) {
                        if(full.employee!=null)
                            return full.employee.fname
                        else
                            return "";
                    }
                },
                {'data': 'fstart_date'},
                {'data': 'fend_date'},
                {
                    'data': 'fcost_dept_id',
                    render: function ( data, type, full ) {
                        if(full.department!=null)
                            return full.department.fname
                        else
                            return "";
                    }
                },
                // {'data': 'famount'},
                // {'data': 'fsketch'},
                {
                    'data': 'fstore_id',
                    render: function ( data, type, full ) {
                        if(full.store!=null)
                            return full.store.ffullname
                        else
                            return "";
                    }
                },
                {'data': 'fsign_amount'},
                {'data': 'fcheck_amount'},
                {'data': 'fcheck_status'},
                {'data': 'fstatus'},
                {'data': 'fdate'},
                {
                    "data": "fdocument_status",
                    render: function ( data, type, full ) {
                        return document_status(data);
                    }
                },

            ],
            columnDefs: [
                {
                    "targets": [0,6],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                // {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                { text: '审核<i class="fa fa-fw fa-paperclip"></i>',className: 'check', enabled: false ,action:function(){
                    var id = chlidTable.rows('.selected').data()[0].id;
                    layer.prompt({title: '请输入核定签约金额', formType: 3}, function(price, index){
                        ajaxLink('/admin/display-policy-store/check?id='+id+'&fcheck_amount='+price,function () {
                            table.ajax.reload();
                            chlidTable.ajax.reload();
                        })
                        layer.close(index);
                    });
                }},
                { text: '反审核<i class="fa fa-fw fa-unlink"></i>',className: 'uncheck', enabled: false },
                //{extend: 'colvis', text: '列显示'}
            ]
        });
        chlidTable.on( 'select', chlidRowSelect).on( 'deselect', chlidRowSelect);

        function chlidRowSelect() {
            checkEditEnabble(chlidTable,['.edit','.check'],['.uncheck']);
        }

        //审核
        // $(".check").on('click',function () {
        //     dataCheck(chlidTable,'/admin/display-policy-store/check',function () {
        //         table.ajax.reload();
        //     });
        //
        // })

        $(".uncheck").on('click',function () {
            dataCheck(chlidTable,'/admin/display-policy-store/uncheck',function () {
                table.ajax.reload();
                chlidTable.ajax.reload();
            });
        })

    }

});