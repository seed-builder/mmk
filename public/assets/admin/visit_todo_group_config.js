/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId,todoTreeId,todoGroupTreeId) {
        var todoCurNodeData;
        var todoGroupCurNodeData;

        var todoTree = function () {
            $.ajax({
                url: "/admin/visit-store-todo/todoTree",
                type: "GET",
                data: {
                    '_token':$('meta[name="_token"]').attr('content')
                },
                dataType:'json',
                success:function(data){
                    $("#" + todoTreeId).treeview({
                        color: "#428bca",
                        enableLinks: true,
                        levels: 99,
                        data: data,
                        onNodeSelected: function(event, data) {
                            todoCurNodeData = data;

                            addTodo();
                        },
                        onNodeUnselected: function(event, data) {
                            todoCurNodeData = null;
                        },
                    });
                },
            });
        }
        
        var addTodo = function () {
            if ($("#todo_group_id").val()==0)
                return

            ajaxLink('/admin/visit-todo-group/addTodo?todo_id='+todoCurNodeData['dataid']+"&group_id="+$("#todo_group_id").val(),function () {
                todoGroupTree();
            })
        }

        $('#btnRemove').click(function () {
            if (!todoGroupCurNodeData) {
                layer.alert('请先选择一个事项!');
                return;
            }

            layer.confirm('确定删除 ' + todoGroupCurNodeData.item['fname']+ ' 及其子事项 ?',function () {
                ajaxLink('/admin/visit-todo-group/removeTodo?todo_id='+todoGroupCurNodeData['dataid']+"&group_id="+$("#todo_group_id").val(),function () {
                    todoGroupTree();
                    layer.closeAll();
                });

            })

        });


        var todoGroupTree = function () {
            $.ajax({
                url: "/admin/visit-todo-group/todoGroupTree",
                type: "GET",
                data: {
                    'id' : $('#todo_group_id').val(),
                    '_token':$('meta[name="_token"]').attr('content')
                },
                dataType:'json',
                success:function(data){
                    $("#" + todoGroupTreeId).treeview({
                        color: "#428bca",
                        enableLinks: true,
                        levels: 99,
                        data: data,
                        onNodeSelected: function(event, data) {
                            todoGroupCurNodeData = data;

                            //addTodo();
                        },
                        onNodeUnselected: function(event, data) {
                            todoGroupCurNodeData = null;
                        },
                    });
                },
            });
        }




        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            searching : false,
            scrollY: "200px",
            scrollCollapse: true,
            ajax: {
                url : '/admin/store/pagination',
            },
            columns: [
                {
                    "data": "id",
                    render: function (data, type, full) {
                        return '<input type="checkbox" class="editor-active" value="'+data+'">';
                    },
                    className: "dt-body-center"
                },
                {"data": "ffullname"},
                {
                    "data": "fcust_id",
                    render: function (data, type, full) {
                        if (full.customer != null)
                            return full.customer.fname
                        else
                            return "";
                    }
                },
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
            ],
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }
            ],
            select: {
                'style': 'multi'
            },
            buttons: [
                { text: '生成拜访日志<i class="fa fa-fw fa-calendar-o"></i>', action: function () {
                    $("#makeCalendarModal").modal('show')
                    $("#group_id").val($("#todo_group_id").val())
                }  },
                { text: '绑定<i class="fa fa-cogs"></i>', action: function () {
                    if ($("#todo_group_id").val()==0){
                        layer.alert('请先选择一个方案');
                        return
                    }
                    var row = table.rows('.selected').data();

                    var ids = new Array();
                    for (var i = 0; i < row.length; i++) {
                        ids.push(row[i].id);
                    }

                    if (ids.length==0){
                        layer.alert('请选择要配置的门店！');
                        return
                    }
                    layer.confirm("确认绑定已选门店至当前方案中？",function () {
                        ajaxLink('/admin/visit-todo-group/makeTodoByGroup?todo_ids='+ids+"&group_id="+$("#todo_group_id").val(),function () {
                            todoTree();
                        })
                    })
                }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
            ]
        });

        todoTree();

        $('.todo_group').selectpicker({});

        $('#todo_group_id').on('change',function () {
            todoGroupTree();
        })

        // $("#btnMakeTodos").on('click',function(){
        //     if ($("#todo_group_id").val()==0){
        //         layer.alert('请先选择一个方案');
        //         return
        //     }
        //
        //     var row = table.rows('.selected').data();
        //
        //     var ids = new Array();
        //     for (var i = 0; i < row.length; i++) {
        //         ids.push(row[i].id);
        //     }
        //
        //     if (ids.length==0){
        //         layer.alert('请选择要配置的门店！');
        //         return
        //     }
        //
        //     ajaxLink('/admin/visit-todo-group/makeTodoByGroup?todo_ids='+ids+"&group_id="+$("#todo_group_id").val(),function () {
        //         todoTree();
        //     })
        //
        // })

        $("#makeCalendarForm").on('submit',function () {

            ajaxForm('#makeCalendarForm')
            return false;
        })

    }

});