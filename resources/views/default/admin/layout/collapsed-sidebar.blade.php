<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MMK</title>
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
    @yield('styles')
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
    <script src="/js/jquery.bootstrap.min.js"></script>
    <script src="/assets/sea.js"></script>
    <script src="/assets/sea.config.js"></script>
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
        <a href="/assets/plugins/AdminLTE/index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Admin</b>LTE</span>
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
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/assets/plugins/AdminLTE/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{Auth::user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="/assets/plugins/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                <p>
                                    {{Auth::user()->name}}
                                    <small>{{Auth::user()->created_at}}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">密码重置</a>
                                    </div>
                                    {{--<div class="col-xs-4 text-center">--}}
                                        {{--<a href="#">Sales</a>--}}
                                    {{--</div>--}}
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
                                    <a href="/admin/logout" class="btn btn-default btn-flat">注销</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
	<input type="hidden" id="cur_url" value="{{url( Route::getCurrentRoute()->getPath() )}}">
    <!-- =============================================== -->

    @include('admin.layout.menu')

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

    @include('admin.layout.sidebar')
</div>
<!-- ./wrapper -->

<!-- AdminLTE App -->
<script src="/assets/plugins/AdminLTE/dist/js/app.min.js"></script>
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

    /**
     *	根据当前url选中菜单
     *	设置导航栏
    **/
    $(".treeview-menu").each(function(i,obj){
    	$(obj).find("a").each(function(j,a){
        	var node_url = $(a).attr("href");//菜单url
        	var cur_url = $("#cur_url").val();//当前页url
        	
        	if(node_url==cur_url){
            	$(this).parent().addClass("active")
            	var node = $(obj).prev();
            	var node_i = $(node).find("i").prop("outerHTML");
            	var node_span = $(node).find("span").prop("outerHTML");
            	var node_text = $(node).find("span").text();
            	var title = "<h1>"+node_text+" <small>"+$(this).text()+"</small></h1><ol class=\"breadcrumb\"><li>"+node_i+"  "+node_span+"</li><li>"+$(this).text()+"</li></ol>"
            	
            	$(".content-header").html(title);
            }
        })
    })

    $('body').on('hidden.bs.modal', '.modal:not(.modal-cached)', function () {
        $(this).removeData('bs.modal');
    });


    /*
     * 根据审核状态判断是否可编辑
     */
    function checkEditEnabble(table,enableButtonClass,disableButtonClass) {
        var count = table.rows( { selected: true } ).count();
        var row = table.rows('.selected').data()[0];
        if (count>0){
            if (row.fdocument_status=="A"){
                table.buttons( enableButtonClass ).enable(true);
                table.buttons( disableButtonClass ).enable(false);
            }else {
                table.buttons( enableButtonClass ).enable(false);
                table.buttons( disableButtonClass ).enable(true);
            }
        }

    }
    
    /*
     * 获取审核状态
     */
    function document_status(status) {
        if (status=="A"){
            return '未审核';
        }else if(status=="B"){
            return '审核成功';
        }else {
            return '状态异常';
        }
    }

    /*
     * 数据审核 反审核
     */
    function dataCheck(table,baseurl) {
        var row = table.rows('.selected').data();

        var ids = new Array();
        for (var i=0;i<row.length;i++){
            ids.push(row[i].id);
        }

        var url = baseurl+"?ids="+ids;

        ajaxLink(url,function () {
            table.ajax.reload();
        });
    }

    /*
     * ajaxLink
     */
    function ajaxLink(url,callback){
        // load the form via ajax
        $.ajax({
            type: 'GET',
            data: {},
            //async: true,
            cache: false,
            url: url,
            dataType: "json",
            timeout: 10000,
            success: function(res)
            {
                layer.msg(res.result);
                if (res.redirect_url){
                    window.location.href = res.redirect_url;
                }

                if(callback !== undefined ){
                    callback();
                }
            },

            error: function(jqXHR, textStatus, errorThrown)
            {
                layer.msg(jqXHR.responseText);
            },

        });

    }
</script>
@yield('js')
@include('admin.layout.toastr-message')

</body>
</html>
