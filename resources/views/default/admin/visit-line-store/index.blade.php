@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
    <style>
		.modal label {
			font-size: 10px;
		}
		.modal tr{
			font-size: 10px;
		}
		.modal td{
			font-size: 10px;
		}
	</style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>visit_line_store</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">visit_line_store</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
        	<div class="col-md-3" >
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">组织架构信息</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div id="tree"></div>
					</div>
				</div>
			</div>
            <div class="col-md-9">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">线路列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>线路代码</th>
                                <th>安排日程</th>
                                <th>所属人员</th>
                                <th>所属部门</th>
                                <th>手机</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">线路上的门店列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="childTable" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>序号</th>
									<th>门店全称</th>
									<th>门店简称</th>
									<th>详细地址</th>
									<th>负责人</th>
									<th>联系电话</th>
									<th>负责业代</th>
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

    
<div class="modal fade" tabindex="-1" role="dialog" id="lineAdjust">
	<div class="modal-dialog" role="document" style="width: 30%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">线路调整</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">
					<div class="box-body">
		                <label class="col-md-4">
		                  <input type="radio" name="r1" checked> 当前人员
		                </label>
		                <label class="col-md-4">
		                  <input type="radio" name="r1" > 同组业代
		                </label>
		                <label class="col-md-4">
		                  <input type="radio" name="r1" > 跨组业代
		                </label>
							                
					</div>
					<div class="box-body">
						<div class="form-group">
		                  <label>所属组织</label>
		                  <input type="text" class="form-control" >
		                </div>
						<div class="form-group">
		                  <label>所属人员</label>
		                  <input type="text" class="form-control" >
		                </div>
						<div class="form-group">
		                  <label>线路代码</label>
		                  <select class="form-control">
								@foreach($lines as $l)
								<option value="{{$l->id}}">{{$l->fname}}</option>
								@endforeach
							</select>
		                </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
					<button type="button" class="btn btn-primary">保存</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>


	<div class="modal fade" tabindex="-1" role="dialog" id="storeAdjust">
		<div class="modal-dialog" role="document" style="width: 90%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
							aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">门店调整</h4>
				</div>
				<div class="modal-body" style="height: 750px">
					<div class="col-md-4 ">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">预分配的门店</h3>
							</div>
							<div class="box-body">
								<form class="form-horizontal">
									<div class="box-body">
										<div class="form-group">
											<label class="col-sm-2 control-label">门店名称</label>

											<div class="col-sm-4">
												<input type="text" class="form-control" id="fname">
											</div>

											<label class="col-sm-2 control-label">客户详址</label>

											<div class="col-sm-4">
												<input type="text" class="form-control" id="faddress">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">客户分级</label>

											<div class="col-sm-4">
												<input type="text" class="form-control" >
											</div>

											<label class="col-sm-2 control-label">分配线路</label>

											<div class="col-sm-4">
												<select class="form-control" id="is_allot">
													<option value="1">已分配线路</option>
													<option value="2">未分配线路</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label">线路代码</label>

											<div class="col-sm-4">
												<input type="text" class="form-control" id="fnumber">
											</div>

											<div class="col-sm-6">
												<button type="button" class="btn btn-info" id="redayBtn"><i class="fa fa-fw fa-search"></i>查询</button>
												<button type="button" class="btn btn-info" id="taddBtn"><i class="fa fa-fw fa-plus"></i>添加</button>
											</div>
										</div>


									</div>

								</form>
								<table id="readyTable" class="table table-bordered table-hover">
									<thead>
									<tr style="white-space: nowrap;">
										<th>序号</th>
										<th width="15%">门店全称</th>
										<th width="15%">门店简称</th>
										<th width="15%">详细地址</th>
										<th width="15%">负责人</th>
										<th width="15%">负责业代</th>
										<th width="15%">联系电话</th>
									</tr>
									</thead>
								</table>

							</div>
						</div>

					</div>

					<div class="col-md-4 ">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">预分配的门店</h3>
							</div>
							<div class="box-body">
								<form class="form-horizontal" id="mapForm">
									<div class="box-body">

										<div class="form-group">
											<label class="col-sm-2 control-label">省份</label>

											<div class="col-sm-4">
												<select class="form-control" id="province_id">
													@foreach($citys as $c)
														<option value="{{$c->id}}">{{$c->Name}}</option>
													@endforeach
												</select>
											</div>

											<label class="col-sm-2 control-label">城市</label>

											<div class="col-sm-4">
												<select class="form-control" id="city_id">

												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label">区域</label>

											<div class="col-sm-4">
												<select class="form-control" id="country_id">

												</select>
											</div>

											<div class="col-sm-6">
												<input type="hidden" value="" id="map_select_id">
												<button type="button" class="btn btn-info" id="mQueryBtn"><i class="fa fa-fw fa-search"></i>查询</button>
												<button type="button" class="btn btn-info" id="mAddBtn"><i class="fa fa-fw fa-plus"></i>添加</button>
											</div>
										</div>


									</div>

								</form>
								<div id="map" style="height: 500px"></div>
							</div>
						</div>

					</div>

					<div class="col-md-4 ">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">已分配的门店</h3>
							</div>
							<div class="box-body">

								<table id="allotTable" class="table table-bordered table-hover">
									<thead>
									<tr style="white-space: nowrap;">
										<th>序号</th>
										<th width="15%">门店全称</th>
										<th width="15%">门店简称</th>
										<th width="15%">详细地址</th>
										<th width="15%">负责人</th>
										<th width="15%">负责业代</th>
										<th width="15%">联系电话</th>
										<th>line_id</th>
									</tr>
									</thead>
								</table>

							</div>
						</div>

					</div>

				</div>

			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>


@endsection
@section('js')
	<script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=D4Bi3270ydgA5HsnWDnmBVwF3zaPdoMC"></script>
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/visit_line_store.js', function (app) {
                app.index($, 'moduleTable','tree','childTable','map');
            });
        });
    </script>

@endsection