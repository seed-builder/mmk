@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>view_visit_kpi</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">view_visit_kpi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">重要KPI跟进表</h3>
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

                                    <label class="col-sm-2 control-label">姓名</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="fname" filter-operator="like"/>
                                    </div>

                                    <label class="col-sm-2 control-label">职位</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control filter-condition" filter-name="position_name" filter-operator="like"/>
                                    </div>

                                    <label class="col-sm-2 control-label">线路总客户数</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control filter-condition" filter-name="line_cust_total" filter-operator=">="/>
                                            <span class="input-group-addon">---</span>
                                            <input type="text" class="form-control filter-condition" filter-name="line_cust_total" filter-operator="<="/>
                                        </div>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">有效客户数</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control filter-condition" filter-name="valid_cust_total" filter-operator=">="/>
                                            <span class="input-group-addon">---</span>
                                            <input type="text" class="form-control filter-condition" filter-name="valid_cust_total" filter-operator="<="/>
                                        </div>
                                    </div>

                                    <label class="col-sm-2 control-label">当日拜访客户数</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control filter-condition" filter-name="day_visit_cust_num" filter-operator=">="/>
                                            <span class="input-group-addon">---</span>
                                            <input type="text" class="form-control filter-condition" filter-name="day_visit_cust_num" filter-operator="<="/>
                                        </div>
                                    </div>

                                    <label class="col-sm-2 control-label">本月累计拜访客户数</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control filter-condition" filter-name="month_visit_cust_num" filter-operator=">="/>
                                            <span class="input-group-addon">---</span>
                                            <input type="text" class="form-control filter-condition" filter-name="month_visit_cust_num" filter-operator="<="/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">拜访率</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control filter-condition" filter-name="rate" filter-operator=">="/>
                                            <span class="input-group-addon">%</span>
                                            <span class="input-group-addon">---</span>
                                            <input type="text" class="form-control filter-condition" filter-name="rate" filter-operator="<="/>
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>

                                    <label class="col-sm-2 control-label">当日拜访用时</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control filter-condition" filter-name="day_cost_total" filter-operator=">="/>
                                            <span class="input-group-addon">---</span>
                                            <input type="text" class="form-control filter-condition" filter-name="day_cost_total" filter-operator="<="/>
                                        </div>
                                    </div>

                                    <label class="col-sm-2 control-label">当月累计拜访用时</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control filter-condition" filter-name="month_cost_total" filter-operator=">="/>
                                            <span class="input-group-addon">---</span>
                                            <input type="text" class="form-control filter-condition" filter-name="month_cost_total" filter-operator="<="/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">平均单个客户拜访用时</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control filter-condition" filter-name="cust_avg_cost" filter-operator=">="/>
                                            <span class="input-group-addon">---</span>
                                            <input type="text" class="form-control filter-condition" filter-name="cust_avg_cost" filter-operator="<="/>
                                        </div>
                                    </div>

                                    <label class="col-sm-2 control-label">日期</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control filter-condition filter-date" filter-name="fdate"/>
                                        </div>
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
                                <th>姓名</th>
                                <th>职位</th>
                                <th>线路总客户数</th>
                                <th>有效客户数</th>
                                <th>当日应拜访客户数</th>
                                <th>当日已拜访客户数</th>
                                <th>本月应拜访客户数</th>
                                <th>本月已拜访客户数</th>
                                <th>拜访率</th>
                                <th>当日拜访用时</th>
                                <th>当月累计拜访用时</th>
                                <th>平均单个客户拜访用时</th>
                                {{--<th>日期</th>--}}
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

@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <script type="text/javascript">
        $(function () {
            seajs.use('admin/view_visit_kpi.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

@endsection