<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewCustomerStockStatistic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    $sql = <<<EOD
create or replace view view_customer_stock_statistic
as
SELECT
cust_id, cust_name, material_id,material_name,material_number,material_specification,fsale_unit, fbase_unit,
sum(fqty) as fqty, sum(fbase_qty) as fbase_qty
from view_customer_stock 
GROUP BY cust_id, cust_name, material_id,material_name,material_number,material_specification,fsale_unit, fbase_unit
EOD;

	    DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	    DB::statement('DROP VIEW view_customer_stock_statistic');
    }
}
