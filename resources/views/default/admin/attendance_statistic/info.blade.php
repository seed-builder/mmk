<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">考勤详情</h4>
</div>
<div class="modal-body">
    <div class="box-body">

        <div class="col-xs-12">


            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width:50%">姓名:</th>
                        <td>{{$att->employee->fname}}</td>
                    </tr>
                    <tr>
                        <th>日期:</th>
                        <td>{{date("Y-m-d",strtotime($att->fday))}}</td>
                    </tr>
                    <tr>
                        <th>考勤状态:</th>
                        <td style="{{$att->fstatus!=1?'color:red':''}}">{{$att->status()}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="table-responsive">
                <table class="table">
                    <tbody>

                    <tr style="width:50%">
                        <th>签到时间:</th>
                        <td>{{!empty($att->beginAttendance->ftime)?$att->beginAttendance->ftime:'无'}}</td>
                    </tr>
                    <tr>
                        <th>签到地点:</th>
                        <td>{{!empty($att->beginAttendance->faddress)?$att->beginAttendance->faddress:'无'}}</td>
                    </tr>
                    <tr>
                        <th>签到状态:</th>
                        <td style="{{$att->fbegin_status!=1?'color:red':''}}">{{$att->begin_status()}}</td>
                    </tr>
                    <tr>
                        <th>签到图片:</th>
                        <td><img src="{{$att->begin_img}}" style="width: 200px;height: 160px"></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="table-responsive">
                <table class="table">
                    <tbody>

                    <tr style="width:50%">
                        <th>签退时间:</th>
                        <td>{{!empty($att->completeAttendance->ftime)?$att->completeAttendance->ftime:'无'}}</td>
                    </tr>
                    <tr>
                        <th>签退地点:</th>
                        <td>{{!empty($att->completeAttendance->faddress)?$att->completeAttendance->faddress:'无'}}</td>
                    </tr>
                    <tr>
                        <th>签退状态:</th>
                        <td style="{{$att->fcomplete_status!=1?'color:red':''}}">{{$att->complete_status()}}</td>
                    </tr>
                    <tr>
                        <th>签退图片:</th>
                        <td><img src="{{$att->complete_img}}" style="width: 200px;height: 160px"></td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>