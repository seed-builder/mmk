/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,treeId) {

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
                        },
                        onNodeUnselected: function(event, data) {
                            table.ajax.reload();
                        },
                    });
                },
            });
        }

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/position',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/position/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/position/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                { 'label':  '职位名称', 'name': 'fname', },
                { 'label':  '职位编号', 'name': 'fnumber', },
                { 'label':  '上级', 'name': 'fparpost_id', },
                { 'label':  '所属部门', 'name': 'fdept_id', },
                { 'label':  '备注', 'name': 'fremark', },
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
                url : '/admin/position/pagination',
                data : function (data) {
                    var selectedNode = $('#'+treeId).treeview('getSelected');
                    data['nodeid'] = selectedNode.length>0?selectedNode[0]['dataid']:'';
                }
            },
            columns: [
                {  'data': 'id' },
                {  'data': 'fnumber' },
                {  'data': 'fname' },
                {
                    'data': 'fparpost_id',
                    render: function ( data, type, full ) {
                        if(full.senior!=null)
                            return full.senior.fname
                        else
                            return "无";
                    }
                },
                {
                    'data': 'fdept_id',
                    render: function ( data, type, full ) {
                        if(full.department!=null)
                            return full.department.fname
                        else
                            return "";
                    }
                },
                {'data': 'fremark'}
            ],
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
            ],
            buttons: [
                { text: '新增<i class="fa fa-fw fa-plus"></i>', action: function () {
                    $("#positionModal").modal('show')
                    $("#positionForm").attr('data-action','add');
                }  },
                { text: '编辑<i class="fa fa-fw fa-pencil"></i>', className: 'edit', enabled: false ,action:function () {
                    var data = table.rows('.selected').data()[0];

                    $("#positionForm").find('.form-control').each(function (index, element){
                        var name = $(element).attr('name');
                        $(element).val(eval("data."+name));
                        $(element).find("option[value='"+eval("data."+name)+"']").attr("selected",true);
                    })

                    $("#positionModal").modal('show')
                    $("#positionForm").attr('data-action','edit');
                }},
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        $("#positionForm").on('submit', function () {
            var formData = new FormData($("#positionForm")[0]);
            var action = $("#positionForm").data('action');
            var url = "";


            if (action=='add'){
                url= "/admin/position/createPos"
            }else {
                var id = table.rows('.selected').data()[0].id
                url= "/admin/position/updatePos/"+id
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
                        $("#positionForm").modal('hide');
                        table.ajax.reload();
                    }

                },
            });

            return false;//防止表单同步提交
        })

        $("#positionModal").on("hidden.bs.modal", function () {
            $("#positionForm").find(".form-data").val("");
        });

        table.on( 'select', checkBtn).on( 'deselect', checkBtn);

        function checkBtn(e, dt, type, indexes) {
            var count = table.rows( { selected: true } ).count();
            table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        }

        getTreeData();
    }

});