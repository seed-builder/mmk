<?php
$user = Auth::user();
$loginUserName = empty($user->nick_name) ? $loginUser->name: $user->nick_name;
$tops = \App\Models\Permission::where('pid',0)->orderBy('sort')->get();

function createLi($user, $m){
	$html = '';
	if($user->can($m->name)){
		$url = $m->url ? url($m->url) : '';
        $display = $m->display_name;
        $icon = $m->logo;
		if(!empty($m->children) && count($m->children) > 0){
            $html = <<<EOD
<li class="treeview ">
   <a href="$url">
       <i class="$icon"></i>
       <span>$display</span>
       <span class="pull-right-container">
       <i class="fa fa-angle-left pull-right"></i>
   </span>
   </a>
   <ul class="treeview-menu">
EOD;
            $childrenHtml = [];
            foreach ($m->children  as $child)
            {
                $childrenHtml[] = createLi($user, $child);
            }
			$html = $html . implode('', $childrenHtml) . '</ul>';

        }else{
			$html = '<li><a href="'.$url.'"><i class="'.$icon.'"></i>'.$display.'</a></li>';
        }
    }
	return $html;
}


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
                <p>{{$loginUserName}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            @forelse($tops as $top)
                <?php echo createLi($user, $top); ?>
               @empty
            @endforelse
        </ul>
    </section>
<!-- /.sidebar -->
</aside>