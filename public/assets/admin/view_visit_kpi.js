/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId) {
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
                {  'data': 'store_total',render: function ( data, type, full ) {
                    d = isNaN(parseInt(data))?0:parseInt(data);
                    return d;
                } },
                {  'data': 'valid_store_total',render: function ( data, type, full ) {
                    d = isNaN(parseInt(data))?0:parseInt(data);
                    return d;
                } },
                // {  'data': 'day_store_total' },
                {  'data': 'day_store_done_total',render: function ( data, type, full ) {
                    d = isNaN(parseInt(data))?0:parseInt(data);
                    return d;
                } },
                {  'data': 'month_times_total' ,render: function ( data, type, full ) {
                    d = isNaN(parseInt(data))?0:parseInt(data);
                    return d;
                }},
                {  'data': 'month_done_times_total',render: function ( data, type, full ) {
                    d = isNaN(parseInt(data))?0:parseInt(data);
                    return d;
                } },
                {
                    'data': 'month_times_rate',
                    render: function ( data, type, full ) {
                        return (data==null?0: Number(data).toFixed(2))+'%'
                    }
                },
                {  'data': 'month_store_total',render: function ( data, type, full ) {
                    d = isNaN(parseInt(data))?0:parseInt(data);
                    return d;
                } },
                {  'data': 'month_store_done_total',render: function ( data, type, full ) {
                    d = isNaN(parseInt(data))?0:parseInt(data);
                    return d;
                } },
                {
                    'data': 'rate',
                    render: function ( data, type, full ) {
                        return (data==null?0: Number(data).toFixed(2))+'%'
                    }
                },
                {
                    'data': 'day_cost_total',
                    render: function ( data, type, full ) {
                        var second = isNaN(parseInt(data))?0:parseInt(data);
                        return Math.round( second/60 );
                    }
                },
                {
                    'data': 'month_cost_total',
                    render: function ( data, type, full ) {
                        var second = isNaN(parseInt(data))?0:parseInt(data);
                        return Math.round( second/60 );
                    }
                },
                {
                    'data': 'day_store_total',
                    render: function ( data, type, full ) {
                        // var second = isNaN(parseInt(data))?0:parseInt(data);
                        // return Math.round( second/60 );
                        var month_cost_total = isNaN(parseInt(full.month_cost_total))?0:parseInt(full.month_cost_total);
                        var month_done_times_total = isNaN(parseInt(full.month_done_times_total ))?0:parseInt(full.month_done_times_total);
                        var res = Math.round(month_cost_total / month_done_times_total / 60);
                        return isNaN(res) ? 0 : res;
                    }
                },
                {
                    'data': 'store_avg_cost',
                    render: function ( data, type, full ) {
                        var second = isNaN(parseInt(data))?0:parseInt(data);
                        return Math.round( second/60 );
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