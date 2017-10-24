@extends('customer.layout.collapsed-sidebar')
@section('styles')
    @include('customer.layout.datatable-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            top module
            <small>bd_customer_prices</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">top module</a></li>
            <li class="active">bd_customer_prices</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">售价列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover display nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>经销商</th>
                                <th>产品名称</th>
                                <th>产品规格</th>
                                <th>销售单位</th>
                                {{--<th>销售起数量</th>--}}
                                {{--<th>销售止数量</th>--}}
                                <th>单价/箱</th>
                                <th>单价/瓶</th>
                                <th>审核状态</th>
                                <th>是否有效</th>
                                <th>创建时间</th>
                                <th>修改时间</th>
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
    @include('customer.layout.datatable-js')
    <script type="text/javascript">
        var customers = {!! json_encode($customers) !!} ;
        var materials = {!! json_encode($materials) !!} ;
        $(function () {
            seajs.use('customer/customer_price.js', function (app) {
                //alert(materials.length);
                app.index($, 'moduleTable', customers, materials);
            });

        });
    </script>

@endsection