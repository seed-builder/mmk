<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewSaleOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<EOD
CREATE
OR REPLACE VIEW view_sale_order AS SELECT
	st_sale_orders.id,
	st_sale_orders.fbill_no,
	st_sale_orders.fstore_id,
	st_sale_orders.fdate,
	st_sale_orders.femp_id,
	st_sale_orders.fcust_id,
	st_sale_orders.fsend_status,
	st_sale_orders.source,
	bd_customers.id AS customer_id,
	bd_customers.fname AS customer_name,
	bd_employees.id AS employee_id,
	bd_employees.fname AS employee_name,
	st_stores.id AS store_id,
	st_stores.ffullname AS store_name
FROM
	st_sale_orders
LEFT JOIN bd_customers ON bd_customers.id = st_sale_orders.fcust_id
LEFT JOIN bd_employees ON bd_employees.id = st_sale_orders.femp_id
LEFT JOIN st_stores ON st_sale_orders.fstore_id = st_stores.id 
	
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
    }
}
