<?php

use App\Models\Busi\WorkFlow;
use App\Models\Busi\WorkFlowLink;
use App\Models\Busi\WorkFlowNode;
use App\Models\Busi\WorkFlowVariable;
use Illuminate\Database\Seeder;

class WorkFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //费用签约 工作流定义
	    $c = WorkFlow::where('name', 'exp_display_policy_store')->count();
	    if($c == 0){
		    $wf = WorkFlow::create([
		    	'name' => 'exp_display_policy_store',
			    'desc' => '费用签约',
			    'status' => 1,
			    'uid' => uuid(),
			    'msg_template' => '【{creator}】新增费用编号【{policy_sn}】签约门店【{store_name}】 签约金额【{amount}】'
		    ]);
			//variables
		    $v1 = WorkFlowVariable::create([
			    'work_flow_id' => $wf->id,
			    'name' => 'data',
			    'display_name' => '门店签约信息',
			    'data_type' => 'App\Models\Busi\DisplayPolicyStore',
			    'category' => 1,
			    'uid' => uuid(),
		    ]);
//		    $v2 = WorkFlowVariable::create([
//			    'work_flow_id' => $wf->id,
//			    'name' => 'store_id',
//			    'display_name' => '门店id',
//			    'data_type' => 'int',
//			    'value' => 0,
//			    'category' => 1,
//			    'uid' => uuid(),
//		    ]);

		    $nf = WorkFlowNode::create([
			    'work_flow_id' => $wf->id,
			    'type' => 'F',
			    'title' => '开始',
			    'uid' => uuid(),
		    ]);
		    $nc = WorkFlowNode::create([
			    'work_flow_id' => $wf->id,
			    'type' => 'C',
			    'approver_type' => 2,
			    'title' => '上级审批'
		    ]);
		    $nl = WorkFlowNode::create([
			    'work_flow_id' => $wf->id,
			    'type' => 'L',
			    'title' => '结束',
			    'uid' => uuid(),
		    ]);

		    $link1 = WorkFlowLink::create([
			    'work_flow_id' => $wf->id,
			    'source_node_id' => $nf->id,
			    'target_node_id' => $nc->id,
			    'uid' => uuid(),
		    ]);
		    $link2= WorkFlowLink::create([
			    'work_flow_id' => $wf->id,
			    'source_node_id' => $nc->id,
			    'target_node_id' => $nl->id,
			    'condition' => '@@approved==1',
			    'uid' => uuid(),
		    ]);
	    }

    }
}
