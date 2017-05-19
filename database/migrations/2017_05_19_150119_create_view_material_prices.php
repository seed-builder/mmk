<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewMaterialPrices extends Migration
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
CREATE
OR REPLACE VIEW view_material_prices AS SELECT
	p.id,
	p.fmaterial_id,
	p.fprice,
	p.fcheck_date,
	p.fmin_qty,
	p.fmax_qty,
	g.flevel,
	g.fsuit_object,
	CASE fsuit_object
WHEN 'store' THEN
	0
ELSE
	1
END AS fsuit_order,
 g.fbegin,
 g.fend,
 g.fis_all,
 c.id AS customer_id,
 c.fname AS customer_name,
 s.id AS store_id,
 s.ffullname AS store_name
FROM
	bd_prices p
INNER JOIN bd_price_groups g ON p.fgroup_id = g.id
LEFT JOIN bd_price_group_customer gc ON g.id = gc.fgroup_id
LEFT JOIN bd_customers c ON gc.fcustomer_id = c.id
LEFT JOIN bd_price_group_store gs ON g.id = gs.fgroup_id
LEFT JOIN st_stores s ON gs.fstore_id = s.id
WHERE
	p.fdocument_status = 'C'
ORDER BY
	g.fis_all DESC,
	g.fsuit_object DESC,
	g.flevel ASC,
	p.fcreate_date DESC
	
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
