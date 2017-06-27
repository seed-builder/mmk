<?php
$years = [];
$curYear = date('Y');
for($i=-10; $i < 10; $i ++){
	$years[] = $curYear + $i;
}
$months = [1,2,3,4,5,6,7,8,9,10,11,12]
?>
        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>经销商系统</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="_token" content="{{csrf_token()}}">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/assets/plugins/AdminLTE/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/assets/plugins/ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/plugins/AdminLTE/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/assets/plugins/AdminLTE/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">

    <link rel="stylesheet" href="{{url('assets')}}/plugins/layui/css/layui.css">
    <link rel="stylesheet" href="/css/style.css">

    @yield('styles')
    <style>
        .modal-header{
            cursor: move;
        }
    </style>
    <!-- jQuery 2.2.3 -->
    <script src="/assets/plugins//jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="/assets/plugins/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="/assets/plugins/fastclick/fastclick.js"></script>
    <script src="/assets/plugins/toastr/toastr.min.js"></script>
    <script src="/assets/plugins/layer/layer.js"></script>

    <script src="/assets/plugins/layui/layui.js"></script>

    <script src="/js/jquery.bootstrap.min.js"></script>
    <script src="/assets/sea.js"></script>
    <script src="/assets/sea.config.js"></script>
    <!-- jquery UI -->
    <script src="/assets/plugins/jQueryUI/jquery-ui.js"></script>
    <script src="/assets/plugins/velocity/velocity.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @include('customer.layout.datatable-css')
    <link rel="stylesheet" href="/assets/plugins/bootstrap-select/bootstrap-select.min.css" />
</head>
<body>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">往来对账列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default" >
                            <form class="form-inline filter "  filter-table="#moduleTable">
                                <div class="form-group">
                                    <label class="">年份</label>
                                    <select class="form-control filter-condition" filter-name="year" filter-operator="=">
                                        <option value="">--请选择--</option>
                                        @foreach($years as $y)
                                        <option value="{{$y}}">{{$y}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="">月份</label>
                                    <select class="form-control filter-condition" filter-name="month" filter-operator="=">
                                        <option value="">--请选择--</option>
                                        @foreach($months as $m)
                                            <option value="{{$m}}">{{$m}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="">状态</label>
                                    <select class="form-control filter-condition" filter-name="status" filter-operator="=">
                                        <option value="">--请选择--</option>
                                        <option value="0">未对账</option>
                                        <option value="1">已对账</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>往来单位代码</th>
                                <th>往来单位名称</th>
                                <th>单据类型</th>
                                <th>单据编码</th>
                                <th>源单编号</th>
                                <th>方案编号</th>
                                <th>业务日期</th>
                                <th>本期发生额</th>
                                <th>金额</th>
                                <th>摘要</th>
                                <th>备注</th>
                                <th>seq</th>
                                <th>status</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <input id="customerId" value="{{$customerId}}">
    <!-- AdminLTE App -->
    <script src="/assets/plugins/AdminLTE/dist/js/app.min.js"></script>
    <script src="/assets/plugins/Shineraini/app.js"></script>
    <!-- AdminLTE for demo purposes -->
    @include('customer.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="/js/dt.ext.js"></script>
    <script type="text/javascript">
        $(function () {
            seajs.use('api/fin_statement.js', function (app) {
                var customerId = $('#customerId').val();
                app.index($, 'moduleTable', customerId);
            });
        });
    </script>

</body>
</html>
