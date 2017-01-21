@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
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
						<div class="form-group col-md-6"><label>门店名称</label>   <input type="text"></div>			                
						<div class="form-group col-md-6"><label>所属人员</label>   <input type="text"></div>		
						<div class="form-group col-md-6"><label>线路代码</label>   
							<select>
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
	<div class="modal-dialog" role="document" style="width: 50%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">门店调整</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">
					<div class="box-body">
						
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
@endsection
@section('js')
	<script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/visit_line_store.js', function (app) {
                app.index($, 'moduleTable','tree','childTable');
            });
        });
    </script>

@endsection