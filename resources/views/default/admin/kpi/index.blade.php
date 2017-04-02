@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>bd_kpis</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">bd_kpis</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-3" >
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">部门架构信息</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-wrench"></i></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" id="btnOpen"><i class="fa fa-folder-open"></i>展开</a></li>
                                    <li><a href="#" id="btnCollapse"><i class="fa fa-folder"></i>折叠</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="tree" tree-type="department-tree"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">业绩列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default" >
                            <form class="form-horizontal filter"  filter-table="#moduleTable">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">员工姓名</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="employee_fname" filter-operator="like"/>
                                    </div>

                                    <label class="col-sm-2 control-label">手机号</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="employee_fphone" filter-operator="like"/>
                                    </div>


                                    <label class="col-sm-2 control-label">指标类型</label>
                                    <div class="col-sm-2">
                                        <select class="form-control filter-condition filter-select" filter-name="ftype">
                                            <option value="">--请选择--</option>
                                            <option value="0">目标拜访量</option>
                                            <option value="1">目标销售额</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-footer" style="text-align: center">
                                    <button type="button" class="btn btn-info filter-submit">查询</button>
                                    <button type="button" class="btn btn-default filter-reset">重置</button>
                                </div>
                            </form>
                        </div>
                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>姓名</th>
                                <th>手机号</th>
                                <th>指标类型</th>
                                <th>年份</th>
                                <th>1月</th>
                                <th>2月</th>
                                <th>3月</th>
                                <th>4月</th>
                                <th>5月</th>
                                <th>6月</th>
                                <th>7月</th>
                                <th>8月</th>
                                <th>9月</th>
                                <th>10月</th>
                                <th>11月</th>
                                <th>12月</th>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="kpi-modal">
        <div class="modal-dialog" role="document" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">业绩设定</h4>
                </div>
                <form class="form-horizontal" id="kpi-form" action="{{url('admin/kpi/store')}}">
                <div class="modal-body">
                    <div class="box-body">

                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">员工姓名</label>
                            <div class="col-sm-2">
                                <select class="form-control form-select" multiple id="femp_list" name="femp_id[]" data-live-search="true" data-actions-box="true">
                                    @foreach($employees as $e)
                                        <option value="{{$e->id}}">{{$e->fname}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-sm-1 control-label">年份</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control year" name="fyear" />
                            </div>

                            <label class="col-sm-2 control-label">指标类型</label>
                            <div class="col-sm-2">
                                <select class="form-control form-select" name="ftype" >
                                    <option value="0">目标拜访量</option>
                                    <option value="1">目标销售额</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">1月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="fjan"/>
                            </div>

                            <label class="col-sm-1 control-label">2月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="feb"/>
                            </div>

                            <label class="col-sm-2 control-label">3月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="fmar" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">4月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="fapr"/>
                            </div>

                            <label class="col-sm-1 control-label">5月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="fmay"/>
                            </div>

                            <label class="col-sm-2 control-label">6月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="fjun" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">7月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="fjul"/>
                            </div>

                            <label class="col-sm-1 control-label">8月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="faug"/>
                            </div>

                            <label class="col-sm-2 control-label">9月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="fsep" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">10月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="foct"/>
                            </div>

                            <label class="col-sm-1 control-label">11月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="fnov"/>
                            </div>

                            <label class="col-sm-2 control-label">12月</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="fdec" />
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" >保存</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script src="/assets/plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>

    <script type="text/javascript">
        $(function () {
            seajs.use('admin/kpi.js', function (app) {
                var emps = {!! json_encode($employees) !!}
                app.index($, 'moduleTable','tree',emps);
            });
        });
    </script>

@endsection