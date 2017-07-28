<?php
$curAmount = 0;
$balAmount = 0;
$dateMin = $items->min('bill_date');
$dateMax = $items->max('bill_date');
$firstday = date('Y-m-01', strtotime($dateMax));
$nextMonth = strtotime('+1 month', strtotime($firstday));
$lastday = strtotime('-1 day', $nextMonth);
?>
@extends('customer.layout.collapsed-sidebar')
@section('styles')
    @include('customer.layout.datatable-css')
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
                        <style>
                            * {
                                font-size: 12px !important;
                            }
                            th{
                                font-size: 14px  !important;
                                line-height:30px;
                                text-align: center;
                            }
                            h3{
                                font-size: 30px  !important;
                                font-weight: bold;
                            }
                            table tr td{
                                padding: 2px !important;
                            }
                            .sign {
                                font-size: 16px !important;
                            }
                        </style>
                        <div class="box-header with-border" style="text-align: center">
                            <span class="pull-left"><img src="/images/logo-black.jpg"></span><h3 class="box-title">{{date('Y年m月份', strtotime($dateMax))}}客户往来对账单</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-xs-12">
                                对账期限：{{date('Y年m月1日',strtotime($dateMax))}}至{{date('Y年m月d日',$lastday)}}
                            </div>
                            <div class="col-xs-12">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th style="min-width: 100px">往来单位代码</th>
                                        <th style="min-width: 100px">往来单位名称</th>
                                        <th style="min-width: 80px">单据类型</th>
                                        <th style="min-width: 80px">单据编码</th>
                                        <th style="min-width: 80px">源单编号</th>
                                        <th style="min-width: 80px">方案编号</th>
                                        <th style="min-width: 80px">业务日期</th>
                                        <th style="min-width: 80px">本期发生额</th>
                                        <th style="min-width: 80px">余额</th>
                                        <th style="min-width: 80px">摘要</th>
                                        <th style="min-width: 80px">备注</th>
                                    </tr>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{$item->cust_num}}</td>
                                            <td>{{$item->cust_name}}</td>
                                            <td>{{$item->bill_type}}</td>
                                            <td>{{$item->bill_no}}</td>
                                            <td>{{$item->srcbill_no}}</td>
                                            <td>{{$item->project_no}}</td>
                                            <td>{{trim($item->bill_date, "00:00:00")}}</td>
                                            <td style="text-align: right;">{{$item->cur_amount}}</td>
                                            <td style="text-align: right;">{{$item->bal_amount}}</td>
                                            <td>{{$item->abstract}}</td>
                                            <td>{{$item->remarks}}</td>
                                        </tr>
                                        <?php
                                        $curAmount += $item->cur_amount;
                                        $balAmount += $item->bal_amount;
                                        ?>
                                    @endforeach
                                    {{--<tr>--}}
                                        {{--<td>{{$item->cust_num}}</td>--}}
                                        {{--<td>{{$item->cust_name}}</td>--}}
                                        {{--<td align="right">合计：</td>--}}
                                        {{--<td ></td>--}}
                                        {{--<td ></td>--}}
                                        {{--<td ></td>--}}
                                        {{--<td ></td>--}}
                                        {{--<td >{{$curAmount}}</td>--}}
                                        {{--<td >{{$balAmount}}</td>--}}
                                        {{--<td ></td>--}}
                                        {{--<td ></td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td colspan="11">
                                            <ul>
                                                <li>
                                                    1、余额为“负数”，代表客户在本公司帐上可用余款。余额为“正数”，代表客户欠本公司的货款。.
                                                </li>
                                                <li>
                                                    2、山图财务于每月10日前将截止上月末对帐单发至客户指定邮箱，客户可通过系统对帐单或邮箱对帐单进行核对，核对完毕后应打印、签字盖章确认，并于月底前将原件直接寄至财务管理部，地址：厦门市思明区中航紫金广场B座27层。
                                                </li>
                                                <li>
                                                    3、对帐单可帮助购销双方核对帐目，如有疑问或不详，欢迎来电或邮件咨询！联系人：①韩小清，联系电话0592-2228069，邮箱hxqing@shantuwine.com；②陈铃，联系电话0592-2228237，邮箱cling@shantuwine.com；③李黎黎，联系电话0592-2226931，邮箱llli@shantuwine.com。
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr  class="sign">
                                        <td colspan="5">
                                            <b>1、信息证明无误</b>
                                        </td>
                                        <td colspan="6">
                                            <b>2、信息不符，请列明不符项目及具体内容</b>
                                        </td>
                                    </tr>
                                    <tr class="sign">
                                        <td colspan="5" style="height: 180px;overflow: auto;width: 50%;font-size: 16px !important;">
                                            <div style="position: relative;">
                                                <div style="position: absolute ; top: 80px; right: 80px;">公司盖章</div>
                                                <div style="position: absolute ; top: 110px; right: 60px;">
                                                    <span class="sign">年</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sign">月</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sign">日</span>
                                                </div>
                                                <div style="position: absolute ; top: 140px; right: 250px;"><span class="sign">经办人：</span></div>
                                            </div>
                                        </td>
                                        <td colspan="6" style="height: 180px;overflow: auto;width: 50%;font-size: 16px !important;">
                                            <div style="position: relative;">
                                                <div style="position: absolute ; top: 80px; right: 80px;">公司盖章</div>
                                                <div style="position: absolute ; top: 110px; right: 60px;">
                                                    <span class="sign">年</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sign">月</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sign">日</span>
                                                </div>
                                                <div style="position: absolute ; top: 140px; right: 250px;"><span class="sign">经办人：</span></div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="/customer/fin-statement" style="margin-left: 10px" class="btn btn-default pull-right">返回</a>
                        <button id="makePrint" type="button" class="btn btn-info pull-right">打印本页</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>

@endsection
@section('js')
    @include('customer.layout.datatable-js')
    <!-- jqprint -->
    <script src="http://www.jq22.com/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script src="/assets/plugins/jquery-print/jquery.jqprint-0.3.js"></script>
    <script>
        $("#makePrint").on('click', function () {
            $("#print-content").jqprint();
        })
    </script>
@endsection