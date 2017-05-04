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
                    url: '/admin/view-visit-kpi',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/view-visit-kpi/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/view-visit-kpi/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
            { 'label':  'cust_avg_cost', 'name': 'cust_avg_cost', },
                { 'label':  'day_cost_total', 'name': 'day_cost_total', },
                { 'label':  'day_visit_cust_num', 'name': 'day_visit_cust_num', },
                { 'label':  'fdate', 'name': 'fdate', },
                { 'label':  'femp_id', 'name': 'femp_id', },
                { 'label':  'fname', 'name': 'fname', },
                { 'label':  'line_cust_total', 'name': 'line_cust_total', },
                { 'label':  'month_cost_total', 'name': 'month_cost_total', },
                { 'label':  'month_visit_cust_num', 'name': 'month_visit_cust_num', },
                { 'label':  'position_name', 'name': 'position_name', },
                { 'label':  'rate', 'name': 'rate', },
                { 'label':  'valid_cust_total', 'name': 'valid_cust_total', },
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
                url : '/admin/view-visit-kpi/pagination'
            },
            columns: [
                {  'data': 'fname' },
                {  'data': 'position_name' },
                {  'data': 'store_total' },
                {  'data': 'valid_store_total' },
                {  'data': 'day_store_total' },
                {  'data': 'day_store_done_total' },
                {  'data': 'month_store_total' },
                {  'data': 'month_store_done_total' },
                {
                    'data': 'rate',
                    render: function ( data, type, full ) {
                        return (data==null?0:data)+'%'
                    }
                },
                {
                    'data': 'day_cost_total',
                    render: function ( data, type, full ) {
                        var second = isNaN(parseInt(data))?0:parseInt(data);
                        return second/60
                    }
                },
                {
                    'data': 'month_cost_total',
                    render: function ( data, type, full ) {
                        var second = isNaN(parseInt(data))?0:parseInt(data);
                        return second/60
                    }
                },
                {
                    'data': 'store_avg_cost',
                    render: function ( data, type, full ) {
                        var second = isNaN(parseInt(data))?0:parseInt(data);
                        return second/60
                    }
                },
                // {  'data': 'fdate' },

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