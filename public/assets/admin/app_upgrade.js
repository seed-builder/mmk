/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId) {
        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/app-upgrade',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/app-upgrade/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/app-upgrade/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                { 'label':  '版本号', 'name': 'version_code', },
                { 'label':  '版本名', 'name': 'version_name', },
                { 'label':  'url', 'name': 'url','type':"readonly" },
                { 'label':  '更新内容', 'name': 'content', 'type': 'textarea'},
                {
                    label: "是否强制更新:",
                    name:  "enforce",
                    type:  "select",
                    options: [
                        { label: "否", value: "0" },
                        { label: "是", value: "1" },
                    ]
                },

            ]
        });

        var table = $("#" + tableId).DataTable({
            dom: "Bfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax: '/admin/app-upgrade/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'version_code' },
                {  'data': 'version_name' },
                {  'data': 'url' },
                {  'data': 'content' },
                {  'data': 'enforce' },
                {  'data': 'upgrade_date' },
            ],
            buttons: [
                { text: '上传安装包<i class="fa fa-fw fa-cloud-upload"></i>', action: function () {
                    $("#appModal").modal('show');
                }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

        $("#apk").fileinput({
            overwriteInitial: true,
            //maxFileSize: 10000,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: '删除',
            browseLabel: '',
            browseIcon: '<i class="fa fa-fw fa-cloud-upload"></i>',
            browseTitle: '选择你要上传的文件',
            elErrorContainer: '#kv-avatar-errors-2',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '',
            layoutTemplates: {main2: '{preview} ' + ' {remove} {browse}'},
            allowedFileExtensions: ["apk"]
        });
        
        $("#appUpload").on('click',function () {
            var formData = new FormData($( "#appForm" )[0]);
            console.log($("#apk").val());
            $.ajax({
                url: "/admin/app-upgrade/upload",
                type: "POST",
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    layer.msg(data['result'])
                    if (data['code']==200){
                        $("#appModal").modal('hide');
                        table.ajax.reload();
                    }

                },
            });
        })
    }

});