<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewSaleOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $q = <<<EOD
CREATE OR REPLACE VIEW view_sale_order_items AS  
SELECT
e.fname as employee_name,
p.fname as position_name,
o.fcreate_date,
o.fdate,
s.ffullname as store_name,
s.fnumber as store_number,
`f`.`value` AS store_channel,
c.fname as customer_name, 
m.fname as material_name,
i.id,
i.box_qty,
i.bottle_qty,
i.present_box_qty,
i.present_bottle_qty,
i.famount,
i.fsend_status,
o.fsend_date

from st_sale_order_items i
INNER JOIN st_sale_orders o on i.fsale_order_id = o.id
LEFT JOIN bd_employees e on o.femp_id = e.id
LEFT JOIN bd_positions p on e.fpost_id = p.id
LEFT JOIN st_stores s on o.fstore_id = s.id
LEFT JOIN `sys_dics` `f` ON (`s`.`fchannel` = `f`.`key`) AND (`f`.`type` = '渠道分类')
LEFT JOIN bd_customers c on o.fcust_id = c.id
LEFT JOIN bd_materials m on i.fmaterial_id = m.id

EOD;

        DB::statement($q);
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
