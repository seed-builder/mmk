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
                {'label': '通讯地址', 'name': 'faddress',},
                {'label': '地区', 'name': 'farea',},
                {'label': '经营模式', 'name': 'fbusiness_mode',},
                {'label': '城市', 'name': 'fcity',},
                {'label': '公司性质', 'name': 'fcompany_nature',},
                {'label': '公司规模', 'name': 'fcompany_scale',},
                {'label': '国家', 'name': 'fcountry',},
                {'label': '客户类别', 'name': 'fcust_type_id',},
                {'label': '折扣表', 'name': 'fdiscount_list_id',},
                {'label': '传真', 'name': 'ffax',},
                {'label': '客户分组', 'name': 'fgroup',},
                {'label': '发票类型', 'name': 'finvoice_type',},
                {'label': '运输方式', 'name': 'fmode_transport',},
                {'label': '客户名称', 'name': 'fname',},
                {'label': '价目表', 'name': 'fprice_list_id',},
                {'label': '省份', 'name': 'fprovince',},
                {'label': '所属服务处', 'name': 'fsale_depart',},
                {'label': '销售员', 'name': 'fseller',},
                {'label': '所属营业部', 'name': 'fservice_depart',},
                {'label': '客户简称', 'name': 'fshort_name',},
                {'label': '默认税率', 'name': 'ftax_rate',},
                {'label': '纳税登记号', 'name': 'ftax_register_code',},
                {'label': '税分类', 'name': 'ftax_type',},
                {'label': '联系电话', 'name': 'ftel',},
                {'label': '结算币别', 'name': 'ftrading_curr_id',},
                {'label': '公司网址', 'name': 'fwebsite',},
                {'label': '邮政编码', 'name': 'fzip',},
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
            ajax: '/admin/customer/pagination',
            columns: [
                {'data': 'id'},
                {'data': 'fname'},
                {'data': 'faddress'},
                {'data': 'ftel'},
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

        // table.on( 'select', checkBtn).on( 'deselect', checkBtn);
        //
        // function checkBtn(e, dt, type, indexes) {
        //     var count = table.rows( { selected: true } ).count();
        //     table.buttons( ['.edit', '.delete'] ).enable(count > 0);
        // }

    }

});