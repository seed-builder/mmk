<?php

namespace App\Console\Commands;

use App\Models\Busi\SaleOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearEmptyOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:empty-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear empty order';

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
        $results = DB::select('select o.id from st_sale_orders o where NOT EXISTS (select 1 from st_sale_order_items item where item.fsale_order_id = o.id)');

        if(!empty($results)){
            $ids = [];
            foreach ($results as $res){
                $ids[] = $res->id;
            }
            SaleOrder::destroy($ids);
        }
    }
}
