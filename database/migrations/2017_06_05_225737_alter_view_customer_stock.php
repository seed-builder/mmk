<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterViewCustomerStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
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

union ALL

select 
c.fcust_id as cust_id,
cust.fname as cust_name,
item.fmaterial_id as material_id,
m.fname as material_name,
m.fnumber as material_number,
m.fspecification as material_specification,
m.fratio,
item.fdiff_hqty as fqty,
item.fdiff_eqty as fbase_qty,
m.fsale_unit,
m.fbase_unit
from
st_stock_check_items item 
INNER JOIN st_stock_checks c on c.id=item.fstock_check_id
INNER JOIN bd_materials m on item.fmaterial_id = m.id
left join bd_customers cust on c.fcust_id = cust.id
;
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
