<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 拍照备注
 * Class VisitPzbz
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="VisitPzbz")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="fbill_no", type="string", description="bill no")
 * @SWG\Property(name="flog_id", type="integer", description="visit_todo_calendar id")
 * @SWG\Property(name="fphoto_id", type="integer", description="picture id")
 * @SWG\Property(name="fremark", type="string", description="备注")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="updated_at", type="string", description="")
 */
class VisitPzbz extends BaseModel
{
    //
	protected $table='visit_pzbz';
}
