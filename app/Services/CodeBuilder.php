<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2016-12-19
 * Time: 16:43
 */

namespace App\Services;

use Philo\Blade\Blade;

class CodeBuilder
{
	const BEGIN_PHP = '<?php';
	protected $blade;
	protected $blade_config;
	protected $outputs;
	protected $table;
	protected $model;
	protected $columns;

	public function __construct($model, $table, $columns)
	{
		$this->table = $table;
		$this->model = ucfirst($model);
		$this->columns = $columns;
		$this->blade_config = config('codebuilder.blade');
		$this->outputs = config('codebuilder.outputs');
		$this->blade = new Blade( $this->blade_config['template'], $this->blade_config['template_cache']);
	}

	/**
	 * create file by templates
	 * @param array $outputs
	 */
	public function createFiles(...$outputs){
		$data = [
			'BEGIN_PHP' => static::BEGIN_PHP,
			'model' => $this->model,
			'table' => $this->table,
			'columns' => $this->columns
		];

		foreach ($this->outputs as $group) {
			if (!empty($outputs) && !in_array($group, $outputs)) {
				continue;
			}
			$ts = config('codebuilder.' . $group);
			foreach ($ts as $viewName => $settings) {
				$name = $this->model;
				if (!empty($settings['name_format']) && function_exists($settings['name_format'])) {
					$name = call_user_func($settings['name_format'], $this->model);
				}
				//var_dump($settings);
				$dir = str_replace('{model}', $name, $settings['path']);
				if(!is_dir($dir)){
					mkdir($dir);
				}
				$fileName = str_replace('{model}', $name, $settings['name_pattern']);

				$filePath = $dir . DIRECTORY_SEPARATOR . $fileName;
				$content = $this->blade->view()->make($group . '.' . $viewName, $data)->render();
				file_put_contents($filePath, $content);
			}
		}
	}

}

