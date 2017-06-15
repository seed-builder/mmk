<?php
$user = Auth::user();
$customer = $user->reference;
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
                <p> {{$customer->fname}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-fw fa-sitemap"></i>
                        <span>门店</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('/customer/store')}}"><i class="fa fa-fw fa-home"></i>我的门店</a></li>
                        <li><a href="{{url('/customer/sale-order')}}"><i class="fa fa-fw fa-reorder"></i>门店订单</a></li>
                        <li><a href="{{url('/customer/stock')}}"><i class="fa fa-fw fa-cubes"></i>门店库存</a></li>
                        <li><a href="{{url('/customer/view-store-out')}}"><i class="fa fa-fw fa-truck"></i>门店销售记录</a></li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-fw fa-sitemap"></i>
                        <span>经销商</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('/customer/stock-in')}}"><i class="fa fa-fw fa-indent"></i>入库管理</a></li>
                        <li><a href="{{url('/customer/stock-out')}}"><i class="fa fa-fw fa-truck"></i>出库管理</a></li>
                        <li><a href="{{url('/customer/view-customer-stock-statistic')}}"><i class="fa fa-fw fa-cubes"></i>我的库存</a></li>
                        <li><a href="{{url('/customer/display-policy')}}"><i class="fa fa-fw fa-folder"></i>费用政策</a></li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-fw fa-sitemap"></i>
                        <span>对账平台</span>
                        <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('/customer/fin-statement')}}"><i class="fa fa-database"></i>往来对账</a></li>
                        <li><a href="{{url('/customer/fin')}}"><i class="fa fa-diamond"></i>货款余额</a></li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-comments"></i>
                        <span>消息管理</span>
                        <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('/customer/message/receiveMessages')}}"><i class="fa fa-fw fa-comments-o"></i>个人消息列表</a></li>
                    </ul>
                </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>