<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">巡访明细-{{$sc->employee->fname}}-{{$sc->store->ffullname}}-{{date('Y-m-d',strtotime($sc->fdate))}}</h4>
</div>
<div class="modal-body">
    <div class="box-body">

        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-condensed">
                        <tbody>

                        <tr>
                            <th>巡访时间</th>
                            <th>巡访内容</th>
                            <th>巡访状态</th>
                        </tr>

                        @foreach($todos as $t)
                            <tr>
                                <td>{{$t->fdate}}</td>
                                <td>{{$t->todo->fname}}</td>
                                <td>{{$t->status()}}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>

        </div>
    </div>
</div>