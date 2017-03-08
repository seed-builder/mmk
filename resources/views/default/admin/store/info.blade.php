<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">门店详情</h4>
</div>
<div class="modal-body">
    <div class="box-body">

        <div class="col-xs-6">


            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width:50%">门店名称:</th>
                        <td>{{$store->ffullname}}</td>
                    </tr>
                    <tr>
                        <th>门店简称:</th>
                        <td>{{$store->fshortname}}</td>
                    </tr>
                    <tr>
                        <th>门店编号:</th>
                        <td>{{$store->fnumber}}</td>
                    </tr>
                    <tr>
                        <th>地址:</th>
                        <td>{{$store->fprovince.$store->fprovince.$store->fcity.$store->fcountry.$store->fstreet.$store->faddress}}</td>
                    </tr>
                    <tr>
                        <th>邮编:</th>
                        <td>{{$store->fpostalcode}}</td>
                    </tr>
                    <tr>
                        <th>联系人:</th>
                        <td>{{$store->fcontracts}}</td>
                    </tr>
                    <tr>
                        <th>联系人电话:</th>
                        <td>{{$store->ftelephone}}</td>
                    </tr>
                    <tr>
                        <th>渠道分类:</th>
                        <td>{{$store->channel->fname}}</td>
                    </tr>
                    <tr>
                        <th>营业执照:</th>
                        <td>{{$store->fbusslicense}}</td>
                    </tr>
                    <tr>
                        <th>税号:</th>
                        <td>{{$store->fdutyparagraphe}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-6">


            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th>开户银行:</th>
                        <td>{{$store->fbankaccount}}</td>
                    </tr>
                    <tr>
                        <th>账户:</th>
                        <td>{{$store->faccountnum}}</td>
                    </tr>
                    <tr>
                        <th>门店图片:</th>
                        <td><img src="{{$store->image}}" style="width: 200px;height: 160px"></td>
                    </tr>
                    <tr>
                        <th>备注:</th>
                        <td>{{$store->fremark}}</td>
                    </tr>
                    @if(count($store->displayPolicies)>0)
                        <tr>
                            <th>签约门店方案:</th>
                        </tr>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>方案名称</th>
                                <th>签约金额</th>
                            </tr>
                            @foreach($store->displayPolicies as $p)
                                <tr>
                                    <td>{{$p->policy->fsketch}}</td>
                                    <td>{{$p->fsign_amount}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

