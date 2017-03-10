<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">巡访明细-{{$sc->employee->fname}}-{{$sc->store->ffullname}}
        -{{date('Y-m-d',strtotime($sc->fdate))}}</h4>
</div>
<div class="modal-body">
    <div class="box-body">

        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="timeline">

                    @foreach($todos as $t)
                        <!-- timeline time label -->
                            <li class="time-label">
                          <span class="bg-green">
                            {{$t->fdate}}
                          </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-camera bg-purple"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-fw fa-calendar-o"></i> {{$t->status()}}</span>

                                    <h3 class="timeline-header">{{!empty($t->todo->fname)?$t->todo->fname:'无'}}</h3>

                                    <div class="timeline-body">
                                        @if(!empty($t->images))
                                            @foreach($t->images as $i)
                                                <img src="{{$i}}" alt="..." class="margin" style="width: 150px;height: 100px;">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                        @endforeach
                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                    </ul>

                    {{--<table class="table table-condensed">--}}
                        {{--<tbody>--}}

                        {{--<tr>--}}
                            {{--<th>巡访时间</th>--}}
                            {{--<th>巡访内容</th>--}}
                            {{--<th>巡访状态</th>--}}
                        {{--</tr>--}}

                        {{--@foreach($todos as $t)--}}
                            {{--<tr>--}}
                                {{--<td>{{$t->fdate}}</td>--}}
                                {{--<td>{{$t->todo->fname}}</td>--}}
                                {{--<td>{{$t->status()}}</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}


                        {{--</tbody>--}}
                    {{--</table>--}}
                </div>
                <!-- /.box-body -->
            </div>

        </div>
    </div>
</div>