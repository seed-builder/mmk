@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
    <style>
        @page rotated {
            size: landscape;
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content edit-box">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div id="print-content">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$stock_out->customer->name . '送货单'}}</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-xs-12">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>经销商地址：</td>
                                        <td>{{$stock_out->customer->faddress}}</td>
                                        <td>经销商电话：</td>
                                        <td>{{$stock_out->customer->ftel}}</td>
                                    </tr>
                                    <tr>
                                        <td>单号：</td>
                                        <td>{{$stock_out->fbill_no}}</td>
                                        <td>收货单位：</td>
                                        <td>{{$stock_out->store->ffullname}}</td>
                                    </tr>
                                    <tr>
                                        <td>门店地址：</td>
                                        <td>{{$stock_out->store->faddress}}</td>
                                        <td>门店电话：</td>
                                        <td>{{$stock_out->store->fphone}}</td>
                                    </tr>
                                    <tr>
                                        <td>日期：</td>
                                        <td>{{date('Y年m月d日',strtotime($stock_out->fdate))}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>行号</th>
                                        <th>产品名称</th>
                                        <th>规格型号</th>
                                        <th>单位</th>
                                        <th>数量</th>
                                        <th>单价</th>
                                        <th>金额</th>
                                    </tr>

                                    @foreach($stock_out->items as $key=>$item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->material->fname}}</td>
                                            <td>{{$item->material->fspecification}}</td>
                                            <td>{{$item->material->fbase_unit}}</td>
                                            <td>{{$item->fbase_qty}}</td>
                                            <td width="10%"><input type="number" class="unit_price" value="0"></td>
                                            <td><span class="price"></span></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6" align="right">合计：</td>
                                        <td id="statics"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button id="makePrint" type="button" class="btn btn-info pull-right">生成打印单</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>

    <section class="content print-box" style="display: none">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div id="print-real-view"></div>
                    <div class="box-footer">
                        <button id="back" type="button" class="btn btn-info pull-right">返回编辑</button>
                        <button id="printBtn" type="button" class="btn btn-info pull-right">打印本页</button>
                    </div>
                </div>
            </div>

        </div>
    </section>



@endsection
@section('js')
    @include('admin.layout.datatable-js')
    <!-- jqprint -->
    <script src="http://www.jq22.com/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script src="/assets/plugins/jquery-print/jquery.jqprint-0.3.js"></script>
    <script>
        $("#makePrint").on('click', function () {
            $("#print-real-view").html($("#print-content").clone());
            $("#print-real-view").find('.unit_price').each(function (index,ele) {
                var unit_price = $(ele).val();
                $(ele).parent().text(unit_price)
                $(ele).remove();
            })
            $('.edit-box').hide();
            $('.print-box').show();
        })
        $("#back").on('click', function () {
            $('.edit-box').show();
            $('.print-box').hide();
        })
        $("#printBtn").on('click', function () {
            $("#print-real-view").jqprint();
        })
        $(function () {
            calculate();
        })

        $(".unit_price").on('change',function () {
            calculate();
        })

        function calculate() {
            var sum = 0;
            $(".unit_price").each(function (index,ele) {
                var unit_price = Number($(ele).val());
                var amount = Number($(ele).parent().prev().text());
                $(ele).parent().next().text(unit_price*amount)
                sum+=unit_price*amount;
            })

            $("#statics").text(sum)
        }
    </script>
@endsection