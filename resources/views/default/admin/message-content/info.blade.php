<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">消息详情</h4>
</div>
<div class="modal-body">
    <div class="box-body">

        <div class="col-xs-12">


            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width:30%">标题:</th>
                        <td>{{$entity->title}}</td>
                    </tr>
                    <tr>
                        <th>内容:</th>
                        <td>{!! $entity->content !!}</td>
                    </tr>
                    <tr>
                        <th>附件:</th>
                        <td>
                            @foreach($entity->files as $k=>$file)
                                <a href="{{$file}}" type="button" class="btn btn-info btn-flat">附件{{$k+1}} <i class="fa fa-paperclip"></i></a>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

