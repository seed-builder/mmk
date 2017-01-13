<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

class WorkCalendarData extends BaseModel
{
    //
	protected $table = 'eng_work_calendar_data';

	public function shift(){
		return $this->belongsTo(WorkCalendarShift::class, 'fshift_id');
	}
}
