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
                <p>Alexander Pierce</p>
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
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/asset/AdminLTE-2.3.7/index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                    <li><a href="/asset/AdminLTE-2.3.7/index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-fw fa-tv"></i>
                    <span>基础信息管理</span>
                    <span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('admin/employee/index')}}"><i class="fa fa-circle-o"></i></i> 员工信息</a></li>
                    <li><a href="{{url('admin/department/index')}}"><i class="fa fa-circle-o"></i></i> 部门信息</a></li>
<!--                     <li><a href="#"><i class="fa fa-circle-o"></i></i> 产品信息</a></li> -->
<!--                     <li><a href="#"><i class="fa fa-circle-o"></i></i> 渠道信息</a></li> -->
<!--                     <li><a href="#"><i class="fa fa-circle-o"></i></i> 区域经营品项</a></li> -->
<!--                     <li><a href="#"><i class="fa fa-circle-o"></i></i> 主竞品</a></li> -->
<!--                     <li><a href="#"><i class="fa fa-circle-o"></i></i> 重点品项</a></li> -->
                </ul>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-fw fa-calendar-check-o"></i>
                    <span>考勤管理</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-fw fa-building-o"></i>
                    <span>门店管理</span>
                    <span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('admin/store/index')}}"><i class="fa fa-circle-o"></i></i> 门店信息</a></li>
                    <li><a href="{{url('admin/visit_line/index')}}"><i class="fa fa-circle-o"></i></i> 线路</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i></i> 人员线路规划</a></li>
                    <li><a href="{{url('admin/visit_line_calendar/index')}}"><i class="fa fa-circle-o"></i></i> 拜访日记</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i></i> 拜访工作纪录</a></li>
                    <li><a href="{{url('admin/visit_store_calendar/index')}}"><i class="fa fa-circle-o"></i></i> 门店拜访查看</a></li>
                </ul>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>用户权限管理</span>
                    <span class="pull-right-container">
                      <span class="label label-primary pull-right">3</span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/admin/user')}}"><i class="fa fa-user"></i>用户管理</a></li>
                    <li><a href="{{url('/admin/role/')}}"><i class="fa fa-group"></i>角色管理</a></li>
                    <li><a href="{{url('/admin/permission')}}"><i class="fa fa-folder"></i>菜单权限管理</a></li>
                </ul>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-anchor"></i>
                    <span>系统管理</span>
                    <span class="pull-right-container">
                      <span class="label label-primary pull-right">1</span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/admin/sys-config')}}"><i class="fa fa-cogs"></i>配置管理</a></li>
                    <li><a href="{{url('/admin/sys-dics')}}"><i class="fa fa-fw fa-book"></i>字典管理</a></li>
                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>