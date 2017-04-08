/**
 *
 */
define(function (require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/message-content',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/message-content/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/message-content/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                {'label': '标题', 'name': 'title',},
                {'label': '内容', 'name': 'content',},
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
            ajax: '/admin/message-content/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'title' },
                {  'data': 'content' },
                {  'data': 'fcreate_date' },
                {
                    'data': 'fcreator_id',
                    render: function ( data, type, full ) {
                        return full.creator.name;
                    }
                },
                {
                    'data': 'fmodify_date',
                },
                {
                    'data': 'fmodify_id',
                    render: function ( data, type, full ) {
                        return full.modifyer.name;
                    }
                },

            ],
            buttons: [
                {
                    text: '发送<i class="fa fa-fw fa-paper-plane"></i>',
                    className: 'send',
                    enabled: false ,
                    action: function () {
                    $("#content_id").val(table.rows('.selected').data()[0].id)
                    $("#message-modal").modal('show')

                }
                },
                {
                    text: '新增<i class="fa fa-fw fa-plus"></i>', action: function () {
                    // $("#"+vmodule.addModal.modal_id).modal('show')
                    window.location.href="/admin/message-content/create"
                }
                },
                {
                    text: '编辑<i class="fa fa-fw fa-pencil"></i>',
                    className: 'edit',
                    enabled: false ,
                    action: function () {
                        // $("#"+vmodule.addModal.modal_id).modal('show')
                        // if (vmodule.table().rows('.selected').data().length == 0)
                        //     layer.alert('请选择一条消息');
                        window.location.href = "/admin/message-content/edit/" + table.rows('.selected').data()[0].id
                    }
                },
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
            ]
        });


        table.on( 'select', checkBtn).on( 'deselect', checkBtn);

        function checkBtn(e, dt, type, indexes) {
            var count = table.rows( { selected: true } ).count();
            table.buttons( ['.edit', '.delete','.send'] ).enable(count > 0);
        }

        $("#scope").on('change',function () {
            if ($("#scope").val()==2)
                $("#scope_hidden").show();
            else
                $("#scope_hidden").hide();
        })

        $(".form-select").selectpicker()
        
        
        $("#message-form").on('submit',function () {
            ajaxForm($("#message-form"));
            return false;
        })
    }

});