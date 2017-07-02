<?php
$years = [];
$curYear = date('Y');
$curMonth = date('n');
for($i=-10; $i < 10; $i ++){
	$years[] = $curYear + $i;
}
$months = [1,2,3,4,5,6,7,8,9,10,11,12];

$ddArr = empty($data['DDAmount']) ? [] : $data['DDAmount'];
$CurReturnAmount = 0;
$AllReturnAmount = 0;
$NoReturnAmount = 0;
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
                        <h3 class="box-title">代垫返还情况</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="width: 100%; overflow: scroll;">
                        <div class="panel panel-default" >
                            <form class="form-inline " action="#" method="post">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label class="">年份</label>
                                    <select class="form-control " id="year" name="year" >
                                        <option value="">--请选择--</option>
                                        @foreach($years as $y)
                                            <option value="{{$y}}" {{$y == $year ? 'selected':''}}>{{$y}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="">月份</label>
                                    <select class="form-control " id="month" name="month">
                                        <option value="">--请选择--</option>
                                        @foreach($months as $m)
                                            <option value="{{$m}}" {{$m == $month ? 'selected':''}}>{{$m}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info filter-submit">查询</button>
                                </div>
                            </form>
                        </div>

                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>单据编号</th>
                                <th style="min-width: 100px;">代垫金额 </th>
                                <th style="min-width: 100px;">本期返<br/>还金额 </th>
                                <th style="min-width: 100px;">累计返<br/>还金额 </th>
                                <th style="min-width: 100px;">未返还<br/>金额 </th>
                                <th style="min-width: 150px;">用途 </th>
                                <th style="min-width: 100px;">代垫单号</th>
                                <th style="min-width: 100px;">方案编号</th>
                                <th style="min-width: 100px;">客户代码</th>
                                <th style="min-width: 100px;">客户名称</th>
                                <th style="min-width: 100px;">纸质单<br/>日期 </th>
                                <th style="min-width: 100px;">审核日期 </th>
                                <th>返还期间 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($ddArr as $dd)
                            <tr>
                                <td>{{$dd['FBILLNO']}}</td>
                                <td>{{$dd['FDDAmount']}}</td>
                                <td>{{$dd['FCurReturnAmount']}}</td>
                                <td>{{$dd['FAllReturnAmount']}}</td>
                                <td>{{$dd['FNoReturnAmount']}}</td>
                                <td>{{$dd['FPurpose']}}</td>
                                <td>{{$dd['FPageNo']}}</td>
                                <td>{{$dd['FPromotionNo']}}</td>
                                <td>{{$dd['fcustnum']}}</td>
                                <td>{{$dd['fcustName']}}</td>
                                <td>{{$dd['FPageDate']}}</td>
                                <td>{{$dd['FCheckDate']}}</td>
                                <td>{{$dd['FReturnMonth']}}</td>
                            </tr>
                            <?php
                            $CurReturnAmount +=  $dd['FCurReturnAmount'];
                            $AllReturnAmount +=  $dd['FAllReturnAmount'];
                            $NoReturnAmount +=  $dd['FNoReturnAmount'];
                            ?>
                                @empty
                            @endforelse
                            <tr>
                                <td></td>
                                <td>合计</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$CurReturnAmount}}</td>
                                <td>{{$AllReturnAmount}}</td>
                                <td>{{$NoReturnAmount}}</td>
                            </tr>
                            </tbody>
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
</body>
</html>
