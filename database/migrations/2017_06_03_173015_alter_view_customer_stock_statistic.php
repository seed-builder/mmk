<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterViewCustomerStockStatistic extends Migration
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
CREATE or replace view view_customer_stock
as 
select 
ins.fcust_id as cust_id,
c.fname as cust_name,
item.fmaterial_id as material_id,
m.fname as material_name,
m.fnumber as material_number,
m.fspecification as material_specification,
m.fratio,
item.fqty,
item.fbase_qty,
item.fsale_unit,
item.fbase_unit
from 
st_stock_in_items item
INNER JOIN st_stock_ins ins on item.fstock_in_id=ins.id
LEFT JOIN bd_customers c on c.id=ins.fcust_id
left JOIN bd_materials m on item.fmaterial_id=m.id

union all 

select 
c.id as cust_id,
c.fname as cust_name,
item.fmaterial_id as material_id,
m.fname as material_name,
m.fnumber as material_number,
m.fspecification as material_specification,
m.fratio,
item.fqty * -1 as fqty,
item.fbase_qty * -1 as fbase_qty,
item.fsale_unit,
item.fbase_unit
from 
st_stock_out_items item
INNER JOIN st_stock_outs outs on item.fstock_out_id=outs.id
LEFT JOIN bd_customers c on c.id=outs.fcust_id
left JOIN bd_materials m on item.fmaterial_id=m.id
EOD;
	    DB::statement($sql);

	    $sql2 = <<<EOD
create or replace view view_customer_stock_statistic
as
SELECT
cust_id, cust_name, material_id,material_name,material_number,material_specification,fratio,fsale_unit, fbase_unit,
sum(fqty) as fqty, sum(fbase_qty) as fbase_qty
from view_customer_stock 
GROUP BY cust_id, cust_name, material_id,material_name,material_number,material_specification,fratio,fsale_unit, fbase_unit
EOD;

	    DB::statement($sql2);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	    DB::statement('DROP VIEW view_customer_stock');
	    DB::statement('DROP VIEW view_customer_stock_statistic');
    }
}
