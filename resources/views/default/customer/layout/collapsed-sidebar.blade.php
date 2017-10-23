<?php
$loginUser = Auth::user();
$loginUserName = empty($loginUser->nick_name) ? $loginUser->name: $loginUser->nick_name;
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
    <link rel="stylesheet" href="/assets/plugins/AdminLTE/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/assets/plugins/AdminLTE/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">

    <link rel="stylesheet" href="{{url('assets')}}/plugins/layui/css/layui.css">
    <link type="text/css" href="/assets/plugins/bootstrap-select/bootstrap-select.css" rel="stylesheet"/>
    <link type="text/css" href="/assets/plugins/datepicker/datepicker3.css" rel="stylesheet"/>
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

</head>
<!-- ADD THE CLASS sidedar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->
<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{url('/customer')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b><img src="/images/logo5.png" />经销商</b>系统</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><img src="/images/logo5.png" />经销商</b>系统</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success" id="message_count">{{ $loginUser->unreadMessagesCount()>0?$loginUser->unreadMessagesCount():'' }}</span>
                        </a>
                        <input type="hidden" id="last_unread_id" value="{{!empty($loginUser->lastUnreadMessage())?$loginUser->lastUnreadMessage()->id:0}}">
                        <a href="" id="message_content" data-target="#contentInfo" data-toggle="modal" style="display: none"></a>

                        <ul class="dropdown-menu">
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu" id="message_list">
                                    @foreach($loginUser->unreadMessages() as $message)
                                        <li><!-- start message -->
                                            <a href="{{url('customer/message/receiveMessages')}}">
                                                <h4>
                                                    {{$message->content->title}}
                                                </h4>
                                                {{--<small class="pull-right"><i class="fa fa-clock-o"></i> {{$message->fcreate_date}}</small>--}}
                                                {{--<p class="text-overflow">{!! $message->content->content !!}</p>--}}
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </li>
                            <li class="footer"><a href="{{url('customer/message/receiveMessages')}}">查看所有</a></li>
                        </ul>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/assets/plugins/AdminLTE/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{$loginUserName}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            {{--<li class="user-header">--}}
                                {{--<img src="/assets/plugins/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}

                                {{--<p>--}}
                                    {{--{{$loginUserName}}--}}
                                    {{--<small>{{Auth::user()->fcreate_date}}</small>--}}
                                {{--</p>--}}
                            {{--</li>--}}
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a id="customer-amount" href="#">货款余额</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a id="pwd-reset" style="cursor: pointer">密码重置</a>
                                    </div>
                                    {{--<div class="col-xs-4 text-center">--}}
                                        {{--<a href="#">Friends</a>--}}
                                    {{--</div>--}}
                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                {{--<div class="pull-left">--}}
                                    {{--<a href="#" class="btn btn-default btn-flat">Profile</a>--}}
                                {{--</div>--}}
                                <div class="pull-right">
                                    <a href="/customer/logout" class="btn btn-default btn-flat">注销</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    {{--<li>--}}
                        {{--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                    {{--</li>--}}
                </ul>
            </div>
        </nav>
    </header>
	<input type="hidden" id="cur_url" value="{{url( Route::getCurrentRoute()->uri() )}}">
    <!-- =============================================== -->

    @include('customer.layout.menu')

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2014-2017 <a href="">Seed build</a>.</strong> All rights
        reserved.
    </footer>

    @include('customer.layout.sidebar')
</div>
<!-- ./wrapper -->
<audio id="audioObj" src="/audio/2478.wav" >提示声音</audio>

<!-- AdminLTE App -->
<script src="/assets/plugins/bootstrap-select/bootstrap-select.js"></script>
<script src="/assets/plugins/bootstrap-select/i18n/defaults-zh_CN.js"></script>
<script src="/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.js"></script>
<script src="/assets/plugins/AdminLTE/dist/js/app.min.js"></script>
<script src="/assets/plugins/Shineraini/app.js"></script>
<!-- AdminLTE for demo purposes -->
<script type="text/javascript">
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $("#pwd-reset").on('click',function () {
        layer.confirm('确认重置密码吗？重置后密码为：888888',function () {
            window.location.href="/customer/user/reset-pwd?id="+{{$loginUser->id}}
            layer.closeAll();
        });
    });

    $('#customer-amount').click(function () {
        $.getJSON("/customer/fin-statement/get-cust-amount",{}, function (res) {
            if (res.data) {
                // You can reload the current location
                layer.msg('货款余额:' + res.data);
            }
        });
    });

    function message() {
        $.get('/customer/message/unread',{},function(data,status,xhr){
            var last_unread_id = $("#last_unread_id").val();
            if (data.count>0) {
                $("#message_count").velocity("fadeOut", {duration: 500})
                    .velocity("fadeIn", {duration: 500});
                if(!audioPlayed) {
                    document.getElementById('audioObj').play();
                    audioPlayed = true;
                }
            }else{
                $("#message_count").text(0);
                $("#message_count").hide();
            }
            if (data.last_id>last_unread_id){
                $("#last_unread_id").val(data.last_id);
                toastr.info('您收到一条新消息！')
                $("#message_count").text(data.count);


                // $("#message_count").velocity("fadeIn", { duration: 1500 })
                //     .velocity("fadeOut", { delay: 500, duration: 1500 });
            }
        },'json')
    }

    $(document).ready(function () {
        setInterval("message()", 5000);
    });
</script>
@yield('js')
@include('customer.layout.toastr-message')

</body>
</html>
