<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-14
 * Time: 15:48
 */

namespace App\Services\DataSync;

use DB;
/**
 * DB 数据处理
 * Class DbWorker
 * @package App\Services
 */
class DbWorker extends Worker
{

	/**
	 * 接收数据
	 * @param $name - 表名
	 * @param $op - 0-新增， 1-修改， 2-条件删除， 3-全表删除
	 * @param array $data - 数据行/条件
	 * @return int
	 */
	public function accept($name, $op, array $data)
	{
		$table = $name;
		// TODO: Implement accept() method.
		$affected = 0;
		if(!empty($data) && !empty($table)) {
			$columns = [];
			$values = [];
			//0-新增， 1-修改， 2-删除
			switch ($op) {
				default:
				case 0:
					$patten = [];
					foreach ($data as $col => $val){
						$columns[] = "`$col`";
						$values[] = $val;
						$patten[] = '?';
					}
					$query = 'insert into '.$table.' ('. implode(',', $columns) .') values ('.implode(',',$patten).')';
					$affected = DB::insert($query, $values);
					break;
				case 1:
					$where = 'id=';
					foreach ($data as $col => $val){
						if($col == 'id'){
							$where .= $val;
							continue;
						}
						$columns[] = "`$col`" . '=?' ;
						$values[] = $val;
					}
					$affected = DB::update('update '.$table.' set '.implode(',', $columns).' where ' . $where, $values);
					break;
				case 2:
					foreach ($data as $col => $val){
						$columns[] = "`$col`" . '=?' ;
						$values[] = $val;
					}
					$affected = DB::delete('delete from ' . $table . ' where ' . implode(' and ', $columns), $values);
					break;
				case 3:
					$affected = DB::delete('delete from ' . $table );
					break;
			}
		}
		return $affected;
	}

	/**
	 * 发送数据
	 * @param $name - 表名
	 * @param $op - 0-新增， 1-修改， 2-删除
	 * @param array $data - 数据行
	 */
	public function send($name, $op, array $data)
	{
		// TODO: Implement send() method.
	}

}