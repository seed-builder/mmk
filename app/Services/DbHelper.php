<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2016-12-20
 * Time: 11:57
 */

namespace App\Services;
use PDO;
use App\Models\SysColumn;
use App\Models\SysTable;

class DbHelper{

	private $driver;
	private $host;
	private $db;
	private $schemaDb='information_schema';

	public function __construct()
	{
	}

	protected function getConn(){
		$this->driver = config('database.default');
		$this->host = config('database.connections.' . $this->driver . '.host');
		$this->db = config('database.connections.' . $this->driver . '.database');
		$user = config('database.connections.' . $this->driver . '.username');
		$pwd = config('database.connections.' . $this->driver . '.password');

		return new PDO("$this->driver:host=$this->host;dbname=$this->schemaDb;charset=utf8", $user, $pwd);
	}

	public function getTables(){
		$conn = $this->getConn();
		$db = $this->db;
		$query = "SELECT * FROM `TABLES` WHERE TABLE_SCHEMA='$db' ";
		$rows = $conn->query($query);
		$tables = [];
		foreach ($rows as $row){
			$table = [
				'name' => $row['TABLE_NAME'],
				'desc' => $row['TABLE_NAME'],
				'model_name' => studly_case($row['TABLE_NAME']),
				'engine' => $row['ENGINE']
			];
			$tables[] = new SysTable($table);
		}
		return $tables;
	}

	public function getColumns($table){
		$conn = $this->getConn();
		$db = $this->db;
		$query = "SELECT * FROM COLUMNS WHERE TABLE_SCHEMA='$db' and table_name='$table' ORDER BY COLUMN_NAME";
		$rows = $conn->query($query);
		$cols = [];
		foreach ($rows as $col) {
			$atts  = [
				'name' => $col['COLUMN_NAME'],
				'display' => $col['COLUMN_NAME'],
				'comment' => $col['COLUMN_COMMENT'],
				'data_type' => $this->getColType($col['DATA_TYPE']),
				'is_nullable' => $this->getIsNullable($col['IS_NULLABLE']),
				'default_value' => $col['COLUMN_DEFAULT'],
			];
			$cols[] = new SysColumn($atts);
		}
		return $cols;
	}

	protected function getColType($typ){
		//$this->info('COLUMN_TYPE: ' . $typ);
		$t = 'string';
		$typ = preg_replace('/\(\d+\).*/', '', $typ);
		//$this->info('COLUMN_TYPE replaced: ' . $typ);
		switch ($typ) {
			default:
			case 'varchar':
			case 'char':
			case 'longtext':
			case 'blob':
				$t = 'string';
				break;
			case 'int':
			case 'bigint':
			case 'tinyint':
			case 'smallint':
				$t = 'integer';
				break;
			case 'datetime':
			case 'timestamp':
				$t = 'datetime';
				break;
			case 'decimal':
			case 'double':
				$t = 'number';
				break;
		}
		return $t;
	}

	protected function getIsNullable($able){
		return $able == 'YES' ? true : false;
	}
}