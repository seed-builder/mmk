<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateViewCustomerStock extends Migration
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
    }
}
