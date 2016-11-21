<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class SwaggerGen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swg:gen {--table=} {--model=}';
    protected $driver ;
    protected $host;
    protected $db ;
    protected $schemaDb = 'information_schema';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate swagger flags';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $table = $this->option('table');
        $model = $this->option('model');

        $conn = $this->getConn();
        $columns = $this->getColumns($conn, $this->db , $table);

        $this->generateModelFlags($columns, $model);

    }

    protected function getConn(){
        $this->driver = config('database.default');
        $this->host = config('database.connections.' . $this->driver . '.host');
        $this->db = config('database.connections.' . $this->driver . '.database');
        $user = config('database.connections.' . $this->driver . '.username');
        $pwd = config('database.connections.' . $this->driver . '.password');

        return new PDO("$this->driver:host=$this->host;dbname=$this->schemaDb;charset=utf8", $user, $pwd);
    }

    protected function getColumns($conn, $db, $table){
        $query = "SELECT * FROM COLUMNS WHERE TABLE_SCHEMA='$db' and table_name='$table' ORDER BY COLUMN_NAME";
        return $conn->query($query);
    }

    protected function generateModelFlags($columns, $model){
        //dump($columns);
        $parameters = [];
        $arr = [];
        $arr[] = '/**';
        $arr[] = ' * Class ' .$model;
        $arr[] = ' * @package App\Models\Busi';
        $arr[] = ' * @author xrs';
        $arr[] = ' * @SWG\Model(id="'.$model.'")';
        foreach ($columns as $col){
            $arr[] = ' * @SWG\Property(name="'.$col['COLUMN_NAME'].'", type="'.$this->getColType($col['COLUMN_TYPE']).'", description="'.$col['COLUMN_COMMENT'].'")';
            $parameters[] = '@SWG\Parameter(name="'.$col['COLUMN_NAME'].'", description="'.$col['COLUMN_COMMENT'].'", required='.$this->getNotNullable($col['IS_NULLABLE']).',type="'.$this->getColType($col['COLUMN_TYPE']).'", paramType="form", defaultValue="'.$col['COLUMN_DEFAULT'].'" ),';
        }
        $arr[] = ' */';

        $this->info('model result is ...');
        foreach ($arr as $s){
            $this->info($s);
        }

        $this->info('parameters result is ...');
        foreach ($parameters as $s){
            $this->info($s);
        }
    }

    protected function generateRouteFlag($columns, $model){
        $arr = [];
        foreach ($columns as $col){
            $arr[] = '@SWG\Parameter(name="'.$col['COLUMN_NAME'].'", description="'.$col['COLUMN_COMMENT'].'", required='.$this->getNotNullable($col['IS_NULLABLE']).',type="'.$this->getColType($col['COLUMN_TYPE']).'", paramType="form", defaultValue="'.$col['COLUMN_DEFAULT'].'" ),';
        }
        $this->info('generateRouteFlag result is ...');
        foreach ($arr as $s){
            $this->info($s);
        }
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
                $t = 'string';
                break;
            case 'int':
                $t = 'integer';
        }
        return $t;
    }

    protected function getNotNullable($able){
        //$this->info('IS_NULLABLE: ' . $able);
        return $able == 'YES' ? 'false':'true';
    }
}
