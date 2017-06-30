<?php
$years = [];
$curYear = date('Y');
for($i=-10; $i < 10; $i ++){
	$years[] = $curYear + $i;
}
$months = [1,2,3,4,5,6,7,8,9,10,11,12];

$ddArr = empty($data['DDAmount']) ? [] : $data['DDAmount'];
?>
@extends('admin.layout.collapsed-sidebar')

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
                        <h3 class="box-title">代垫返还情况</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default" >
                            <form class="form-inline " action="/admin/customer-dd-return" method="post">
                                 {!! csrf_field() !!}
                                <div class="form-group">
                                    <label class="">经销商</label>
                                    <select class="form-control" id="custId" name="custId" data-live-search="true">
                                        <option value="">--请选择--</option>
                                        @foreach($customers as $c)
                                            <option data-tokens="{{$c->fname}}" value="{{$c->id}}" {{$c->id == $custId ? 'selected':''}}>{{$c->fname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="">年份</label>
                                    <select class="form-control " id="year" name="year" >
                                        <option value="">--请选择--</option>
                                        @foreach($years as $y)
                                            <option value="{{$y}}" {{$y == $year ? 'selected':''}}>{{$y}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="">月份</label>
                                    <select class="form-control " id="month" name="month">
                                        <option value="">--请选择--</option>
                                        @foreach($months as $m)
                                            <option value="{{$m}}" {{$m == $month ? 'selected':''}}>{{$m}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info filter-submit">查询</button>
                                </div>
                            </form>
                        </div>

                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>单据编号</th>
                                <th>代垫单号</th>
                                <th>方案编号</th>
                                <th>客户代码</th>
                                <th>客户名称</th>
                                <th>纸质单日期 </th>
                                <th>审核日期 </th>
                                <th>返还期间 </th>
                                <th>用途 </th>
                                <th>代垫金额 </th>
                                <th>本期返还金额 </th>
                                <th>累计返还金额 </th>
                                <th>未返还金额 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($ddArr as $dd)
                            <tr>
                                <td>{{$dd['FBILLNO']}}</td>
                                <td>{{$dd['FPageNo']}}</td>
                                <td>{{$dd['FPromotionNo']}}</td>
                                <td>{{$dd['fcustnum']}}</td>
                                <td>{{$dd['fcustName']}}</td>
                                <td>{{$dd['FPageDate']}}</td>
                                <td>{{$dd['FCheckDate']}}</td>
                                <td>{{$dd['FReturnMonth']}}</td>
                                <td>{{$dd['FPurpose']}}</td>
                                <td>{{$dd['FDDAmount']}}</td>
                                <td>{{$dd['FCurReturnAmount']}}</td>
                                <td>{{$dd['FAllReturnAmount']}}</td>
                                <td>{{$dd['FNoReturnAmount']}}</td>
                            </tr>
                                @empty
                            @endforelse
                            </tbody>
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


@endsection