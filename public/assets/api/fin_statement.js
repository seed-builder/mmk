/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');

    exports.index = function ($, tableId, customerId) {

        var table = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            responsive: false,
            rowId: "id",
            ajax: {
                url: '/api/fin-statement/pagination?customerId='+customerId,
                data: function (data) {
                    data['columns'][14]['search']['value'] = customerId;
                }
            },
            columns: [
                {  'data': 'id' },
                {  'data': 'cust_num' },
                {  'data': 'cust_name' },
                {  'data': 'bill_type' },
                {  'data': 'bill_no' },
                {  'data': 'srcbill_no' },
                {  'data': 'project_no' },
                {  'data': 'bill_date' },
                {  'data': 'cur_amount' },
                {  'data': 'bal_amount' },
                {  'data': 'abstract' },
                {  'data': 'remarks' },
                {  'data': 'seq' },
                {  'data': 'status' },
                {  'data': 'cust_id'},
            ],
            columnDefs: [
                // {
                //     'targets': 0,
                //     'checkboxes': {
                //         'selectRow': true
                //     }
                // },
                {
                    "targets": [12,13,14],
                    "visible": false
                }
            ],
            order: [[12, 'asc']],
            buttons: [
                // { text: '确认对账', className: 'sure', enabled: false ,  action: function () {
                //     layer.confirm("确认对账?", ["确定", "取消"], function () {
                //         var data = table.rows( { selected: true } ).data()[0];
                //         $.ajax({
                //             url: "/customer/fin-statement/" + data.id,
                //             type: 'PUT',
                //             data: {_token: $('meta[name="_token"]').attr('content'), 'data': [{status: 1}]},
                //             success: function (res) {
                //                 if (res.data) {
                //                     // You can reload the current location
                //                     layer.msg('对账成功！');
                //                     table.ajax.reload();
                //                 } else {
                //                     layer.msg('对账失败！');
                //                 }
                //             }
                //         })
                //     })
                // }  },
                // { text: '货款余额', className: 'edit', enabled: true, action: function () {
                //     $.getJSON("/customer/fin-statement/get-cust-amount",{}, function (res) {
                //         if (res.data) {
                //             // You can reload the current location
                //             layer.msg('货款余额:' + res.data);
                //         }
                //     })
                // } },
                // { text: '删除', className: 'delete', enabled: false },
                // {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                // { text: '打印<i class="fa fa-fw fa-print"></i>',action: function () {
                //     var row = table.rows('.selected').data();
                //     if (row.length==0){
                //         layer.alert('请选择对账信息')
                //         return ;
                //     }
                //     var ids = [];
                //     for(var i=0; i < row.length; i++){
                //         ids[ids.length] = row[i].id;
                //     }
                //     window.location.href= "/customer/fin-statement/print?ids=" + ids.join(',');
                // } },
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        table.on( 'select', checkBtn).on( 'deselect', checkBtn);

        function checkBtn(e, dt, type, indexes) {
            var data = table.rows( { selected: true } ).data()[0];
            if(data ){
                table.buttons( ['.sure'] ).enable(data.status == 0);
            }

        }

    }

});