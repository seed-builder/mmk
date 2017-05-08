<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexForDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('attendance_reports', function (Blueprint $table) {
		    $table->index('femp_id', 'attendance_reports_indx_femp_id');
		    $table->index('fyear', 'attendance_reports_indx_fyear');
		    $table->index('fmonth', 'attendance_reports_indx_fmonth');
	    });

	    Schema::table('attendance_statistics', function (Blueprint $table) {
		    $table->index('femp_id', 'attendance_statistics_indx_femp_id');
		    $table->index('fyear', 'attendance_statistics_indx_fyear');
		    $table->index('fmonth', 'attendance_statistics_indx_fmonth');
		    $table->index('fday', 'attendance_statistics_indx_fday');
	    });

	    Schema::table('bd_customers', function (Blueprint $table) {
		    $table->index('fname', 'bd_customers_indx_fname');
	    });

	    Schema::table('bd_employees', function (Blueprint $table) {
		    $table->index('fdept_id', 'bd_employees_indx_fdept_id');
		    $table->index('fpost_id', 'bd_employees_indx_fpost_id');
		    $table->index('fname', 'bd_employees_indx_fname');
		    $table->index('fphone', 'bd_employees_indx_fphone');
	    });

	    Schema::table('bd_positions', function (Blueprint $table) {
		    $table->index('flag', 'bd_positions_indx_flag');
	    });

