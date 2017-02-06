<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="Employee")
 * @SWG\Property(name="faddress", type="string", description="faddress")
 * @SWG\Property(name="fauditor_id", type="string", description="fauditor_id")
 * @SWG\Property(name="faudit_date", type="string", description="faudit_date")
 * @SWG\Property(name="fcreate_date", type="string", description="fcreate_date")
 * @SWG\Property(name="fcreator_id", type="string", description="fcreator_id")
 * @SWG\Property(name="fdept_id", type="string", description="fdept_id")
 * @SWG\Property(name="fdocument_status", type="string", description="fdocument_status")
 * @SWG\Property(name="femail", type="string", description="femail")
 * @SWG\Property(name="femp_num", type="string", description="femp_num")
 * @SWG\Property(name="fforbidder_id", type="string", description="fforbidder_id")
 * @SWG\Property(name="fforbid_date", type="string", description="fforbid_date")
 * @SWG\Property(name="fforbid_status", type="string", description="fforbid_status")
 * @SWG\Property(name="fmodify_date", type="string", description="fmodify_date")
 * @SWG\Property(name="fmodify_id", type="string", description="fmodify_id")
 * @SWG\Property(name="fname", type="string", description="fname")
 * @SWG\Property(name="fnumber", type="string", description="fnumber")
 * @SWG\Property(name="fpassword", type="string", description="fpassword")
 * @SWG\Property(name="fphone", type="string", description="fphone")
 * @SWG\Property(name="fphoto", type="string", description="fphoto")
 * @SWG\Property(name="fpost_id", type="string", description="fpost_id")
 * @SWG\Property(name="fremark", type="string", description="fremark")
 * @SWG\Property(name="id", type="string", description="id")
 * @SWG\Property(name="login_time", type="string", description="登陆次数")
 * @SWG\Property(name="device", type="string", description="设备号")
 * @SWG\Property(name="forg_id", type="string", description="组织id")
 * @SWG\Property(name="fstart_date", type="string", description="入职日期")
 */
class Employee extends BaseModel
{
    //
    protected $table = 'bd_employees';
    
    protected $with = ['organization','department','position'];
    
    public $validateRules=['fname' => 'required', 'fphone' => 'required'];

    public function organization(){
        return $this->hasOne(Organization::class, 'id', 'forg_id');
    }

    public function department(){
        return $this->hasOne(Department::class, 'id', 'fdept_id');
    }

    public function position(){
        return $this->hasOne(Position::class, 'id', 'fpost_id');
    }

    public function getSenior(){
        $position = $this->position;
        //$psenior = $this->position->senior;
        if(empty($position->senior)){
           return [];
        }
        return static::where('fpost_id', $position->senior->id)->first();
    }
}
