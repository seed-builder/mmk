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
                <p>{{Auth::user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            @if($user->can(['employee_index','department_index','channel_index','position_index','material_index','customer_index']))
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-fw fa-tv"></i>
                        <span>基础信息管理</span>
                        <span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        @if($user->can('employee_index'))
                            <li><a href="{{url('admin/employee/index')}}"><i class="fa fa-circle-o"></i></i> 员工信息</a>
                            </li>
                        @endif
                        @if($user->can('department_index'))
                            <li><a href="{{url('admin/department/index')}}"><i class="fa fa-circle-o"></i></i> 部门信息</a>
                            </li>
                        @endif
                    <!--                     <li><a href="#"><i class="fa fa-circle-o"></i></i> 产品信息</a></li> -->
                        @if($user->can('channel_index'))
                            <li><a href="{{url('admin/channel/index')}}"><i class="fa fa-circle-o"></i></i> 渠道信息</a>
                            </li>
                        @endif
                        @if($user->can('position_index'))
                            <li><a href="{{url('admin/position')}}"><i class="fa fa-circle-o"></i></i> 职位信息</a></li>
                        @endif
                        @if($user->can('material_index'))
                            <li><a href="{{url('admin/material')}}"><i class="fa fa-circle-o"></i></i> 商品信息</a></li>
                        @endif
                        @if($user->can('customer_index'))
                            <li><a href="{{url('/admin/customer')}}"><i class="fa fa-circle-o"></i></i> 经销商信息</a></li>
                    @endif



                    <!--                     <li><a href="#"><i class="fa fa-circle-o"></i></i> 区域经营品项</a></li> -->
                        <!--                     <li><a href="#"><i class="fa fa-circle-o"></i></i> 主竞品</a></li> -->
                        <!--                     <li><a href="#"><i class="fa fa-circle-o"></i></i> 重点品项</a></li> -->
                    </ul>
                </li>
            @endif

            @if($user->can(['attendance_index']))
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-fw fa-calendar-check-o"></i>
                        <span>考勤管理</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        @if($user->can('attendance_index'))
                            <li><a href="{{url('/admin/attendance/index')}}"><i class="fa fa-user"></i>考勤情况查看</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if($user->can(['store_index','visit_line_index','visit_line_store_index','visit_line_calendar_index','visit_store_calendar_index']))
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-fw fa-building-o"></i>
                        <span>门店管理</span>
                        <span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        @if($user->can('store_index'))
                            <li><a href="{{url('admin/store/index')}}"><i class="fa fa-fw fa-shopping-cart"></i>门店信息</a></li>
                        @endif

                        @if($user->can('visit_line_index'))
                            <li><a href="{{url('admin/visit_line/index')}}"><i class="fa fa-fw fa-random"></i>线路</a>
                            </li>
                        @endif

                        @if($user->can('visit_line_store_index'))
                            <li><a href="{{url('admin/visit_line_store/index')}}"><i class="fa fa-fw fa-map-signs"></i>人员线路规划</a></li>
                        @endif

                        @if($user->can('visit_line_calendar_index'))
                            <li><a href="{{url('admin/visit_line_calendar/index')}}"><i class="fa fa-fw fa-calendar-o"></i>拜访日志</a></li>
                        @endif


                    </ul>
                </li>
            @endif

            <li class="treeview ">
                <a href="#">
                    <i class="fa fa-fw fa-eyedropper"></i>
                    <span>申报管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/admin/leave')}}"><i class="fa fa-fw fa-calendar-minus-o"></i>请假管理</a></li>

                </ul>
            </li>
            <li class="treeview ">
                <a href="#">
                    <i class="fa fa-fw fa-line-chart"></i>
                    <span>业绩设定</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/admin/kpi')}}"><i class="fa fa-fw fa-signal"></i>业绩查询</a></li>

                </ul>
            </li>

            @if($user->can(['stock_index','sale-order_index','stock-out_index','stock-in_index','view-customer-stock-statistic_index']))
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-fw fa-sitemap"></i>
                        <span>经销商门户</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview ">
                            <a href="#">
                                <i class="fa fa-fw fa-sitemap"></i>
                                <span>门店</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                {{--<li><a href="{{url('/admin/store')}}"><i class="fa fa-fw fa-home"></i>我的门店</a></li>--}}
                                @if($user->can('sale-order_index'))
                                    <li><a href="{{url('/admin/sale-order')}}"><i class="fa fa-fw fa-reorder"></i>门店订单</a>
                                    </li>
                                @endif
                                @if($user->can('stock_index'))
                                    <li><a href="{{url('/admin/stock')}}"><i class="fa fa-fw fa-inbox"></i>门店库存</a></li>
                                @endif
                                <li><a href="{{url('/admin/view-store-out')}}"><i class="fa fa-fw fa-truck"></i>门店出库</a></li>
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
                                @if($user->can('stock-in_index'))
                                    <li><a href="{{url('/admin/stock-in')}}"><i class="fa fa-fw fa-indent"></i>入库管理</a></li>
                                @endif
                                @if($user->can('stock-out_index'))
                                    <li><a href="{{url('/admin/stock-out')}}"><i class="fa fa-fw fa-outdent"></i>出库管理</a></li>
                                @endif
                                @if($user->can('view-customer-stock-statistic_index'))
                                    <li><a href="{{url('/admin/view-customer-stock-statistic')}}"><i
                                                    class="fa fa-fw fa-table"></i>库存余额</a></li>
                                @endif
                                    <li><a href="{{url('/admin/display-policy')}}"><i class="fa fa-fw fa-tasks"></i>费用政策</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif

            @if($user->can(['user_index','role_index','permission_index']))
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>用户权限管理</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        @if($user->can('user_index'))
                            <li><a href="{{url('/admin/user')}}"><i class="fa fa-user"></i>用户管理</a></li>
                        @endif
                        @if($user->can('role_index'))
                            <li><a href="{{url('/admin/role/')}}"><i class="fa fa-group"></i>角色管理</a></li>
                        @endif
                        @if($user->can('permission_index'))
                            <li><a href="{{url('/admin/permission')}}"><i class="fa fa-folder"></i>权限管理</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if($user->can(['sys-config_index','sys-dics_index','app-upgrade_index','message-template_index','visit_funciton_index','visit_todo_group_index','visit_todo_group_config','visit_store_todo_index']))
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-anchor"></i>
                        <span>系统管理</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        @if($user->can('sys-config_index'))
                            <li><a href="{{url('/admin/sys-config')}}"><i class="fa fa-cogs"></i>配置管理</a></li>
                        @endif
                        @if($user->can('sys-dics_index'))
                            <li><a href="{{url('/admin/sys-dics')}}"><i class="fa fa-fw fa-book"></i>字典管理</a></li>
                        @endif
                        @if($user->can('app-upgrade_index'))
                            <li><a href="{{url('/admin/app-upgrade')}}"><i class="fa fa-fw fa-upload"></i>app升级包管理</a>
                            </li>
                        @endif
                        @if($user->can('message-template_index'))
                            <li><a href="{{url('/admin/message-template')}}"><i class="fa fa-fw fa-paper-plane"></i>消息模板</a>
                            </li>
                        @endif
                        @if($user->can('visit_funciton_index'))
                            <li><a href="{{url('admin/visit-function')}}"><i class="fa fa-fw fa-clone"></i>拜访功能</a>
                            </li>
                        @endif
                        @if($user->can('visit_todo_group_index'))
                            <li><a href="{{url('admin/visit-todo-group')}}"><i class="fa fa-files-o"></i>拜访方案</a>
                            </li>
                        @endif
                        @if($user->can('visit_todo_group_config'))
                            <li><a href="{{url('admin/visit-todo-group/config')}}"><i class="fa fa-cogs"></i>拜访事项</a>
                            </li>
                        @endif
                        @if($user->can('visit_store_todo_index'))
                            <li><a href="{{url('admin/visit-store-todo')}}"><i class="fa fa-folder"></i>拜访配置模板</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            {{--<li class="treeview ">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-arrows"></i>--}}
            {{--<span>工作流</span>--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--<li><a href="{{url('/admin/work-flow')}}"><i class="fa fa-cogs"></i>配置管理</a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>