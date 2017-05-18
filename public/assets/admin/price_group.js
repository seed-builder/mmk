/**
*
*/
define(function(require, exports, module) {

    var zhCN = require('datatableZh');
    var editorCN = require('i18n');
    exports.index = function ($, tableId, detailTableId, materials) {

        var tableEditCn = $.extend(editorCN, {
            create:{
                title: '新增价格组',
                button: "新建",
                submit: "提交"
            },
            edit: {
                title: '价格组编辑',
                button: "保存",
                submit: "提交"
            },
        });

        var editor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/price-group',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/price-group/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/price-group/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: tableEditCn,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                { 'label':  '编号', 'name': 'fnumber', },
                { 'label':  '名称', 'name': 'fname', },
                { 'label':  '等级', 'name': 'flevel', type:  "select",
                    options: [
                        { label: "1 级",value: "1" },
                        { label: "2 级",value: "2" },
                        { label: "3 级",value: "3" },
                        { label: "4 级",value: "4" },
                        { label: "5 级",value: "5" },
                        { label: "6 级",value: "6" },
                        { label: "7 级",value: "7" },
                        { label: "8 级",value: "8" },
                        { label: "9 级",value: "9" },
                    ]
                },
                { 'label':  '有效期开始', 'name': 'fbegin',  type:  'datetime', def:   function () { return new Date(); } },
                { 'label':  '有效期截止', 'name': 'fend', type:  'datetime', def:   function () { return new Date(); } },
                { 'label':  '适用范围', 'name': 'fsuit_object', type:  "select",
                    options: [
                        { label: "全部",value: "all" },
                        { label: "门店",value: "store" },
                        { label: "经销商",value: "customer" },
                    ]},
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
            ajax: '/admin/price-group/pagination',
            columns: [
                {  'data': 'id' },
                {  'data': 'fnumber' },
                {  'data': 'fname' },
                {  'data': 'flevel' },
                {  'data': 'fsuit_object' , render: function (data, type, full) {
                    var txt = '';
                    switch (data){
                        case 'all':
                            txt = '全部';
                            break;
                        case 'store':
                            txt = '门店';
                            break;
                        case 'customer':
                            txt = '经销商';
                            break;
                    }
                    return txt;
                }},
                {  'data': 'fbegin' },
                {  'data': 'fend' },
                {  'data': 'fdocument_status', render: function (data, type, full) {
                    return document_status(data);
                } },
                {  'data': 'fcreate_date' },
                {  'data': 'fmodify_date' },
            ],
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
            ],
            buttons: [
                { text: '新增', action: function () {
                    var data = getSelectedData();
                    window.location.href='/admin/price-group/create';
                }  },

                // { text: '删除', className: 'delete', enabled: false },
                //{extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: editor},
                // {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: editor},
                { text: '详情', className: 'edit', enabled: false, action: function () {
                    var data = getSelectedData();
                    window.location.href='/admin/price-group/' + data.id +'/edit';
                } },
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: editor},
                { text: '审核<i class="fa fa-fw fa-paperclip"></i>',className: 'check', enabled: false },
                { text: '反审核<i class="fa fa-fw fa-unlink"></i>',className: 'uncheck', enabled: false },
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ],
            order: [[9, 'desc']]
        });

        function getSelectedData() {
            return table.rows( { selected: true } ).data()[0];
        }

        table.on( 'select', checkBtn).on( 'deselect', checkBtn);

        function checkBtn(e, dt, type, indexes) {
            checkEditEnabble(table,['.check', '.edit'],['.uncheck']);
        }

        //审核
        $(".check").on('click',function () {
            dataCheck(table,'/admin/price-group/check');
        })

        $(".uncheck").on('click',function () {
            dataCheck(table,'/admin/price-group/uncheck');
        })

    }

    exports.edit = function ($, tableId, groupId, materials) {

        var detailEditor = new $.fn.dataTable.Editor({
            ajax: {
                create: {
                    type: 'POST',
                    url: '/admin/price',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                edit: {
                    type: 'PUT',
                    url: '/admin/price/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                },
                remove: {
                    type: 'DELETE',
                    url: '/admin/price/_id_',
                    data: {_token: $('meta[name="_token"]').attr('content')},
                }
            },
            i18n: editorCN,
            table: "#" + tableId,
            idSrc: 'id',
            fields: [
                { 'label':  'fgroup_id', 'name': 'fgroup_id', type: 'hidden', def: groupId },
                { 'label':  '商品', 'name': 'fmaterial_id', type: 'select', options: materials},
                { 'label':  '数量起', 'name': 'fmin_qty', def: 0 },
                { 'label':  '数量止', 'name': 'fmax_qty', def: 10000 },
                { 'label':  '价格', 'name': 'fprice', },
            ]
        });

        var detailTable = $("#" + tableId).DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax:{
                url : '/admin/price/pagination',
                data : function (data) {
                    data.columns[10]['search']['value'] = groupId;
                }
            },
            columns: [
                {  'data': 'id' },
                {  'data': 'fmaterial_id', render: function (data, type, full) {
                    return full.material.fname;
                } },
                {  'data': 'fmaterial_id', render: function (data, type, full) {
                    return full.material.fspecification;
                } },
                {  'data': 'fmaterial_id', render: function (data, type, full) {
                    return full.material.fsale_unit;
                } },
                {  'data': 'fprice' },
                {  'data': 'fmin_qty' },
                {  'data': 'fmax_qty' },
                {  'data': 'fdocument_status', render: function (data, type, full) {
                    return document_status(data);
                } },
                {  'data': 'fcreate_date' },
                {  'data': 'fmodify_date' },
                {  'data': 'fgroup_id' },
            ],
            columnDefs: [
                {
                    "targets": [0,10],
                    "visible": false
                }
            ],
            buttons: [
                // { text: '新增', action: function () { }  },
                // { text: '编辑', className: 'edit', enabled: false },
                // { text: '删除', className: 'delete', enabled: false },
                {extend: "create", text: '新增<i class="fa fa-fw fa-plus"></i>', editor: detailEditor },
                {extend: "edit", text: '编辑<i class="fa fa-fw fa-pencil"></i>', editor: detailEditor},
                {extend: "remove", text: '删除<i class="fa fa-fw fa-trash"></i>', editor: detailEditor},
                { text: '审核<i class="fa fa-fw fa-paperclip"></i>',className: 'detail-check', enabled: false },
                { text: '反审核<i class="fa fa-fw fa-unlink"></i>',className: 'detail-uncheck', enabled: false },
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ],
            order: [[9, 'desc']]
        });

        detailTable.on( 'select', detailCheckBtn).on( 'deselect', detailCheckBtn);

        function detailCheckBtn(e, dt, type, indexes) {
            // var count = table.rows( { selected: true } ).count();
            // table.buttons( ['.edit', '.delete'] ).enable(count > 0);
            checkEditEnabble(detailTable,['.detail-check'],['.detail-uncheck']);
        }

        //删除
        $('#btnRemove').on('click', function () {
            layer.confirm('确定删除 ? ', ['确定', '取消'], function () {
                $.post('/admin/price-group/' + groupId, {_token: $('meta[name="_token"]').attr('content'), _method: 'DELETE'}, function (res) {
                    if(res.cancelled == 0){
                        layer.msg('删除成功');
                        window.location.href = '/admin/price-group';
                    }else{
                        layer.msg('删除失败 ' + res.error);
                    }
                })
            });
        });
        //审核
        $("#btnCheck").on('click',function () {
            //dataCheck(detailTable,'');
            $.get('/admin/price-group/check', {ids: groupId}, function (res) {
                if(res.code ==  200){
                    layer.msg(res.result);
                    window.location.reload(true);
                }
            })
        })

        $("#btnUnCheck").on('click',function () {
            $.get('/admin/price-group/uncheck', {ids: groupId}, function (res) {
                if(res.code ==  200){
                    layer.msg(res.result);
                    window.location.reload(true);
                }
            })
        })

        $('#detailForm').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                fnumber: {
                    validators: {
                        notEmpty: {},
                    }
                },
                fname: {
                    validators: {
                        notEmpty: {},
                    }
                },
                fbegin: {
                    validators: {
                        notEmpty: {},
                    }
                },
                fend: {
                    validators: {
                        notEmpty: {},
                    }
                },

            }
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();
            // Get the form instance
            var $form = $(e.target);
            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function (result) {
                if(result.cancelled == 0)
                {
                    layer.msg('保存成功!');
                    window.location.reload(true);
                }else{
                    layer.msg('保存失败 ' + result.error );
                }
            }, 'json');
        });

        //store table
        var storeTable = $("#storeTable").DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax:{
                url : '/admin/price-group/'+groupId+'/store-pagination',
            },
            columns: [
                {  'data': 'id' },
                {  'data': 'fnumber' },
                {  'data': 'ffullname' },
                {  'data': 'faddress' },
            ],
            buttons: [
                { text: '新增', action: function () {
                    window.location.href='/admin/price-group/'+groupId+'/choose-store';
                }  },
                { text: '删除', className: 'delete', enabled: false },
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

        //store table
        var customerTable = $("#customerTable").DataTable({
            dom: "lBfrtip",
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            ajax:{
                url : '/admin/price-group/'+groupId+'/customer-pagination',
            },
            columns: [
                {  'data': 'id' },
                {  'data': 'fname' },
                {  'data': 'faddress' },
            ],
            buttons: [
                { text: '新增', action: function () {
                    window.location.href='/admin/price-group/'+groupId+'/choose-customer';
                }  },
                { text: '删除', className: 'delete', enabled: false },
                {extend: 'excel', text: '导出Excel<i class="fa fa-fw fa-file-excel-o"></i>'},
                {extend: 'print', text: '打印<i class="fa fa-fw fa-print"></i>'},
                //{extend: 'colvis', text: '列显示'}
            ]
        });

    };

    exports.create = function ($) {
        $('#detailForm').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                fnumber: {
                    validators: {
                        notEmpty: {},
                    }
                },
                fname: {
                    validators: {
                        notEmpty: {},
                    }
                },
                fbegin: {
                    validators: {
                        notEmpty: {},
                    }
                },
                fend: {
                    validators: {
                        notEmpty: {},
                    }
                },

            }
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();
            // Get the form instance
            var $form = $(e.target);
            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function (result) {
                if(result.cancelled == 0)
                {
                    layer.msg('保存成功!');
                    window.location.href = '/admin/price-group/' + result.data[0].id+'/edit';
                }else{
                    layer.msg('保存失败 ' + result.error );
                }
            }, 'json');
        });
    }

    exports.chooseStore = function ($, tableId, groupId) {
        var table = $("#" + tableId).DataTable({
            dom: '<"pull-right"B>lrtip',
            language: zhCN,
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            rowId: "id",
            searching: false,
            ajax: {
                url : '/admin/store/pagination',
            },
            columns: [
                {  "data": "id",
                    render: function (data, type, full) {
                        return '<input type="checkbox" class="editor-active" value="'+data+'">';
                    },
                    className: "dt-body-center"
                },
                {"data": "fnumber"},
                {"data": "ffullname"},
                {"data": "faddress"},
                {"data": "fcontracts"},
                {"data": "ftelephone"},
                {
                    "data": 'femp_id',
                    render: function (data, type, full) {
                        if (full.employee != null)
                            return full.employee.fname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fcust_id',
                    render: function (data, type, full) {
                        if (full.customer != null)
                            return full.customer.fname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fline_id',
                    render: function (data, type, full) {
                        if (full.line != null)
                            return full.line.fname
                        else
                            return "";
                    }
                },
                {
                    "data": 'fchannel',
                    render: function (data, type, full) {
                        if (full.channel != null)
                            return full.channel.fname
                        else
                            return "";
                    }
                },
                {
                    "data": "fis_signed",
                    render: function (data, type, full) {
                        if (data==0){
                            return '未签约';
                        }else {
                            return '已签约';
                        }
                    }
                },
                {
                    "data": "fdocument_status",
                    render: function (data, type, full) {
                        return document_status(data);
                    }
                }
            ],
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    },
                    'sortable': false
                }
            ],
            buttons: [
                { text: '关联选择', className: 'btn-primary', enabled: false,  action: function () {
                    var stores = table.rows('.selected').data();
                    if(stores.length > 0){
                        var ids = [] ;
                        var orderId = 0
                        for(var i = 0; i < stores.length; i++){
                            ids[ids.length] = stores[i].id;
                        }
                        $.post('/admin/price-group/'+groupId+'/attach-store',
                            {_token: $('meta[name="_token"]').attr('content'), ids: ids},
                            function (result) {
                                if(result.data){
                                    layer.msg('关联成功!');
                                }else{
                                    layer.msg('关联成功, 错误：' + result.error);
                                }
                            }
                        )
                    }
                }  },
                { text: '返回', action: function () {
                    window.location.href= '/admin/price-group/'+groupId+'/edit';
                } },
            ],
            select: {
                'style': 'multi'
            },
        });

        table.on( 'select', detailCheckBtn).on( 'deselect', detailCheckBtn);

        function detailCheckBtn(e, dt, type, indexes) {
            var count = table.rows({selected: true}).count();
            table.buttons(['.btn-primary']).enable(count > 0);
        }
    }
});