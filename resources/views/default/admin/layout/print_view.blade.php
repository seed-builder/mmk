@extends('admin.layout.collapsed-sidebar')
@section('styles')
    @include('admin.layout.datatable-css')
    <style>
        @page rotated{size:landscape;}
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12" id="">
                <div class="box">
                    <div id="print-content">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$title}}</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-xs-12">
                                <table class="table" >
                                    <tbody>
                                    <tr>
                                        @foreach($title_datas as $k=>$title)
                                            <td width="16%">{{$title['label']}}：</td>
                                            <td width="16%">{{$title['value']}}</td>
                                            @if(($k+1)%3==0)
                                    </tr>
                                    <tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        @foreach($table_datas['ths'] as $th)
                                            <th>{{$th}}</th>
                                        @endforeach
                                    </tr>
                                    @foreach($table_datas['tds'] as $td)
                                        <tr>
                                            @foreach($td as $t)
                                                <td>{{$t['value']}}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button id="printBtn" type="button" class="btn btn-info pull-right">打印本页</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>



@endsection
@section('js')
    @include('admin.layout.datatable-js')
<script>
    $("#printBtn").on('click',function () {
        $("#print-content").jqprint();
    })
</script>
@endsection