//	    Schema::table('citys', function (Blueprint $table) {
//		    $table->index('MergerName', 'citys_indx_MergerName');
//	    });

	    Schema::table('exp_display_policy_store', function (Blueprint $table) {
		    $table->index('fpolicy_id', 'policy_store_indx_fpolicy_id');
		    $table->index('femp_id', 'policy_store_indx_femp_id');
		    $table->index('fstart_date', 'policy_store_indx_fstart_date');
		    $table->index('fend_date', 'policy_store_indx_fend_date');
	    });

	    Schema::table('ms_attendances', function (Blueprint $table) {
		    $table->index('femp_id', 'ms_attendances_indx_femp_id');
		    $table->index('ftime', 'ms_attendances_indx_ftime');
	    });

	    Schema::table('st_sale_order_items', function (Blueprint $table) {
		    $table->index('fsale_order_id', 'order_items_indx_fsale_order_id');
	    });

	    Schema::table('st_sale_orders', function (Blueprint $table) {
		    $table->index('fstore_id', 'orders_indx_fstore_id');
		    $table->index('femp_id', 'orders_indx_femp_id');
		    $table->index('fcust_id', 'orders_indx_fcust_id');
		    $table->index('fdate', 'orders_indx_fdate');
	    });

	    Schema::table('st_stock_in_items', function (Blueprint $table) {
		    $table->index('fstock_in_id', 'stockin_items_indx_fstock_in_id');
	    });

	    Schema::table('st_stock_ins', function (Blueprint $table) {
		    $table->index('fstore_id', 'stockins_indx_fstore_id');
		    $table->index('fcust_id', 'stockins_indx_fcust_id');
		    $table->index('fin_date', 'stockins_indx_fin_date');
	    });

	    Schema::table('st_stock_out_items', function (Blueprint $table) {
		    $table->index('fstock_out_id', 'stockout_items_indx_fstock_out_id');
	    });

	    Schema::table('st_stock_outs', function (Blueprint $table) {
		    $table->index('fstore_id', 'stockouts_indx_fstore_id');
		    $table->index('fcust_id', 'stockouts_indx_fcust_id');
		    $table->index('fdate', 'stockouts_indx_fdate');
	    });

	    Schema::table('st_stocks', function (Blueprint $table) {
		    $table->index('fstore_id', 'stocks_indx_fstore_id');
		    $table->index('fmaterial_id', 'stocks_indx_fmaterial_id');
		    $table->index('ftime', 'stocks_indx_ftime');
		    $table->index('femp_id', 'stocks_indx_femp_id');
	    });

	    Schema::table('st_stores', function (Blueprint $table) {
		    $table->index('fcust_id', 'stores_indx_fcust_id');
		    $table->index('ffullname', 'stores_indx_ffullname');
		    $table->index('femp_id', 'stores_indx_femp_id');
	    });

	    Schema::table('sys_dics', function (Blueprint $table) {
		    $table->index('type', 'dics_indx_type');
	    });

	    Schema::table('visit_line_calendar', function (Blueprint $table) {
		    $table->index('fdate', 'visit_line_calendar_indx_fdate');
		    $table->index('femp_id', 'visit_line_calendar_indx_femp_id');
		    $table->index('fline_id', 'visit_line_calendar_indx_fline_id');
	    });

	    Schema::table('visit_pzbz', function (Blueprint $table) {
		    $table->index('flog_id', 'visit_pzbz_indx_flog_id');
	    });

	    Schema::table('visit_store_calendar', function (Blueprint $table) {
		    $table->index('fdate', 'visit_store_calendar_indx_fdate');
		    $table->index('femp_id', 'visit_store_calendar_indx_femp_id');
		    $table->index('fline_calendar_id', 'visit_store_calendar_indx_fline_calendar_id');
		    $table->index('fstore_id', 'visit_store_calendar_indx_fstore_id');
	    });

	    Schema::table('visit_todo_calendar', function (Blueprint $table) {
		    $table->index('fdate', 'visit_todo_calendar_indx_fdate');
		    $table->index('femp_id', 'visit_todo_calendar_indx_femp_id');
		    $table->index('fstore_calendar_id', 'visit_todo_calendar_indx_fstore_calendar_id');
		    $table->index('ftodo_id', 'visit_todo_calendar_indx_ftodo_id');
		    $table->index('fparent_id', 'visit_todo_calendar_indx_fparent_id');
	    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	    Schema::table('attendance_reports', function (Blueprint $table) {
		    $table->dropIndex('attendance_reports_indx_femp_id');
		    $table->dropIndex('attendance_reports_indx_fyear');
		    $table->dropIndex('attendance_reports_indx_fmonth');
	    });

	    Schema::table('attendance_statistics', function (Blueprint $table) {
		    $table->dropIndex('attendance_statistics_indx_femp_id');
		    $table->dropIndex('attendance_statistics_indx_fyear');
		    $table->dropIndex('attendance_statistics_indx_fmonth');
		    $table->dropIndex('attendance_statistics_indx_fday');
	    });

	    Schema::table('bd_customers', function (Blueprint $table) {
		    $table->dropIndex('bd_customers_indx_fname');
	    });

	    Schema::table('bd_employees', function (Blueprint $table) {
		    $table->dropIndex('bd_employees_indx_fdept_id');
		    $table->dropIndex('bd_employees_indx_fpost_id');
		    $table->dropIndex('bd_employees_indx_fname');
		    $table->dropIndex('bd_employees_indx_fphone');
	    });

	    Schema::table('bd_positions', function (Blueprint $table) {
		    $table->dropIndex( 'bd_positions_indx_flag');
	    });

	    Schema::table('citys', function (Blueprint $table) {
		    $table->dropIndex('citys_indx_MergerName');
	    });

	    Schema::table('exp_display_policy_store', function (Blueprint $table) {
		    $table->dropIndex('policy_store_indx_fpolicy_id');
		    $table->dropIndex('policy_store_indx_femp_id');
		    $table->dropIndex('policy_store_indx_fstart_date');
		    $table->dropIndex('policy_store_indx_fend_date');
	    });

	    Schema::table('ms_attendances', function (Blueprint $table) {
		    $table->dropIndex('ms_attendances_indx_femp_id');
		    $table->dropIndex('ms_attendances_indx_ftime');
	    });

	    Schema::table('st_sale_order_items', function (Blueprint $table) {
		    $table->dropIndex('order_items_indx_fsale_order_id');
	    });

	    Schema::table('st_sale_orders', function (Blueprint $table) {
		    $table->dropIndex('orders_indx_fstore_id');
		    $table->dropIndex('orders_indx_femp_id');
		    $table->dropIndex('orders_indx_fcust_id');
		    $table->dropIndex('orders_indx_fdate');
	    });

	    Schema::table('st_stock_in_items', function (Blueprint $table) {
		    $table->dropIndex('stockin_items_indx_fstock_in_id');
	    });

	    Schema::table('st_stock_ins', function (Blueprint $table) {
		    $table->dropIndex('stockins_indx_fstore_id');
		    $table->dropIndex('stockins_indx_fcust_id');
		    $table->dropIndex('stockins_indx_fin_date');
	    });

	    Schema::table('st_stock_out_items', function (Blueprint $table) {
		    $table->dropIndex('stockout_items_indx_fstock_out_id');
	    });

	    Schema::table('st_stock_outs', function (Blueprint $table) {
		    $table->dropIndex('stockouts_indx_fstore_id');
		    $table->dropIndex('stockouts_indx_fcust_id');
		    $table->dropIndex('stockouts_indx_fdate');
	    });

	    Schema::table('st_stocks', function (Blueprint $table) {
		    $table->dropIndex('stocks_indx_fstore_id');
		    $table->dropIndex('stocks_indx_fmaterial_id');
		    $table->dropIndex('stocks_indx_ftime');
		    $table->dropIndex('stocks_indx_femp_id');
	    });

	    Schema::table('st_stores', function (Blueprint $table) {
		    $table->dropIndex('stores_indx_fcust_id');
		    $table->dropIndex('stores_indx_ffullname');
		    $table->dropIndex('stores_indx_femp_id');
	    });

	    Schema::table('sys_dics', function (Blueprint $table) {
		    $table->dropIndex('dics_indx_type');
	    });

	    Schema::table('visit_line_calendar', function (Blueprint $table) {
		    $table->dropIndex('visit_line_calendar_indx_fdate');
		    $table->dropIndex('visit_line_calendar_indx_femp_id');
		    $table->dropIndex('visit_line_calendar_indx_fline_id');
	    });

	    Schema::table('visit_pzbz', function (Blueprint $table) {
		    $table->dropIndex('visit_pzbz_indx_flog_id');
	    });

	    Schema::table('visit_store_calendar', function (Blueprint $table) {
		    $table->dropIndex('visit_store_calendar_indx_fdate');
		    $table->dropIndex('visit_store_calendar_indx_femp_id');
		    $table->dropIndex('visit_store_calendar_indx_fline_calendar_id');
		    $table->dropIndex('visit_store_calendar_indx_fstore_id');
	    });

	    Schema::table('visit_todo_calendar', function (Blueprint $table) {
		    $table->dropIndex('visit_todo_calendar_indx_fdate');
		    $table->dropIndex('visit_todo_calendar_indx_femp_id');
		    $table->dropIndex('visit_todo_calendar_indx_fstore_calendar_id');
		    $table->dropIndex('visit_todo_calendar_indx_ftodo_id');
		    $table->dropIndex('visit_todo_calendar_indx_fparent_id');
	    });

    }
}
