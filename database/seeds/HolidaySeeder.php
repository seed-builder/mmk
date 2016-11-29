<?php

use Illuminate\Database\Seeder;
use App\Models\Holiday;
use Carbon\Carbon;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = date('Y');
        //$begin = $year . '-01-01';
         $day = Carbon::create($year, 1, 1);
        for($i = 1; $i <= 365; $i ++){
            if($day->isSaturday() || $day->isSunday()){
//                DB::table('holidays')->insert([
//                    'day' => $day->format('Y-m-d'),
//                    'type' => '1'
//                ]);
                $holiday = Holiday::create([
                    'day' => $day->format('Y-m-d'),
                    'type' => '1'
                ]);
            }
            $day = $day->addDay(1);
        }
    }
}
