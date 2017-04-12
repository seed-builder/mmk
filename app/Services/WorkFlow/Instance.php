<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-10
 * Time: 15:58
 */

namespace App\Services\WorkFlow;

use App\Models\Busi\WorkFlowInstance;
use App\Models\Busi\WorkFlowVariable;

/**
 * 工作流实例
 * Class Instance
 * @package App\Services\WorkFlow
 */
class Instance
{
	use HasEvents;

	protected $variables;
	protected $work_flow_instance;
	protected $sponsor;
	protected $workflow;

	public function __construct()
	{
	}

	public function init($id)
	{
		$this->work_flow_instance = WorkFlowInstance::find($id);
		$this->sponsor = new Sponsor($this->work_flow_instance->sponsor_id);
		$this->variables = [];
		if(!empty($this->work_flow_instance->variables)){
			foreach ($this->work_flow_instance->variables as $variable){
				$this->variables[$variable->name] = json_decode($variable->value, true);
			}
		}
	}

	protected function create(Sponsor $sponsor, WorkFlow $workflow){
		$billNo = $this->genBillNo($workflow->id);
		$title =  $this->parse($workflow->msg_template, $this->variables);
		$this->work_flow_instance = WorkFlowInstance::create([
			'work_flow_id' => $workflow->id,
			'sponsor_id' => $sponsor->id,
			'sponsor' => $sponsor->nick_name,
			'bill_no' => $billNo,
			'title' => $title
		]);
		$this->sponsor = $sponsor;
	}

	/**
	 * 启动新的实例
	 * @param WorkFlow $workflow
	 * @param Sponsor $sponsor
	 * @param $variables
	 * @return bool
	 */
	public function start(WorkFlow $workflow, Sponsor $sponsor, $variables){
		$this->variables = $variables;
		$this->workflow = $workflow;
		if ($this->fireEvent('starting', true) === false) {
			return false;
		}
		$this->create($sponsor, $workflow);
		$this->saveVariables($variables);
		$this->fireEvent('started');
	}

	/**
	 * 结束实例
	 * @param int $status
	 * @return bool
	 */
	public function terminate($status = 1){
		if ($this->fireEvent('terminating', true) === false) {
			return false;
		}
		$this->work_flow_instance->update(['status' => $status]);
		$this->fireEvent('terminated');
	}

	/**
	 * 挂起实例
	 */
	public function suspend(){
		if ($this->fireEvent('suspending', true) === false) {
			return false;
		}
		$this->work_flow_instance->update(['status' => 2]);
		$this->fireEvent('suspended');
	}

	/**
	 * 恢复实例
	 */
	public function resume(){
		if ($this->fireEvent('resuming', true) === false) {
			return false;
		}
		$this->work_flow_instance->update(['status' => 0]);
		$this->fireEvent('resumed');
	}

	/**
	 * 生成单号
	 * @param $work_flow_id
	 * @return string
	 */
	protected function genBillNo($work_flow_id){
		$count = WorkFlowInstance::where('work_flow_id', $work_flow_id)->count();
		$count ++;
		return 'WF-'. $work_flow_id .'-'. date('Ymd').'-'. sprintf('%05d', $count);
	}

	/**
	 * 保存变量
	 * @param array $variables
	 */
	public function saveVariables($variables=[]){
		if(!empty($variables)){
			foreach ($variables as $name => $value){
				$variable = $this->work_flow_instance->variables()->where('name', $name)->first();
				if(!empty($variable)){
					$variable->update(['value' => json_encode($value)]);
				} else {
					$variable = WorkFlowVariable::where('work_flow_id', $this->work_flow_instance->work_flow_id)
						->where('name', $name)
						->first();
					if (!empty($variable)) {
						$this->work_flow_instance->variables()->create([
							'work_flow_variable_id' => $variable->id,
							'name' => $name,
							'value' => json_encode($value),
						]);
					}
				}
			}
			$this->fireEvent('variables-saved', false);
		}
	}

	public function getId(){
		return $this->work_flow_instance->id;
	}

	public function getWorkFlowId(){
		return $this->work_flow_instance->work_flow_id;
	}

	public function getSponsor(){
		return $this->sponsor;
	}

	public function getWorkFlowInstance(){
		return $this->work_flow_instance;
	}

	/**
	 * Get the observable event names.
	 *
	 * @return array
	 */
	public function getObservableEvents()
	{
		return [
			'starting','started',
			'terminating','terminated',
			'suspending','suspended',
			'resuming','resumed',
			'variables-saved',
		];
	}

	public static function starting($callback){
		static::registerEvent('starting', $callback);
	}

	public static function started($callback){
		static::registerEvent('started', $callback);
	}

	public static function terminating($callback){
		static::registerEvent('terminating', $callback);
	}

	public static function terminated($callback){
		static::registerEvent('terminated', $callback);
	}

	public static function suspending($callback){
		static::registerEvent('suspending', $callback);
	}

	public static function suspended($callback){
		static::registerEvent('suspended', $callback);
	}

	public static function resuming($callback){
		static::registerEvent('resuming', $callback);
	}

	public static function resumed($callback){
		static::registerEvent('resumed', $callback);
	}

	public static function variablesSaved($callback){
		static::registerEvent('variables-saved', $callback);
	}

	protected function parse($template, $variables){
		$result = $template;
		foreach ($variables as $key => $val){
			$result = str_replace('{'.$key.'}', $val, $result);
		}
		//$result = eval('return '. $template . ';');
		return $result;
	}

	public function __get($name)
	{
		// TODO: Implement __get() method.
		return $this->work_flow_instance->{$name} ?: null;
	}


}