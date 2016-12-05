<?php

use Illuminate\Database\Seeder;
use App\Models\ModelMap;

class ModelMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entities = ModelMap::all();
        if(!empty($entities)) {
            $entities->each(function ($item) {
                $item->delete();
            });
        }
        //
        ModelMap::create([
            'model' => 'Employee',
            'table' => 'bd_employees',
            'foreign_table' => 'bd_employees'
        ]);
        ModelMap::create([
            'model' => 'Attendance',
            'table' => 'ms_attendances',
            'foreign_table' => 'ms_attendances'
        ]);
        ModelMap::create([
            'model' => 'Store',
            'table' => 'st_stores',
            'foreign_table' => 'st_stores'
        ]);
        ModelMap::create([
            'model' => 'VisitLineCalendar',
            'table' => 'visit_line_calendar',
            'foreign_table' => 'visit_line_calendar'
        ]);
        ModelMap::create([
            'model' => 'VisitStoreCalendar',
            'table' => 'visit_store_calendar',
            'foreign_table' => 'visit_store_calendar'
        ]);
        ModelMap::create([
            'model' => 'VisitTodoCalendar',
            'table' => 'visit_todo_calendar',
            'foreign_table' => 'visit_todo_calendar'
        ]);
    }
}
