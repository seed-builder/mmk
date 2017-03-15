<?php
$user = Auth::user();
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/assets/plugins/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p> {{Auth::user()->fname}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

                <li class="treeview active">
                    <a href="#">
                        <i class="fa fa-fw fa-sitemap"></i>
                        <span>经销商</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('/customer/store')}}"><i class="fa fa-fw fa-inbox"></i>门店信息</a></li>
                        <li><a href="{{url('/customer/stock')}}"><i class="fa fa-fw fa-inbox"></i>门店库存</a></li>
                        <li><a href="{{url('/customer/sale-order')}}"><i class="fa fa-fw fa-reorder"></i>门店订单</a></li>
                        <li><a href="{{url('/customer/stock-out')}}"><i class="fa fa-fw fa-outdent"></i>出库管理</a></li>
                        <li><a href="{{url('/customer/stock-in')}}"><i class="fa fa-fw fa-indent"></i>入库管理</a></li>
                        <li><a href="{{url('/customer/display-policy')}}"><i class="fa fa-fw fa-indent"></i>费用政策</a></li>
                        <li><a href="{{url('/customer/view-customer-stock-statistic')}}"><i class="fa fa-fw fa-table"></i>库存余额</a></li>
                    </ul>
                </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>