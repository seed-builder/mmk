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
                url: '/admin/view-revisit/pagination'
            },
            columns: [
                {  'data': 'id' },
                {  'data': 'senior_name' },
                {  'data': 'frevisit_date' },
                {  'data': 'store_name' },
                {  'data': 'store_number' },
                {
                    "data": 'frevisit_status',
                    render: function ( data, type, full ) {
                        if(data==1){
                            return "未开始";
                        }else if(data==2){
                            return "进行中";
                        }else if(data==3){
                            return "已完成";
                        }
                    }
                },
                {
                    "data": "id",
                    render: function ( data, type, full ) {
                        if (full.frevisit_status > 1) {
                            return '<a href="/admin/visit_store_calendar/revisit-pics/' + data + '" data-target="#todoInfo" data-toggle="modal"><i class="fa fa-fw fa-search"></i></a>';
                        }else{
                            return '';
                        }
                    }
                },
            ],
            buttons: [
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