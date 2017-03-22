<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateViewStoreOuts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    $view_store_sends = <<<EOD
create or replace view view_store_sends as
SELECT
	o.fstore_id,
	item.fmaterial_id,
	sum(item.fsend_qty) AS fsend_qty,
	sum(item.fsend_base_qty) AS fsend_base_qty
FROM
	st_sale_order_items item
INNER JOIN st_sale_orders o ON o.id = item.fsale_order_id
GROUP BY
	o.fstore_id,
	item.fmaterial_id
EOD;
	    $view_store_stock_tops = <<<EOD
create or replace view view_store_stock_tops as 
SELECT
	fstore_id,
	fmaterial_id,
	max(ftime) as ftime
FROM
	st_stocks
GROUP BY
	fstore_id,
	fmaterial_id
EOD;
	    $view_store_stocks = <<<EOD
create or replace view view_store_stocks as
SELECT
	s.fstore_id,
	s.fmaterial_id,
	s.ftime,
	s.fhqty + ROUND(s.feqty / m.fratio, 2) as fsale_qty,
	s.feqty + s.fhqty * m.fratio as fbase_qty
FROM
	st_stocks s,
  view_store_stock_tops top,
  bd_materials m  
where s.fstore_id=top.fstore_id and s.fmaterial_id=top.fmaterial_id and s.ftime=top.ftime and s.fmaterial_id=m.id
EOD;

	    $view_store_outs = <<<EOD
create or replace view view_store_outs as
select 
s.fstore_id,
store.fnumber as store_number,
store.ffullname as store_name,
s.fmaterial_id,
m.fnumber as material_number,
m.fname as material_name,
m.fspecification,
m.fsale_unit,
m.fbase_unit,
s.fsend_qty,
s.fsend_base_qty,
o.fsale_qty, 
o.fbase_qty,
s.fsend_base_qty-o.fbase_qty as out_base_qty,
s.fsend_qty-o.fsale_qty as out_qty
from view_store_sends s
LEFT JOIN st_stores store on s.fstore_id=store.id
LEFT JOIN bd_materials m on s.fmaterial_id=m.id
LEFT JOIN view_store_stocks o on s.fstore_id=o.fstore_id and s.fmaterial_id=o.fmaterial_id
EOD;


	    //
	    DB::statement($view_store_sends);
	    DB::statement($view_store_stock_tops);
	    DB::statement($view_store_stocks);
	    DB::statement($view_store_outs);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	    DB::statement('DROP VIEW view_store_outs');
	    DB::statement('DROP VIEW view_store_sends');
	    DB::statement('DROP VIEW view_store_stock_tops');
	    DB::statement('DROP VIEW view_store_stocks ');
    }
}
