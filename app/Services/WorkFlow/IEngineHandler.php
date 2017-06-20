<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-06-13
 * Time: 14:17
 */

namespace App\Services\WorkFlow;


interface IEngineHandler
{
	public function variablesSaving(Instance $instance, $variables);
	public function variablesSaved(Instance $instance);
	public function terminating(Task $task);
	public function terminated(Instance $instance);

}