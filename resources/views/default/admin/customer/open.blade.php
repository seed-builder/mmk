<link type="text/css" href="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/assets/plugins/bootstrap-validator/css/bootstrapValidator.min.css" />
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">经销商门户后台登陆用户信息</h4>
</div>
<div class="modal-body">
    <div class="box-body">
        <div class="row">
            <form class="form-horizontal" id="openForm" action="{{url('/admin/customer/'.$customer->id.'/open')}}" autocomplete="off" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="login_name" class="col-sm-4 col-md-2 control-label">登陆名称</label>
                    <div class="col-sm-8  col-md-10">
                        <input type="text" class="form-control" id="name" placeholder="登陆名称" name="name" value="{{$user->name or $customer->ftel}}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-4 col-md-2 control-label">密码(默认888888)</label>
                    <div class="col-sm-8 col-md-10">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="密码" name="password" value="{{$user->password or '888888'}}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/assets/plugins/bootstrap-validator/js/bootstrapValidator.min.js"></script>
<script src="/assets/plugins/bootstrap-validator/js/language/zh_CN.js"></script>
<script type="text/javascript">
    $('#openForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {},
                    remote: {
                        url: '{{url('/admin/customer/'.$customer->id.'/unique')}}',
                        message: '该名称已存在',
                    },
                }
            },
            password: {
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
            if(result)
            {
                layer.msg('保存成功!');
                window.location.reload(true);
            }
        }, 'json');
    });
</script>